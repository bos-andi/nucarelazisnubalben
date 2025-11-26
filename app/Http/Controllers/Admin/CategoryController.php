<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        Category::create($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('status', 'Kategori baru berhasil dibuat.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $this->validatedData($request, $category->id);

        $category->update($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('status', 'Kategori diperbarui.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('status', 'Kategori dihapus.');
    }

    private function validatedData(Request $request, ?int $categoryId = null): array
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'slug' => 'nullable|string|max:160|unique:categories,slug,' . $categoryId,
            'color' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'is_highlighted' => 'sometimes|boolean',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['is_highlighted'] = $request->boolean('is_highlighted');

        return $validated;
    }
}
