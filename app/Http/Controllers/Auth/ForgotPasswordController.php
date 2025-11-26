<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    /**
     * Display the forgot password form
     */
    public function showForgotPasswordForm(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle the forgot password form submission
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.'
        ]);

        // For security, we don't reveal whether the email exists or not
        return back()->with('status', 'Jika email terdaftar sebagai kontributor, silakan hubungi superadmin untuk reset password.');
    }
}