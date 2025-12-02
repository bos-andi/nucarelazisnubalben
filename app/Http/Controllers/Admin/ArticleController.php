<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $query = Article::with('category')
            ->when(
                $request->filled('q'),
                fn ($query) => $query->where(function ($subQuery) use ($request) {
                    $subQuery->where('title', 'like', '%' . $request->q . '%')
                        ->orWhere('author', 'like', '%' . $request->q . '%')
                        ->orWhereHas('category', fn ($catQuery) => $catQuery
                            ->where('name', 'like', '%' . $request->q . '%'));
                })
            )
            ->when(
                $request->filled('category_id'),
                fn ($query) => $query->where('category_id', $request->category_id)
            );

        if (! auth()->user()->isSuperAdmin()) {
            $query->where('user_id', auth()->id());
        }

        $articles = $query
            ->orderByDesc('published_at')
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('admin.articles.index', compact('articles', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('admin.articles.create', compact('categories', 'tags'));
    }

    public function store(Request $request): RedirectResponse
    {
        \Log::info('Article store method called');
        \Log::info('Request method: ' . $request->method());
        \Log::info('Request has file cover_image: ' . ($request->hasFile('cover_image') ? 'YES' : 'NO'));
        
        if ($request->hasFile('cover_image')) {
            \Log::info('Cover image file details: ' . json_encode([
                'original_name' => $request->file('cover_image')->getClientOriginalName(),
                'size' => $request->file('cover_image')->getSize(),
                'mime_type' => $request->file('cover_image')->getMimeType(),
                'extension' => $request->file('cover_image')->getClientOriginalExtension(),
                'is_valid' => $request->file('cover_image')->isValid(),
            ]));
        }
        
        try {
            $data = $this->validatedData($request);

            // Handle cover image upload
            if ($request->hasFile('cover_image')) {
                try {
                    $uploadResult = $this->uploadAndResizeImage($request->file('cover_image'));
                    $data['cover_image'] = $uploadResult['cover_image'];
                    $data['thumbnail'] = $uploadResult['thumbnail'];
                    \Log::info('Article image uploaded successfully: ' . $uploadResult['cover_image']);
                    \Log::info('Thumbnail generated: ' . $uploadResult['thumbnail']);
                } catch (\Exception $e) {
                    \Log::error('Article image upload failed: ' . $e->getMessage());
                    throw $e;
                }
            } else {
                \Log::info('No cover image uploaded for article: ' . $data['title']);
            }

            $data['user_id'] = auth()->id();

            $article = Article::create($data);

            $article->tags()->sync($request->input('tag_ids', []));

            return redirect()
                ->route('admin.articles.index')
                ->with('status', 'Berita berhasil dibuat.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Re-throw validation exceptions to show proper error messages
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Article creation error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat berita: ' . $e->getMessage());
        }
    }

    public function edit(Article $article): View
    {
        $this->authorizeArticle($article);

        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('admin.articles.edit', compact('article', 'categories', 'tags'));
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        \Log::info('Article update method called for article: ' . $article->slug);
        \Log::info('Request method: ' . $request->method());
        \Log::info('Request has file cover_image: ' . ($request->hasFile('cover_image') ? 'YES' : 'NO'));
        
        if ($request->hasFile('cover_image')) {
            \Log::info('Cover image file details: ' . json_encode([
                'original_name' => $request->file('cover_image')->getClientOriginalName(),
                'size' => $request->file('cover_image')->getSize(),
                'mime_type' => $request->file('cover_image')->getMimeType(),
                'extension' => $request->file('cover_image')->getClientOriginalExtension(),
                'is_valid' => $request->file('cover_image')->isValid(),
            ]));
        }
        
        try {
            $this->authorizeArticle($article);

            $data = $this->validatedData($request, $article->id);
            \Log::info('Validation passed for article update');

            // Handle cover image upload
            if ($request->hasFile('cover_image')) {
                \Log::info('Processing cover image upload for update...');
                
                // Delete old images if exists
                if ($article->cover_image && Storage::disk('public')->exists(str_replace('/storage/', '', $article->cover_image))) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $article->cover_image));
                    \Log::info('Old cover image deleted: ' . $article->cover_image);
                }
                if ($article->thumbnail && Storage::disk('public')->exists(str_replace('/storage/', '', $article->thumbnail))) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $article->thumbnail));
                    \Log::info('Old thumbnail deleted: ' . $article->thumbnail);
                }
                
                try {
                    $uploadResult = $this->uploadAndResizeImage($request->file('cover_image'));
                    $data['cover_image'] = $uploadResult['cover_image'];
                    $data['thumbnail'] = $uploadResult['thumbnail'];
                    \Log::info('Article image uploaded successfully for update: ' . $uploadResult['cover_image']);
                    \Log::info('Thumbnail generated: ' . $uploadResult['thumbnail']);
                } catch (\Exception $e) {
                    \Log::error('Article image upload failed during update: ' . $e->getMessage());
                    throw $e;
                }
            } else {
                \Log::info('No cover image uploaded for article update: ' . $article->title);
            }

            $article->update($data);
            \Log::info('Article updated successfully with ID: ' . $article->id);
            
            $article->tags()->sync($request->input('tag_ids', []));
            \Log::info('Tags synced for article: ' . $article->id);

            return redirect()
                ->route('admin.articles.index')
                ->with('status', 'Berita berhasil diperbarui.');
        } catch (\Exception $e) {
            \Log::error('Article update error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui berita: ' . $e->getMessage());
        }
    }

    public function destroy(Article $article): RedirectResponse
    {
        $this->authorizeArticle($article);

        $article->delete();

        return redirect()
            ->route('admin.articles.index')
            ->with('status', 'Berita berhasil dihapus.');
    }

    private function validatedData(Request $request, ?int $articleId = null): array
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:articles,slug,' . $articleId,
            'category_id' => 'nullable|exists:categories,id',
            'cover_image' => 'nullable|max:10240', // Hanya cek ukuran, tidak cek tipe file
            'excerpt' => 'nullable|string|max:600',
            'body' => 'required|string',
            'published_at' => 'nullable|date',
            'is_featured' => 'sometimes|boolean',
            'tag_ids' => 'nullable|array',
            'tag_ids.*' => 'exists:tags,id',
        ], [
            'title.required' => 'Judul wajib diisi.',
            'body.required' => 'Konten berita wajib diisi.',
            'cover_image.max' => 'Ukuran file maksimal 10MB.',
        ]);

        // Validasi manual untuk file gambar jika ada
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            
            // Cek apakah file valid
            if (!$file->isValid()) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'cover_image' => 'File gambar yang diupload tidak valid atau rusak.'
                ]);
            }
            
            // Cek ekstensi file
            $extension = strtolower($file->getClientOriginalExtension());
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'tiff'];
            
            if (!in_array($extension, $allowedExtensions)) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'cover_image' => 'Format gambar harus: JPG, JPEG, PNG, GIF, WEBP, BMP, atau TIFF.'
                ]);
            }
            
            // Cek ukuran file (10MB = 10485760 bytes)
            if ($file->getSize() > 10485760) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'cover_image' => 'Ukuran file maksimal 10MB.'
                ]);
            }
        }

        $validated['slug'] = $validated['slug']
            ?? Str::slug($validated['title']);

        $validated['excerpt'] = $validated['excerpt']
            ?? Str::limit(strip_tags($validated['body']), 200);

        $validated['published_at'] = $validated['published_at']
            ?? now();

        $validated['is_featured'] = $request->boolean('is_featured');

        $validated['author'] = auth()->user()->name; // Selalu gunakan nama user yang login

        return $validated;
    }

    private function authorizeArticle(Article $article): void
    {
        if (! auth()->user()->isSuperAdmin() && $article->user_id !== auth()->id()) {
            abort(403, 'Anda tidak berhak mengubah berita ini.');
        }
    }

    private function uploadAndResizeImage($file): array
    {
        try {
            \Log::info('Starting image upload and thumbnail generation for file: ' . $file->getClientOriginalName());
            
            // Pastikan direktori exists
            $uploadDir = 'uploads/articles';
            $thumbnailDir = 'uploads/articles/thumbnails';
            
            if (!Storage::disk('public')->exists($uploadDir)) {
                Storage::disk('public')->makeDirectory($uploadDir);
                \Log::info('Created directory: ' . $uploadDir);
            }
            
            if (!Storage::disk('public')->exists($thumbnailDir)) {
                Storage::disk('public')->makeDirectory($thumbnailDir);
                \Log::info('Created directory: ' . $thumbnailDir);
            }
            
            // Generate unique filename
            $baseFilename = time() . '_' . Str::random(10);
            $extension = $file->getClientOriginalExtension();
            $filename = $baseFilename . '.' . $extension;
            $thumbnailFilename = $baseFilename . '_thumb.' . $extension;
            
            // Store original file
            $path = $file->storeAs($uploadDir, $filename, 'public');
            \Log::info('Original file stored at path: ' . $path);
            
            // Verify file exists
            if (!Storage::disk('public')->exists($path)) {
                throw new \Exception('File was not saved successfully');
            }
            
            // Generate thumbnail using Intervention Image
            try {
                $manager = new ImageManager(new Driver());
                $image = $manager->read(Storage::disk('public')->path($path));
                
                // Resize to thumbnail (400x300, maintain aspect ratio)
                $image->cover(400, 300);
                
                // Save thumbnail
                $thumbnailPath = $thumbnailDir . '/' . $thumbnailFilename;
                Storage::disk('public')->put($thumbnailPath, $image->toJpeg(85));
                \Log::info('Thumbnail generated at: ' . $thumbnailPath);
                
                $thumbnailUrl = Storage::url($thumbnailPath);
            } catch (\Exception $e) {
                \Log::warning('Thumbnail generation failed, using cover image as thumbnail: ' . $e->getMessage());
                // If thumbnail generation fails, use cover image as thumbnail
                $thumbnailUrl = Storage::url($path);
            }
            
            $coverImageUrl = Storage::url($path);
            \Log::info('Image upload completed successfully. Cover: ' . $coverImageUrl . ', Thumbnail: ' . $thumbnailUrl);
            
            return [
                'cover_image' => $coverImageUrl,
                'thumbnail' => $thumbnailUrl
            ];
        } catch (\Exception $e) {
            \Log::error('Image upload failed: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            throw new \Exception('Gagal mengupload gambar: ' . $e->getMessage());
        }
    }
}
