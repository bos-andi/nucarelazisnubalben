<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdSenseController extends Controller
{
    public function index(): View
    {
        $settings = SiteSetting::whereIn('key', [
            'adsense_client_id',
            'adsense_header_ad',
            'adsense_sidebar_ad',
            'adsense_article_ad',
            'adsense_footer_ad',
            'adsense_enabled'
        ])->get()->keyBy('key');
        
        return view('admin.adsense.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'adsense_client_id' => 'nullable|string|max:255',
            'adsense_header_ad' => 'nullable|string',
            'adsense_sidebar_ad' => 'nullable|string',
            'adsense_article_ad' => 'nullable|string',
            'adsense_footer_ad' => 'nullable|string',
            'adsense_enabled' => 'sometimes|boolean',
        ]);

        // Update AdSense settings
        SiteSetting::set('adsense_client_id', $request->adsense_client_id, 'text', 'adsense');
        SiteSetting::set('adsense_header_ad', $request->adsense_header_ad, 'textarea', 'adsense');
        SiteSetting::set('adsense_sidebar_ad', $request->adsense_sidebar_ad, 'textarea', 'adsense');
        SiteSetting::set('adsense_article_ad', $request->adsense_article_ad, 'textarea', 'adsense');
        SiteSetting::set('adsense_footer_ad', $request->adsense_footer_ad, 'textarea', 'adsense');
        SiteSetting::set('adsense_enabled', $request->boolean('adsense_enabled') ? '1' : '0', 'text', 'adsense');

        return redirect()
            ->route('admin.adsense.index')
            ->with('status', 'Pengaturan Google AdSense berhasil diperbarui.');
    }
}







