<?php

namespace Http\Contollers\Admin;

use App\Models\User;
use Http\Contollers\ProfileControllerTest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function test_ban_page()
    {
        $user = User::factory()->create([
            'is_banned' => true,
        ]);
        $response = $this->actingAs($user)->get('/');
        $response->assertRedirect('/ban');
    }
    public function test_ban(): void
    {
        $admin = User::factory()->create();
        $admin->givePermissionTo(Permission::findOrCreate('*.*.*'))
        ->assignRole(Role::findOrCreate('admin'));
        $user = User::factory()->create();
        $this->assertDatabaseHas('users',[
            'id' => $user->id,
            'is_banned' => false,
        ]);
        $response = $this->actingAs($admin)
            ->post('/admin_panel/users/' . $user->id . '/ban');
        $response->assertStatus(302);
        $this->assertDatabaseHas('users',[
            'id' => $user->id,
            'is_banned' => 1,
        ]);
    }
    public function test_unban(): void
    {
        $admin = User::factory()->create();
        $admin->givePermissionTo(Permission::findOrCreate('*.*.*'))
            ->assignRole(Role::findOrCreate('admin'));
        $user = User::factory()->create(['is_banned' => true]);
        $this->assertDatabaseHas('users',[
            'id' => $user->id,
            'is_banned' => true,
        ]);
        $response = $this->actingAs($admin)
            ->post('/admin_panel/users/' . $user->id . '/un_ban');
        $response->assertStatus(302);
        $this->assertDatabaseHas('users',[
            'id' => $user->id,
            'is_banned' => 0,
        ]);
    }
    public function test_index_view(): void
    {
        $admin = User::factory()->create();
        $admin->givePermissionTo(Permission::findOrCreate('*.*.*'))
            ->assignRole(Role::findOrCreate('admin'));
        $response = $this->actingAs($admin)
            ->get('/admin_panel/users/');
        $response->assertStatus(200)
            ->assertViewIs('admin_panel.user.index');
    }
    public function test_edit_view(): void
    {
        $admin = User::factory()->create();
        $admin->givePermissionTo(Permission::findOrCreate('*.*.*'))
            ->assignRole(Role::findOrCreate('admin'));
        $user = User::factory()->create();
        $response = $this->actingAs($admin)
            ->get('/admin_panel/users/' . $user->id . '/edit');
        $response->assertStatus(200)
            ->assertViewIs('admin_panel.user.edit');
    }
    public function test_add_permission_view(): void
    {
        $admin = User::factory()->create();
        $admin->givePermissionTo(Permission::findOrCreate('*.*.*'))
            ->assignRole(Role::findOrCreate('admin'));
        $user = User::factory()->create();
        $response = $this->actingAs($admin)
            ->get('/admin_panel/users/' . $user->id . '/permission/add');
        $response->assertStatus(200)
            ->assertViewIs('admin_panel.user.permission');
    }
    public function test_store_permission(): void
    {
        $admin = User::factory()->create();
        $admin->givePermissionTo(Permission::findOrCreate('*.*.*'))
            ->assignRole(Role::findOrCreate('admin'));
        $user = User::factory()->create();
        $response = $this->actingAs($admin)
            ->post('/admin_panel/users/' . $user->id . '/permission',[
                'name' => '*.*.1',
            ]);
        $response->assertStatus(302);
        $permission = Permission::findOrCreate('*.*.1');
        $this->assertDatabaseHas('model_has_permissions',[
            'permission_id' => $permission->id,
            'model_type' => 'App\Models\User',
            'model_id' => $user->id,
        ]);
    }
    public function test_update_general(): void
    {
        $admin = User::factory()->create();
        $admin->givePermissionTo(Permission::findOrCreate('*.*.*'))
            ->assignRole(Role::findOrCreate('admin'));
        $user = User::factory()->create();
        $response = $this->actingAs($admin)
            ->patch('/users/' . $user->id . '/update_general',[
                'id' => $user->id,
                'name' => 'new name',
                'email' => 'new@email.com',
                'full_name' => 'new full name',
            ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('users',[
            'name' => 'new name',
            'email' => 'new@email.com',
            'full_name' => 'new full name',
        ]);
    }
    public function test_update_roles(): void
    {
        $admin = User::factory()->create();
        $admin->givePermissionTo(Permission::findOrCreate('*.*.*'))
            ->assignRole($adminRole = Role::findOrCreate('admin'));
        $user = User::factory()->create()->assignRole($userRole = Role::findOrCreate('user'));

        $response = $this->actingAs($admin)
            ->patch('/users/' . $user->id . '/update_roles',[
                'roles' => [ $adminRole->id ],
            ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('model_has_roles',[
            'role_id' => $adminRole->id,
            'model_id' => $user->id,
        ])
        ->assertDatabaseMissing('model_has_roles', [
            'role_id' => $userRole->id,
            'model_id' => $user->id,
        ]);
    }

}
