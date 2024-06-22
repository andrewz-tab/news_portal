<?php

namespace Http\Contollers\Admin;

use App\Models\User;
use PhpMyAdmin\Plugins\Transformations\Abs\PreApPendTransformationsPlugin;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PermissionControllerTest extends TestCase
{

    public function test_index_view(): void
    {
        $admin = User::factory()->create();
        $admin->givePermissionTo(Permission::findOrCreate('*.*.*'))
            ->assignRole(Role::findOrCreate('admin'));
        $response = $this->actingAs($admin)
            ->get('/admin_panel/permissions');
        $response->assertStatus(200)
            ->assertViewIs('admin_panel.permission.index');
    }
    public function test_create_view(): void
    {
        $admin = User::factory()->create();
        $admin->givePermissionTo(Permission::findOrCreate('*.*.*'))
            ->assignRole(Role::findOrCreate('admin'));
        $response = $this->actingAs($admin)
            ->get('/admin_panel/permissions/create');
        $response->assertStatus(200)
            ->assertViewIs('admin_panel.permission.create');
    }
    public function test_edit_view(): void
    {
        $admin = User::factory()->create();
        $admin->givePermissionTo(Permission::findOrCreate('*.*.*'))
            ->assignRole(Role::findOrCreate('admin'));
        $permission = Permission::findOrCreate('temp.permission');
        $response = $this->actingAs($admin)
            ->get('/admin_panel/permissions/' . $permission->id . '/edit');
        $response->assertStatus(200)
            ->assertViewIs('admin_panel.permission.edit');
    }
    public function test_store(): void
    {
        $admin = User::factory()->create();
        $admin->givePermissionTo(Permission::findOrCreate('*.*.*'))
            ->assignRole(Role::findOrCreate('admin'));
        $response = $this->actingAs($admin)
            ->post('/admin_panel/permissions/',[
                'name' => 'temp.permission',
            ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('permissions',[
            'name' => 'temp.permission',
        ]);
    }
    public function test_update_roles(): void
    {
        $admin = User::factory()->create();
        $admin->givePermissionTo(Permission::findOrCreate('*.*.*'))
            ->assignRole($adminRole = Role::findOrCreate('admin'));
        $permission = Permission::findOrCreate('temp.permission')->assignRole($userRole = Role::findOrCreate('user'));
        $response = $this->actingAs($admin)
            ->patch('/permissions/' . $permission->id . '/roles',[
                'roles' => [ $adminRole->id ],
            ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('role_has_permissions',[
            'role_id' => $adminRole->id,
            'permission_id' => $permission->id,
        ])
            ->assertDatabaseMissing('role_has_permissions', [
                'role_id' => $userRole->id,
                'permission_id' => $permission->id,
            ]);
    }
    public function test_destroy(): void
    {
        $admin = User::factory()->create();
        $admin->givePermissionTo(Permission::findOrCreate('*.*.*'))
            ->assignRole($adminRole = Role::findOrCreate('admin'));
        $permission = Permission::findOrCreate('test.permission');
        $this->assertDatabaseHas('permissions', [
            'name' => 'test.permission',
        ]);
        $response = $this->actingAs($admin)
            ->delete('/permissions/' . $permission->id);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('permissions', [
            'name' => 'test.permission',
        ]);
    }
}
