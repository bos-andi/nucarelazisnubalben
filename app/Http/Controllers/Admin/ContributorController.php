<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ContributorController extends Controller
{
    public function index(): View
    {
        $pendingContributors = User::pendingApproval()->latest()->get();
        $approvedContributors = User::approved()->where('role', 'contributor')->latest()->get();

        return view('admin.contributors.index', compact('pendingContributors', 'approvedContributors'));
    }

    public function approve(Request $request, User $user): RedirectResponse
    {
        if ($user->role !== 'contributor') {
            return back()->withErrors(['error' => 'Hanya kontributor yang bisa disetujui.']);
        }

        if ($user->is_approved) {
            return back()->withErrors(['error' => 'Kontributor sudah disetujui sebelumnya.']);
        }

        $user->update([
            'is_approved' => true,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('status', "Kontributor {$user->name} berhasil disetujui.");
    }

    public function reject(Request $request, User $user): RedirectResponse
    {
        if ($user->role !== 'contributor') {
            return back()->withErrors(['error' => 'Hanya kontributor yang bisa ditolak.']);
        }

        if ($user->is_approved) {
            return back()->withErrors(['error' => 'Kontributor yang sudah disetujui tidak bisa ditolak.']);
        }

        $user->delete();

        return back()->with('status', "Pendaftaran kontributor {$user->name} berhasil ditolak dan dihapus.");
    }

    public function revoke(Request $request, User $user): RedirectResponse
    {
        if ($user->role !== 'contributor') {
            return back()->withErrors(['error' => 'Hanya kontributor yang bisa dicabut persetujuannya.']);
        }

        if (!$user->is_approved) {
            return back()->withErrors(['error' => 'Kontributor belum disetujui.']);
        }

        $user->update([
            'is_approved' => false,
            'approved_by' => null,
            'approved_at' => null,
        ]);

        return back()->with('status', "Persetujuan kontributor {$user->name} berhasil dicabut.");
    }

    public function resetPassword(Request $request, User $user): RedirectResponse
    {
        if ($user->role !== 'contributor') {
            return back()->withErrors(['error' => 'Hanya password kontributor yang bisa direset.']);
        }

        // Generate random password
        $newPassword = Str::random(12);
        
        // Update password
        $user->update([
            'password' => Hash::make($newPassword)
        ]);

        return back()->with([
            'status' => "Password kontributor {$user->name} berhasil direset.",
            'new_password' => $newPassword,
            'reset_user' => $user->name
        ]);
    }

    public function changePassword(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if ($user->role !== 'contributor') {
            return back()->withErrors(['error' => 'Hanya password kontributor yang bisa diubah.']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('status', "Password kontributor {$user->name} berhasil diubah.");
    }

    public function verifyKtp(Request $request, User $user): RedirectResponse
    {
        if ($user->role !== 'contributor') {
            return back()->withErrors(['error' => 'Hanya kontributor yang bisa diverifikasi KTP-nya.']);
        }

        if (!$user->ktp_file) {
            return back()->withErrors(['error' => 'Kontributor belum mengupload KTP.']);
        }

        if ($user->is_ktp_verified) {
            return back()->withErrors(['error' => 'KTP sudah terverifikasi sebelumnya.']);
        }

        $user->update([
            'is_ktp_verified' => true,
            'ktp_verified_by' => auth()->id(),
            'ktp_verified_at' => now(),
        ]);

        return back()->with('status', "KTP kontributor {$user->name} berhasil diverifikasi.");
    }

    public function unverifyKtp(Request $request, User $user): RedirectResponse
    {
        if ($user->role !== 'contributor') {
            return back()->withErrors(['error' => 'Hanya kontributor yang bisa dicabut verifikasi KTP-nya.']);
        }

        if (!$user->is_ktp_verified) {
            return back()->withErrors(['error' => 'KTP belum terverifikasi.']);
        }

        $user->update([
            'is_ktp_verified' => false,
            'ktp_verified_by' => null,
            'ktp_verified_at' => null,
        ]);

        return back()->with('status', "Verifikasi KTP kontributor {$user->name} berhasil dicabut.");
    }
}