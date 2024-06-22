<?php

namespace App\Http\Services\User;

use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Service
{
    
    public function updateRoles(User $user, $data)
    {
        if(isset($data['roles'])) {
            $roles = Role::whereIn('id', $data['roles'])->get();
            $user->syncRoles($roles);
        }
        else{
            $user->syncRoles([]);
        }
    }
    public function storePermission(User $user, $data)
    {
        $permission = Permission::firstOrCreate(
            [
            'name' => $data['name'],
            ]
        );
        $user->givePermissionTo($permission);
        return $permission->wasRecentlyCreated ? 'Разрешение было создано и привязана' : 'Было привязано существующее разрешение';
    }
}
