<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProgramController extends Controller
{
    public function index(): View
    {
        $programs = Program::ordered()->get();
        
        return view('admin.programs.index', compact('programs'));
    }

    public function create(): View
    {
        return view('admin.programs.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
            'description' => 'required|string|max:500',
            'is_active' => 'sometimes|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Program::create($validated);

        return redirect()
            ->route('admin.programs.index')
            ->with('status', 'Program berhasil ditambahkan.');
    }

    public function show(Program $program): View
    {
        return view('admin.programs.show', compact('program'));
    }

    public function edit(Program $program): View
    {
        return view('admin.programs.edit', compact('program'));
    }

    public function update(Request $request, Program $program): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
            'description' => 'required|string|max:500',
            'is_active' => 'sometimes|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? $program->sort_order;

        $program->update($validated);

        return redirect()
            ->route('admin.programs.index')
            ->with('status', 'Program berhasil diperbarui.');
    }

    public function destroy(Program $program): RedirectResponse
    {
        $program->delete();

        return redirect()
            ->route('admin.programs.index')
            ->with('status', 'Program berhasil dihapus.');
    }
}