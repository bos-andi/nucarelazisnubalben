<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SettingsController extends Controller
{
    public function index(): View
    {
        $settings = SiteSetting::all()->keyBy('key');
        
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'site_title' => 'required|string|max:255',
            'site_subtitle' => 'required|string|max:255',
            'hero_title' => 'required|string|max:500',
            'hero_description' => 'required|string|max:1000',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg,bmp,tiff|max:5120',
            'site_favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,ico,bmp|max:2048',
        ]);

        // Update text settings
        SiteSetting::set('site_title', $request->site_title);
        SiteSetting::set('site_subtitle', $request->site_subtitle);
        SiteSetting::set('hero_title', $request->hero_title, 'text', 'homepage');
        SiteSetting::set('hero_description', $request->hero_description, 'textarea', 'homepage');

        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            // Delete old logo if exists
            $oldLogo = SiteSetting::get('site_logo');
            if ($oldLogo && Storage::disk('public')->exists(str_replace('/storage/', '', $oldLogo))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $oldLogo));
            }
            
            $logoUrl = $this->uploadLogo($request->file('site_logo'));
            SiteSetting::set('site_logo', $logoUrl, 'image');
        }

        // Handle favicon upload
        if ($request->hasFile('site_favicon')) {
            // Delete old favicon if exists
            $oldFavicon = SiteSetting::get('site_favicon');
            if ($oldFavicon && Storage::disk('public')->exists(str_replace('/storage/', '', $oldFavicon))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $oldFavicon));
            }
            
            $faviconUrl = $this->uploadFavicon($request->file('site_favicon'));
            SiteSetting::set('site_favicon', $faviconUrl, 'image');
        }

        return redirect()
            ->route('admin.settings.index')
            ->with('status', 'Pengaturan website berhasil diperbarui.');
    }

    private function uploadLogo($file): string
    {
        $filename = 'logo_' . time() . '.png';
        
        // Create image manager with GD driver
        $manager = new ImageManager(new Driver());
        
        // Read and resize image
        $image = $manager->read($file);
        $image->scaleDown(height: 200);
        
        // Store the image
        $path = 'uploads/settings/' . $filename;
        Storage::disk('public')->put($path, $image->toPng());
        
        return Storage::url($path);
    }

    private function uploadFavicon($file): string
    {
        $filename = 'favicon_' . time() . '.png';
        
        // Create image manager with GD driver
        $manager = new ImageManager(new Driver());
        
        // Read and resize image
        $image = $manager->read($file);
        $image->cover(32, 32);
        
        // Store the image
        $path = 'uploads/settings/' . $filename;
        Storage::disk('public')->put($path, $image->toPng());
        
        return Storage::url($path);
    }
}
