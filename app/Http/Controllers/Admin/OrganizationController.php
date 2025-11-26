<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationSetting;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OrganizationController extends Controller
{
    /**
     * Display organization settings
     */
    public function index(): View
    {
        $welcomeMessage = OrganizationSetting::getByKey('welcome_message');
        $organizationStructure = OrganizationSetting::getByKey('organization_structure');
        
        return view('admin.organization.index', compact('welcomeMessage', 'organizationStructure'));
    }

    /**
     * Update welcome message
     */
    public function updateWelcome(Request $request): RedirectResponse
    {
        try {
            $validatedData = $this->validateWelcomeData($request);
            
            $data = [
                'title' => $validatedData['title'],
                'content' => $validatedData['content'],
                'is_active' => $validatedData['is_active'] ?? true,
                'sort_order' => 1
            ];

            // Handle image upload
            if ($request->hasFile('image')) {
                $data['image'] = $this->uploadImage($request->file('image'), 'welcome');
            }

            // Handle chairman photo upload
            if ($request->hasFile('chairman_photo')) {
                $data['chairman_photo'] = $this->uploadImage($request->file('chairman_photo'), 'chairman');
            }

            OrganizationSetting::updateOrCreateByKey('welcome_message', $data);

            return redirect()->route('admin.organization.index')
                ->with('success', 'Sambutan berhasil diperbarui.');

        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Welcome message update failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui sambutan.')
                ->withInput();
        }
    }

    /**
     * Update organization structure
     */
    public function updateStructure(Request $request): RedirectResponse
    {
        try {
            $validatedData = $this->validateStructureData($request);
            
            $data = [
                'title' => $validatedData['title'],
                'content' => $validatedData['content'],
                'data' => $this->processStructureData($validatedData, $request),
                'is_active' => $validatedData['is_active'] ?? true,
                'sort_order' => 2
            ];

            OrganizationSetting::updateOrCreateByKey('organization_structure', $data);

            return redirect()->route('admin.organization.index')
                ->with('success', 'Struktur organisasi berhasil diperbarui.');

        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Organization structure update failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui struktur organisasi.')
                ->withInput();
        }
    }

    /**
     * Validate welcome message data
     */
    private function validateWelcomeData(Request $request): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|max:10240', // 10MB max
            'chairman_photo' => 'nullable|max:10240', // 10MB max
            'is_active' => 'boolean'
        ];

        $messages = [
            'title.required' => 'Judul sambutan wajib diisi.',
            'title.max' => 'Judul sambutan maksimal 255 karakter.',
            'content.required' => 'Isi sambutan wajib diisi.',
            'image.max' => 'Ukuran gambar maksimal 10MB.',
            'chairman_photo.max' => 'Ukuran foto ketua maksimal 10MB.'
        ];

        $validatedData = $request->validate($rules, $messages);

        // Manual file validation for image
        if ($request->hasFile('image')) {
            $this->validateImageFile($request->file('image'), 'image');
        }

        // Manual file validation for chairman photo
        if ($request->hasFile('chairman_photo')) {
            $this->validateImageFile($request->file('chairman_photo'), 'chairman_photo');
        }

        return $validatedData;
    }

    /**
     * Validate structure data
     */
    private function validateStructureData(Request $request): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'positions' => 'nullable|array',
            'positions.*.name' => 'required|string|max:255',
            'positions.*.title' => 'required|string|max:255',
            'positions.*.description' => 'nullable|string',
            'positions.*.order' => 'nullable|integer|min:0',
            'positions.*.is_chairman' => 'nullable|boolean',
            'position_photos' => 'nullable|array',
            'position_photos.*' => 'nullable|max:10240', // 10MB max per photo
            'is_active' => 'boolean'
        ];

        $messages = [
            'title.required' => 'Judul struktur organisasi wajib diisi.',
            'title.max' => 'Judul struktur organisasi maksimal 255 karakter.',
            'positions.*.name.required' => 'Nama pengurus wajib diisi.',
            'positions.*.name.max' => 'Nama pengurus maksimal 255 karakter.',
            'positions.*.title.required' => 'Jabatan wajib diisi.',
            'positions.*.title.max' => 'Jabatan maksimal 255 karakter.',
            'positions.*.order.integer' => 'Urutan harus berupa angka.',
            'positions.*.order.min' => 'Urutan minimal 0.',
            'position_photos.*.max' => 'Ukuran foto pengurus maksimal 10MB.'
        ];

        return $request->validate($rules, $messages);
    }

    /**
     * Process structure data
     */
    private function processStructureData(array $validatedData, Request $request): array
    {
        $positions = [];
        
        if (isset($validatedData['positions']) && is_array($validatedData['positions'])) {
            foreach ($validatedData['positions'] as $index => $position) {
                if (!empty($position['name']) && !empty($position['title'])) {
                    $positionData = [
                        'name' => $position['name'],
                        'title' => $position['title'],
                        'description' => $position['description'] ?? '',
                        'order' => (int)($position['order'] ?? 0),
                        'is_chairman' => (bool)($position['is_chairman'] ?? false),
                        'photo' => null
                    ];

                    // Handle photo upload for this position
                    if ($request->hasFile("position_photos.{$index}")) {
                        $file = $request->file("position_photos.{$index}");
                        $this->validateImageFile($file, "position_photos.{$index}");
                        $positionData['photo'] = $this->uploadImage($file, 'position_' . $index);
                    }

                    $positions[] = $positionData;
                }
            }
            
            // Sort by order
            usort($positions, function($a, $b) {
                return $a['order'] <=> $b['order'];
            });
        }

        return ['positions' => $positions];
    }

    /**
     * Validate image file
     */
    private function validateImageFile($file, string $fieldName): void
    {
        if (!$file->isValid()) {
            throw ValidationException::withMessages([
                $fieldName => 'File gambar tidak valid.'
            ]);
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'tiff'];
        $extension = strtolower($file->getClientOriginalExtension());
        
        if (!in_array($extension, $allowedExtensions)) {
            throw ValidationException::withMessages([
                $fieldName => 'Format gambar harus: ' . implode(', ', $allowedExtensions)
            ]);
        }

        if ($file->getSize() > 10485760) { // 10MB in bytes
            throw ValidationException::withMessages([
                $fieldName => 'Ukuran gambar maksimal 10MB.'
            ]);
        }
    }

    /**
     * Upload and resize image
     */
    private function uploadImage($file, string $prefix): string
    {
        \Log::info('Attempting to upload file: ' . $file->getClientOriginalName());
        $filename = $prefix . '_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        
        try {
            $path = $file->storeAs('uploads/organization', $filename, 'public');
            \Log::info('File stored successfully at: ' . $path);
            return Storage::url($path);
        } catch (\Exception $e) {
            \Log::error('File storage failed: ' . $e->getMessage());
            throw $e;
        }
    }
}