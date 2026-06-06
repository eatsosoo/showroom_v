<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RolePermissionController extends Controller
{
    public function index(): View
    {
        return view('admin.roles.index', [
            'title' => 'Phân quyền',
            'roles' => Role::with('permissions')->orderBy('name')->get(),
            'permissions' => Permission::orderBy('group')->orderBy('name')->get()->groupBy('group'),
        ]);
    }

    public function storeRole(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'slug' => ['nullable', 'string', 'max:191', 'unique:roles,slug'],
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);

        Role::create($data);

        return back()->with('success', 'Đã tạo role.');
    }

    public function updateRolePermissions(Request $request, Role $role): RedirectResponse
    {
        $data = $request->validate([
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['integer', 'exists:permissions,id'],
        ]);

        $role->permissions()->sync($data['permissions'] ?? []);

        return back()->with('success', 'Đã cập nhật quyền cho role.');
    }

    public function storePermission(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'slug' => ['nullable', 'string', 'max:191', 'unique:permissions,slug'],
            'group' => ['nullable', 'string', 'max:191'],
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);

        Permission::create($data);

        return back()->with('success', 'Đã tạo permission.');
    }
}
