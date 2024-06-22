<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $usersCount = 500;
        $this->call(PermissionSeeder::class);
        //$this->call(RoleSeeder::class);

        $users = User::factory($usersCount)->create();
        $roles = Role::all();
        foreach ($users as $user) {
            $roleId = $roles->random(1)->pluck('id');
            $user->roles()->attach($roleId);
        }
        $posts = Post::factory(1000)->create();
        $comments = Comment::factory(1000)->create();
        foreach ($posts as $post) {
            $usersId = $users->random(random_int(4, 70))->pluck('id');
            $post->users_favourite()->attach($usersId);
            $ownerPostPerm = Permission::create(['name' => 'post.*.'.$post->id]);
            $post->author->givePermissionTo($ownerPostPerm);
        }
        foreach ($comments as $comment) {
            $ownerPostPerm = Permission::create(['name' => 'comment.*.'.$comment->id]);
            $comment->user->givePermissionTo($ownerPostPerm);
        }
        $authors= User::role('author');
        foreach ($authors as $author) {
            $usersId = $users->random(random_int(4, 14))->pluck('id');
            $author->subscribers()->attach($usersId);
        }

        $users = User::role('user')->get();
        foreach ($users as $user) {
            $cvcreate = Permission::where('name', 'cv.create')->first();
            $user->givePermissionTo($cvcreate);
        }

    }
}
