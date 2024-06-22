<?php

namespace App\Http\Services\Role;


use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Service
{
    public  function store($data) : string
    {
        $role = Role::firstOrCreate($data);
        return $role->wasRecentlyCreated ? 'Роль успешно создана' : 'Такая роль уже существует';
    }
    public function deletePermission(Role $role, Permission $permission)
    {
        $role->revokePermissionTo($permission);
    }
    public function storePermission(Role $role, $data) : string
    {
        $permission = Permission::firstOrCreate(
            [
            'name' => $data['name'],
            ]
        );
        $role->givePermissionTo($permission);
        return $permission->wasRecentlyCreated ? 'Разрешение было создано и привязана' : 'Было привязано существующее разрешение';
    }
}
