<?php

namespace App\Http\Controllers\Admin;

use App\Http\Services\Permission\Service;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Http\Filters\PermissionFilter;
use App\Http\Requests\Permission\FilterRequest;
use App\Http\Requests\Permission\StoreRequest;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public $service;
    public function __construct(Service $service)
    {
        $this->service = $service;
    }
    public function create()
    {
        return view('admin_panel.permission.create');
    }
    public function edit(Permission $permission)
    {
        $users = $permission->users()->paginate(10);
        $roles = Role::all();
        return view('admin_panel.permission.edit', compact('permission', 'users', 'roles'));
    }
    public function index(FilterRequest $request)
    {
        $data = $request->validated();
        $name = '';
        if(isset($data['name'])) {
            $name = $data['name'];
        }
        $filter = app()->make(PermissionFilter::class, ['queryParams' => array_filter($data)]);
        $permissions = Permission::filter($filter)->paginate(10);
        return view('admin_panel.permission.index', compact('permissions', 'name'));
    }
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $message = $this->service->store($data);
        return redirect()->route('admin.permissions.index')->with('success', $message);
    }
}
