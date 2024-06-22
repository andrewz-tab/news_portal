<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Role\Service;
use Spatie\Permission\Models\Role;
use App\Http\Requests\Role\StoreRequest;
use App\Http\Requests\Permission\StoreForUserRequest;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public $service;
    public function __construct(Service $service)
    {
        $this->service = $service;
    }
    public function add_permission(Role $role)
    {
        return view('admin_panel.role.permission', compact('role'));
    }
    public function create()
    {
        return view('admin_panel.role.create');
    }
    public function edit(Role $role)
    {
        $paginateValue = 10;
        $users = $role->users()->paginate($paginateValue, ['*'], 'users');
        $permissions = $role->permissions()->paginate($paginateValue, ['*'], 'permissions');
        return view('admin_panel.role.edit', compact('role', 'users', 'permissions'));
    }
    public function index()
    {
        $roles = Role::paginate(10);
        return view('admin_panel.role.index', compact('roles'));
    }
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $message = $this->service->store($data);
        return redirect()->route('admin.roles.index')->with('success', $message);
    }
    public function store_permission(StoreForUserRequest $request, Role $role)
    {
        $data = $request->validated();
        $message = $this->service->storePermission($role, $data);
        return redirect()->route('admin.roles.edit', $role->id)->with('success', $message);
    }
}
