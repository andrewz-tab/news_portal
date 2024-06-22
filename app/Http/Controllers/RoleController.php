<?php

namespace App\Http\Controllers;

use App\Http\Services\Role\Service;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public $service;
    public function __construct(Service $service)
    {
        $this->service = $service;
    }
    public function destroy(Role $role)
    {
        $this->authorize('delete', $role);
        $role->delete();
        return redirect()->back()->with('success', 'Роль успешно удалена');
    }
    public function destroy_permission(Role $role, Permission $permission)
    {
        $this->authorize('update', $role);
        $this->service->deletePermission($role, $permission);
        return redirect()->back()->with('success', 'Разрешение ' . $permission->name . ' было отвязано от роли ' . $role->user);
    }
}
