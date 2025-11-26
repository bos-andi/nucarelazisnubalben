<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProfileController extends Controller
{
    public function show(): View
    {
        return view('admin.profile.show', [
            'user' => auth()->user()
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,bmp,tiff|max:5120',
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update basic info
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists(str_replace('/storage/', '', $user->avatar))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $user->avatar));
            }
            
            $user->avatar = $this->uploadAndResizeAvatar($request->file('avatar'));
        }

        // Handle password change
        if ($request->filled('password')) {
            if (!$request->filled('current_password') || !Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak benar.']);
            }
            
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()
            ->route('admin.profile.show')
            ->with('status', 'Profil berhasil diperbarui.');
    }

    private function uploadAndResizeAvatar($file): string
    {
        $filename = 'avatar_' . auth()->id() . '_' . time() . '.jpg';
        
        // Create image manager with GD driver
        $manager = new ImageManager(new Driver());
        
        // Read and resize image
        $image = $manager->read($file);
        $image->cover(200, 200);
        
        // Store the image
        $path = 'uploads/avatars/' . $filename;
        Storage::disk('public')->put($path, $image->toJpeg(90));
        
        return Storage::url($path);
    }
}
