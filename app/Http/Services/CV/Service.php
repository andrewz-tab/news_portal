<?php

namespace App\Http\Services\CV;

use App\Models\CV;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Service
{

    public  function store($data, User $user)
    {
        $user->full_name = $data['full_name'];
        unset($data['full_name']);
        $data['status'] = CV::UNVERIFIED;
        $data['user_id'] = $user->id;
        $cv = CV::create($data);

        $user->givePermissionTo(Permission::findOrCreate('cv.update.' . $cv->id));
        $user->givePermissionTo(Permission::findOrCreate('cv.delete.' . $cv->id));
        $createCV = Permission::where('name', 'cv.create')->first();
        if(!$createCV->wasRecentlyCreated) {
            $user->revokePermissionTo(Permission::findOrCreate('cv.create'));
        }
    }
    public function accept(CV $cv, User $admin)
    {
        $user = $cv->user;
        $user->assignRole(Role::findOrCreate('author'));
        $user->revokePermissionTo(Permission::findOrCreate('cv.delete.' . $cv->id))
            ->revokePermissionTo(Permission::findOrCreate('cv.update.' . $cv->id));
        $cv->admin_id = $admin->id;
        $cv->status = CV::APPROVED;
        $cv->save();
        $user->save();
    }
    public function refuse(CV $cv, User $admin)
    {
        $deleteCV = Permission::findOrCreate('cv.delete.' . $cv->id);
        $updateCV = Permission::findOrCreate('cv.update.' . $cv->id);
        $user = $cv->user;
        $user->revokePermissionTo($updateCV)->revokePermissionTo($deleteCV);
        $cv->admin_id = $admin->id;
        $cv->status = CV::REFUSED;
        $cv->save();
        $user->save();
    }
    public function delete(CV $cv)
    {
        $cv->delete();
    }
}
