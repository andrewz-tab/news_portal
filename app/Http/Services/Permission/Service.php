<?php

namespace App\Http\Services\Permission;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Service
{
    public  function store($data) : string
    {
        $permission = Permission::firstOrCreate(
            [
            'name' => $data['name'],
            ]
        );
        $message = $permission->wasRecentlyCreated ? 'Разрешение успешно создано' : 'Разрешение с такой меткой уже было создано';
        return $message;
    }
    public  function updateRoles(Permission $permission, $data)
    {
        if(isset($data['roles'])) {
            $roles = Role::whereIn('id', $data['roles'])->get();
            $permission->syncRoles($roles);
        }
        else {
            $permission->syncRoles([]);
        }
    }
}
