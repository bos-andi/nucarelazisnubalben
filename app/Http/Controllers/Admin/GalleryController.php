<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class GalleryController extends Controller
{
    public function index(): View
    {
        $items = GalleryItem::orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('admin.gallery.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request): RedirectResponse
    {
        \Log::info('Gallery store method called');
        \Log::info('Request method: ' . $request->method());
        \Log::info('Request type: ' . $request->input('type'));
        \Log::info('Request has file images: ' . ($request->hasFile('images') ? 'YES' : 'NO'));
        
        if ($request->hasFile('images')) {
            \Log::info('Images count: ' . count($request->file('images')));
            foreach ($request->file('images') as $index => $file) {
                \Log::info("Image $index details: " . json_encode([
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'extension' => $file->getClientOriginalExtension(),
                    'is_valid' => $file->isValid(),
                ]));
            }
        }
        
        try {
            // Validate the request first
            $data = $this->validatedData($request);
            \Log::info('Gallery validation passed');
            
            if ($request->input('type') === 'photo' && $request->hasFile('images')) {
                \Log::info('Processing photo uploads...');
                
                // Handle multiple image uploads
                $images = $request->file('images');
                $createdCount = 0;

                foreach ($images as $image) {
                    try {
                        $mediaUrl = $this->uploadAndResizeImage($image);
                        \Log::info('Gallery image uploaded successfully: ' . $mediaUrl);
                        
                        GalleryItem::create([
                            'user_id' => auth()->id(),
                            'title' => $data['title'] . ($createdCount > 0 ? ' (' . ($createdCount + 1) . ')' : ''),
                            'type' => 'photo',
                            'media_url' => $mediaUrl,
                            'description' => $data['description'],
                            'published_at' => $data['published_at'],
                            'is_featured' => $data['is_featured'],
                        ]);
                        
                        $createdCount++;
                        \Log::info('Gallery item created successfully');
                    } catch (\Exception $e) {
                        \Log::error('Gallery image upload failed: ' . $e->getMessage());
                        throw $e;
                    }
                }

                return redirect()
                    ->route('admin.gallery.index')
                    ->with('status', $createdCount . ' gambar berhasil ditambahkan ke galeri.');
            } else {
                // Handle video upload
                \Log::info('Processing video upload...');
                $data['user_id'] = auth()->id();

                GalleryItem::create($data);
                \Log::info('Gallery video created successfully');

                return redirect()
                    ->route('admin.gallery.index')
                    ->with('status', 'Video berhasil ditambahkan ke galeri.');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Gallery validation failed: ' . json_encode($e->errors()));
            // Re-throw validation exceptions to show proper error messages
            throw $e;
        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Gallery upload error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mengupload: ' . $e->getMessage());
        }
    }

    public function edit(GalleryItem $gallery): View
    {
        return view('admin.gallery.edit', ['item' => $gallery]);
    }

    public function update(Request $request, GalleryItem $gallery): RedirectResponse
    {
        // For updates, we need different validation rules
        $data = $this->validatedUpdateData($request);
        
        if ($request->input('type') === 'photo' && $request->hasFile('images')) {
            // Delete old image if exists
            if ($gallery->media_url && Storage::disk('public')->exists(str_replace('/storage/', '', $gallery->media_url))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $gallery->media_url));
            }
            
            // Upload new image (only first one for update)
            $image = $request->file('images')[0];
            $mediaUrl = $this->uploadAndResizeImage($image);
            
            $data['media_url'] = $mediaUrl;
            $gallery->update($data);
        } else {
            // Handle video or no new image
            $gallery->update($data);
        }

        return redirect()
            ->route('admin.gallery.index')
            ->with('status', 'Item galeri berhasil diperbarui.');
    }

    public function destroy(GalleryItem $gallery): RedirectResponse
    {
        $gallery->delete();

        return redirect()
            ->route('admin.gallery.index')
            ->with('status', 'Item galeri berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        if ($request->input('type') === 'photo') {
            // Validasi sangat sederhana - hanya yang penting
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'type' => 'required|in:photo,video',
                'images' => 'required|array|min:1',
                'images.*' => 'required|max:10240', // Hanya cek ukuran
                'description' => 'nullable|string',
                'published_at' => 'nullable|date',
                'is_featured' => 'sometimes|boolean',
            ], [
                'title.required' => 'Judul wajib diisi.',
                'images.required' => 'Pilih minimal satu gambar untuk diupload.',
                'images.*.required' => 'File gambar wajib dipilih.',
                'images.*.max' => 'Ukuran file maksimal 10MB per gambar.',
            ]);
            
            // Validasi manual untuk setiap file
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $file) {
                    // Cek apakah file valid
                    if (!$file->isValid()) {
                        throw \Illuminate\Validation\ValidationException::withMessages([
                            "images.{$index}" => "File {$file->getClientOriginalName()} tidak valid atau rusak."
                        ]);
                    }
                    
                    // Cek ekstensi file
                    $extension = strtolower($file->getClientOriginalExtension());
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'tiff'];
                    
                    if (!in_array($extension, $allowedExtensions)) {
                        throw \Illuminate\Validation\ValidationException::withMessages([
                            "images.{$index}" => "File {$file->getClientOriginalName()} harus berformat: JPG, JPEG, PNG, GIF, WEBP, BMP, atau TIFF."
                        ]);
                    }
                    
                    // Cek ukuran file (10MB = 10485760 bytes)
                    if ($file->getSize() > 10485760) {
                        throw \Illuminate\Validation\ValidationException::withMessages([
                            "images.{$index}" => "File {$file->getClientOriginalName()} maksimal 10MB."
                        ]);
                    }
                }
            }
        } else {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'type' => 'required|in:photo,video',
                'video_url' => 'required|url|max:255',
                'description' => 'nullable|string',
                'published_at' => 'nullable|date',
                'is_featured' => 'sometimes|boolean',
            ], [
                'title.required' => 'Judul wajib diisi.',
                'video_url.required' => 'URL video wajib diisi.',
                'video_url.url' => 'URL video tidak valid.',
            ]);
            
            $validated['media_url'] = $validated['video_url'];
            unset($validated['video_url']);
        }

        $validated['published_at'] = $validated['published_at'] ?? now();
        $validated['is_featured'] = $request->boolean('is_featured');

        return $validated;
    }

    private function validatedUpdateData(Request $request): array
    {
        if ($request->input('type') === 'photo') {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'type' => 'required|in:photo,video',
                'images' => 'nullable|array',
                'images.*' => 'nullable|max:10240', // Hanya cek ukuran
                'description' => 'nullable|string',
                'published_at' => 'nullable|date',
                'is_featured' => 'sometimes|boolean',
            ], [
                'title.required' => 'Judul wajib diisi.',
                'images.*.max' => 'Ukuran file maksimal 10MB per gambar.',
            ]);
            
            // Validasi manual untuk file update
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $file) {
                    if ($file) {
                        // Cek apakah file valid
                        if (!$file->isValid()) {
                            throw \Illuminate\Validation\ValidationException::withMessages([
                                "images.{$index}" => "File {$file->getClientOriginalName()} tidak valid atau rusak."
                            ]);
                        }
                        
                        // Cek ekstensi file
                        $extension = strtolower($file->getClientOriginalExtension());
                        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'tiff'];
                        
                        if (!in_array($extension, $allowedExtensions)) {
                            throw \Illuminate\Validation\ValidationException::withMessages([
                                "images.{$index}" => "File {$file->getClientOriginalName()} harus berformat: JPG, JPEG, PNG, GIF, WEBP, BMP, atau TIFF."
                            ]);
                        }
                        
                        // Cek ukuran file (10MB = 10485760 bytes)
                        if ($file->getSize() > 10485760) {
                            throw \Illuminate\Validation\ValidationException::withMessages([
                                "images.{$index}" => "File {$file->getClientOriginalName()} maksimal 10MB."
                            ]);
                        }
                    }
                }
            }
        } else {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'type' => 'required|in:photo,video',
                'video_url' => 'required|url|max:255',
                'description' => 'nullable|string',
                'published_at' => 'nullable|date',
                'is_featured' => 'sometimes|boolean',
            ], [
                'title.required' => 'Judul wajib diisi.',
                'video_url.required' => 'URL video wajib diisi.',
                'video_url.url' => 'URL video tidak valid.',
            ]);
            
            $validated['media_url'] = $validated['video_url'];
            unset($validated['video_url']);
        }

        $validated['published_at'] = $validated['published_at'] ?? now();
        $validated['is_featured'] = $request->boolean('is_featured');

        return $validated;
    }

    private function uploadAndResizeImage($file): string
    {
        try {
            \Log::info('Starting gallery image upload for file: ' . $file->getClientOriginalName());
            
            // Generate unique filename
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            
            // Store file using Laravel Storage (paling reliable)
            $path = $file->storeAs('uploads/gallery', $filename, 'public');
            \Log::info('Gallery file stored at path: ' . $path);
            
            // Verify file exists
            if (!Storage::disk('public')->exists($path)) {
                throw new \Exception('File was not saved successfully');
            }
            
            $url = Storage::url($path);
            \Log::info('Gallery image upload completed successfully. URL: ' . $url);
            
            return $url;
        } catch (\Exception $e) {
            \Log::error('Gallery image upload failed: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            throw new \Exception('Gagal mengupload gambar: ' . $e->getMessage());
        }
    }
}

