<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Email atau password tidak sesuai.'])
                ->onlyInput('email');
        }

        // Check if user is approved (except superadmin)
        $user = Auth::user();
        $request->session()->regenerate();

        // Redirect to verification page if not approved or verification data not complete
        if ($user->role === 'contributor' && !$user->is_approved) {
            // Check if verification data is complete
            if (!$user->phone || !$user->address || !$user->birth_place || !$user->birth_date || !$user->gender || !$user->occupation || !$user->ktp_file) {
                return redirect()->route('admin.verification')
                    ->with('error', 'Silakan lengkapi data verifikasi terlebih dahulu.');
            }
            return redirect()->route('admin.verification');
        }

        return redirect()->intended(route('admin.dashboard'));
    }

    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'contributor',
            'is_approved' => false, // Requires superadmin approval
        ]);

        return redirect()
            ->route('admin.login')
            ->with('status', 'Pendaftaran berhasil! Akun Anda menunggu persetujuan dari superadmin. Anda akan dihubungi setelah akun disetujui.');
    }

    public function verification(): RedirectResponse|View
    {
        $user = Auth::user();
        
        // Refresh user data from database
        $user->refresh();
        
        // Redirect to dashboard if already approved or superadmin
        if ($user->role === 'superadmin' || $user->is_approved) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Akun Anda sudah aktif! Selamat datang di dashboard.');
        }
        
        return view('auth.verification', compact('user'));
    }

    public function submitVerification(Request $request): RedirectResponse
    {
        $user = Auth::user();
        
        // Check if already approved
        if ($user->role === 'superadmin' || $user->is_approved) {
            return redirect()->route('admin.dashboard');
        }

        // Validate all required fields
        // KTP is required only if not already uploaded
        $ktpRequired = !$user->ktp_file ? 'required|' : '';
        
        $validated = $request->validate([
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'birth_place' => 'required|string|max:100',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
            'occupation' => 'required|string|max:100',
            'ktp_file' => $ktpRequired . 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ], [
            'phone.required' => 'Nomor HP wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'birth_place.required' => 'Tempat lahir wajib diisi.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'occupation.required' => 'Pekerjaan wajib diisi.',
            'ktp_file.required' => 'Foto KTP wajib diupload.',
            'ktp_file.image' => 'File harus berupa gambar.',
            'ktp_file.mimes' => 'Format file harus jpeg, png, atau jpg.',
            'ktp_file.max' => 'Ukuran file maksimal 5MB.',
        ]);

        // Handle KTP file upload
        if ($request->hasFile('ktp_file')) {
            // Delete old KTP if exists
            if ($user->ktp_file && Storage::disk('public')->exists(str_replace('/storage/', '', $user->ktp_file))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $user->ktp_file));
            }
            
            $ktpFile = $request->file('ktp_file');
            $ktpFileName = 'ktp_' . $user->id . '_' . time() . '.' . $ktpFile->getClientOriginalExtension();
            $ktpPath = $ktpFile->storeAs('uploads/ktp', $ktpFileName, 'public');
            $validated['ktp_file'] = '/storage/' . $ktpPath;
        } else {
            // Keep existing KTP if not uploading new one
            $validated['ktp_file'] = $user->ktp_file;
        }

        // Update user data
        $validated['verification_submitted_at'] = now();
        $user->update($validated);

        return redirect()->route('admin.verification')
            ->with('status', 'Data verifikasi berhasil dikirim! Silakan tunggu persetujuan dari superadmin.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
