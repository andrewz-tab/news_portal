<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Определение разрешений
        $createPost = Permission::create(['name' => 'post.create']);
        $viewPost = Permission::create(['name' => 'post.view']);
        $createComment = Permission::create(['name' => 'comment.create']);
        $viewComment = Permission::create(['name' => 'comment.view']);
        $createSubscribe  = Permission::create(['name' => 'subscription.create']);
        $viewSubscribe  = Permission::create(['name' => 'subscription.view']);
        $createFavourite = Permission::create(['name' => 'favourite.create']);
        $viewFavourite = Permission::create(['name' => 'favourite.view']);
        $createCV = Permission::create(['name' => 'cv.create']);
        $allPermission = Permission::create(['name' => '*.*.*']);
        $allPermission1 = Permission::create(['name' => '*.*']);
        Permission::create(['name' => 'cv.update']);
        Permission::create(['name' => 'cv.delete']);
        //Определение ролей
        $user = Role::create(['name' => 'user']);
        $author = Role::create(['name' => 'author']);
        $admin = Role::create(['name' => 'admin']);
        //Привязка разрешений к ролям
        $user->givePermissionTo(
            $viewPost, $createComment, $viewComment, $createCV,
            $createSubscribe, $viewSubscribe, $createFavourite, $viewFavourite
        );
        $author->givePermissionTo(
            $createPost, $viewPost, $createComment, $viewComment,
            $createSubscribe, $viewSubscribe, $createFavourite, $viewFavourite
        );
        $admin->givePermissionTo($allPermission, $allPermission1);
    }
}
