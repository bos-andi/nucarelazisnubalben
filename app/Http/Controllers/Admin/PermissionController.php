<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PermissionController extends Controller
{
    public function index(): View
    {
        $users = User::where('role', '!=', 'superadmin')
            ->with('permissions')
            ->orderBy('name')
            ->get();
        
        $permissions = Permission::orderBy('group')->orderBy('display_name')->get()->groupBy('group');
        
        return view('admin.permissions.index', compact('users', 'permissions'));
    }

    public function updateUserPermissions(Request $request, User $user): RedirectResponse
    {
        // Only superadmin can update permissions
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Only superadmin can manage permissions');
        }

        // Cannot modify superadmin permissions
        if ($user->isSuperAdmin()) {
            return back()->with('error', 'Cannot modify superadmin permissions');
        }

        $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $permissionIds = $request->input('permissions', []);
        $user->permissions()->sync($permissionIds);

        return redirect()
            ->route('admin.contributors.index')
            ->with('status', 'Permission untuk ' . $user->name . ' berhasil diperbarui.');
    }
}
