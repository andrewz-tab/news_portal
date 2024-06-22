<?php

namespace Database\Seeders;

use Couchbase\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //        $createComment = Permission::where('slug', 'comment.create')->first()->id;
        //        $createPost = Permission::where('slug', 'post.create')->first()->id;
        //        $makeFavourite = Permission::where('slug', 'favourite.create')->first()->id;
        //        $createSubscribe = Permission::where('slug', 'subscription.create')->first()->id;
        //        $refuseCV = Permission::where('slug', 'cv.refuse')->first()->id;
        //        $acceptCV = Permission::where('slug', 'cv.accept')->first()->id;
        //        $canAll =Permission::where('slug', '*.*.*')->first()->id;
        //
        //
        //
        //
        //        $user = new Role();
        //        $user->name = 'User';
        //        $user->slug = 'user';
        //        $user->save();
        //        $user->permissions()->attach([$createComment, $createSubscribe, $makeFavourite]);
        //        $user->save();
        //
        //        $author = new Role();
        //        $author->name = 'Author';
        //        $author->slug = 'author';
        //        $author->save();
        //        $author->permissions()->attach([$createComment, $createSubscribe, $makeFavourite, $createPost]);
        //        $author->save();
        //
        //        $admin = new Role();
        //        $admin->name = 'Admin';
        //        $admin->slug = 'admin';
        //        $admin->save();
        //        $admin->permissions()->attach([$createComment, $createSubscribe, $makeFavourite, $createPost, $refuseCV, $acceptCV, $canAll]);
        //        $admin->save();
    }
}
