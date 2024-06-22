<?php

namespace App\Http\Controllers;

use App\Http\Services\Permission\Service;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\User\UpdateRolesRequest;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }
    public function destroy(Permission $permission)
    {
        $this->authorize('delete', $permission);
        $permission->delete();
        return redirect()->back()->with('success', 'Право успешно удалено');
    }
    public function update(UpdateRolesRequest $request, Permission $permission)
    {
        $data = $request->validated();
        $this->service->updateRoles($permission, $data);
        return redirect()->back()->with("statusG", "Роли успешно обновлены");
    }
}
