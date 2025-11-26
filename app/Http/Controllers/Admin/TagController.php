<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TagController extends Controller
{
    public function index(): View
    {
        $tags = Tag::orderBy('name')->get();

        return view('admin.tags.index', compact('tags'));
    }

    public function create(): View
    {
        return view('admin.tags.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        Tag::create($data);

        return redirect()
            ->route('admin.tags.index')
            ->with('status', 'Tag baru berhasil dibuat.');
    }

    public function edit(Tag $tag): View
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag): RedirectResponse
    {
        $data = $this->validatedData($request, $tag->id);

        $tag->update($data);

        return redirect()
            ->route('admin.tags.index')
            ->with('status', 'Tag diperbarui.');
    }

    public function destroy(Tag $tag): RedirectResponse
    {
        $tag->delete();

        return redirect()
            ->route('admin.tags.index')
            ->with('status', 'Tag dihapus.');
    }

    private function validatedData(Request $request, ?int $tagId = null): array
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'nullable|string|max:120|unique:tags,slug,' . $tagId,
            'color' => 'nullable|string|max:20',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        return $validated;
    }
}
