<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KhutbahJumat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class KhutbahController extends Controller
{
    public function index(Request $request): View
    {
        $query = KhutbahJumat::with('user')
            ->when(
                $request->filled('q'),
                fn ($query) => $query->where(function ($subQuery) use ($request) {
                    $subQuery->where('title', 'like', '%' . $request->q . '%')
                        ->orWhere('khatib', 'like', '%' . $request->q . '%')
                        ->orWhere('location', 'like', '%' . $request->q . '%');
                })
            );

        // Kontributor hanya melihat khutbah mereka sendiri
        if (! auth()->user()->isSuperAdmin()) {
            $query->where('user_id', auth()->id());
        }

        $khutbahs = $query
            ->ordered()
            ->get();
        
        return view('admin.khutbah.index', compact('khutbahs'));
    }

    public function create(): View
    {
        return view('admin.khutbah.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:khutbah_jumats,slug',
            'content' => 'required|string',
            'khutbah_date' => 'required|date',
            'khatib' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'is_published' => 'sometimes|boolean',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);
        $validated['user_id'] = auth()->id();
        $validated['is_published'] = $request->boolean('is_published');
        
        if ($validated['is_published']) {
            $validated['published_at'] = now();
        }

        KhutbahJumat::create($validated);

        return redirect()
            ->route('admin.khutbah.index')
            ->with('status', 'Khutbah Jum\'at berhasil ditambahkan.');
    }

    public function edit(KhutbahJumat $khutbah): View
    {
        // Kontributor hanya bisa edit khutbah mereka sendiri
        if (! auth()->user()->isSuperAdmin() && $khutbah->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit khutbah ini.');
        }

        return view('admin.khutbah.edit', compact('khutbah'));
    }

    public function update(Request $request, KhutbahJumat $khutbah): RedirectResponse
    {
        // Kontributor hanya bisa update khutbah mereka sendiri
        if (! auth()->user()->isSuperAdmin() && $khutbah->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengupdate khutbah ini.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:khutbah_jumats,slug,' . $khutbah->id,
            'content' => 'required|string',
            'khutbah_date' => 'required|date',
            'khatib' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'is_published' => 'sometimes|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        
        $validated['is_published'] = $request->boolean('is_published');
        
        if ($validated['is_published'] && !$khutbah->published_at) {
            $validated['published_at'] = now();
        } elseif (!$validated['is_published']) {
            $validated['published_at'] = null;
        }

        $khutbah->update($validated);

        return redirect()
            ->route('admin.khutbah.index')
            ->with('status', 'Khutbah Jum\'at berhasil diperbarui.');
    }

    public function destroy(KhutbahJumat $khutbah): RedirectResponse
    {
        // Kontributor hanya bisa hapus khutbah mereka sendiri
        if (! auth()->user()->isSuperAdmin() && $khutbah->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus khutbah ini.');
        }

        $khutbah->delete();

        return redirect()
            ->route('admin.khutbah.index')
            ->with('status', 'Khutbah Jum\'at berhasil dihapus.');
    }
}

