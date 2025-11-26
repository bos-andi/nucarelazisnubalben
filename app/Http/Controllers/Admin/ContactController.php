<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSetting;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        $contact = ContactSetting::getSettings();
        return view('admin.contact.index', compact('contact'));
    }

    public function update(Request $request): RedirectResponse
    {
        $contact = ContactSetting::getSettings();

        $validatedData = $request->validate([
            'header_subtitle' => 'required|string|max:255',
            'header_title' => 'required|string|max:255',
            'header_description' => 'required|string',
            'office_title' => 'required|string|max:255',
            'office_address' => 'required|string',
            'office_hours' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'instagram' => 'required|string|max:255',
            'facebook' => 'required|string|max:255',
            'whatsapp_number' => 'required|string|max:20',
            'whatsapp_text' => 'required|string|max:255',
            'map_embed_url' => 'nullable|url',
            'show_map' => 'boolean',
            'form_subtitle' => 'required|string|max:255',
            'form_title' => 'required|string|max:255',
            'form_description' => 'required|string',
            'form_action_url' => 'nullable|url',
            'form_enabled' => 'boolean',
            'is_active' => 'boolean',
        ], [
            'header_subtitle.required' => 'Subtitle header wajib diisi.',
            'header_title.required' => 'Judul header wajib diisi.',
            'header_description.required' => 'Deskripsi header wajib diisi.',
            'office_title.required' => 'Judul kantor wajib diisi.',
            'office_address.required' => 'Alamat kantor wajib diisi.',
            'office_hours.required' => 'Jam operasional wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'instagram.required' => 'Instagram wajib diisi.',
            'facebook.required' => 'Facebook wajib diisi.',
            'whatsapp_number.required' => 'Nomor WhatsApp wajib diisi.',
            'whatsapp_text.required' => 'Teks tombol WhatsApp wajib diisi.',
            'map_embed_url.url' => 'URL embed map harus berupa URL yang valid.',
            'form_subtitle.required' => 'Subtitle form wajib diisi.',
            'form_title.required' => 'Judul form wajib diisi.',
            'form_description.required' => 'Deskripsi form wajib diisi.',
            'form_action_url.url' => 'URL action form harus berupa URL yang valid.',
        ]);

        // Handle checkboxes
        $validatedData['show_map'] = $request->has('show_map');
        $validatedData['form_enabled'] = $request->has('form_enabled');
        $validatedData['is_active'] = $request->has('is_active');

        $contact->update($validatedData);

        return redirect()
            ->route('admin.contact.index')
            ->with('success', 'Pengaturan kontak berhasil diperbarui.');
    }
}