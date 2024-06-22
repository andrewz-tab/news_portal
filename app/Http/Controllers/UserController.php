<?php

namespace App\Http\Controllers;

use App\Http\Services\User\Service;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Http\Requests\User\UpdateGeneralRequest;
use App\Http\Requests\User\UpdateRolesRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public $service;
    public function __construct(Service $service)
    {
        $this->service = $service;
    }
    public function delete_permission(User $user, Permission $permission)
    {
        $this->authorize('update', $user);
        $user->revokePermissionTo($permission);
        return redirect()->back()->with('success', 'Разрешение ' . $permission->name . ' было отвязано от пользователя ' . $user->user);
    }
    public function delete_role(User $user, Role $role)
    {
        $this->authorize('update', $user);
        $user->removeRole($role);
        return redirect()->back()->with('success', 'Роль '. $role->name .' была отвязана от пользователя ' . $user->name);
    }
    public function update_general(UpdateGeneralRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $data = $request->validated();
        User::whereId($user->id)->update($data);
        return redirect()->back()->with("statusG", "Данные успешно изменены!");
    }
    public function update_roles(UpdateRolesRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $data = $request->validated();
        $this->service->updateRoles($user, $data);

        return redirect()->back()->with("statusG", "Роли успешно обновлены");
    }
}
