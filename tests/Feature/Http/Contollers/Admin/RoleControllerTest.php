<?php

namespace Http\Contollers\Admin;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleControllerTest extends TestCase
{
    public function test_add_permission_view(): void
    {
        $admin = User::factory()->create();
        $admin->givePermissionTo(Permission::findOrCreate('*.*.*'))
            ->assignRole(Role::findOrCreate('admin'));
        $role = Role::findOrCreate('temp');
        $response = $this->actingAs($admin)
            ->get('/admin_panel/roles/' . $role->id . '/permission/add');
        $response->assertStatus(200)
            ->assertViewIs('admin_panel.role.permission');
    }
    public function test_index_view(): void
    {
        $admin = User::factory()->create();
        $admin->givePermissionTo(Permission::findOrCreate('*.*.*'))
            ->assignRole(Role::findOrCreate('admin'));
        $response = $this->actingAs($admin)
            ->get('/admin_panel/roles');
        $response->assertStatus(200)
            ->assertViewIs('admin_panel.role.index');
    }
    public function test_create_view(): void
    {
        $admin = User::factory()->create();
        $admin->givePermissionTo(Permission::findOrCreate('*.*.*'))
            ->assignRole(Role::findOrCreate('admin'));
        $response = $this->actingAs($admin)
            ->get('/admin_panel/roles/create');
        $response->assertStatus(200)
            ->assertViewIs('admin_panel.role.create');
    }
    public function test_edit_view(): void
    {
        $admin = User::factory()->create();
        $admin->givePermissionTo(Permission::findOrCreate('*.*.*'))
            ->assignRole(Role::findOrCreate('admin'));
        $role = Role::findOrCreate('temp');
        $response = $this->actingAs($admin)
            ->get('/admin_panel/roles/' . $role->id . '/edit');
        $response->assertStatus(200)
            ->assertViewIs('admin_panel.role.edit');
    }
    public function test_store(): void
    {
        $admin = User::factory()->create();
        $admin->givePermissionTo(Permission::findOrCreate('*.*.*'))
            ->assignRole(Role::findOrCreate('admin'));
        $response = $this->actingAs($admin)
            ->post('/admin_panel/roles/',[
                'name' => 'temp.role',
            ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('roles',[
            'name' => 'temp.role',
        ]);
    }
    public function test_store_permission(): void
    {
        $admin = User::factory()->create();
        $admin->givePermissionTo(Permission::findOrCreate('*.*.*'))
            ->assignRole(Role::findOrCreate('admin'));
        $role = Role::findOrCreate('temp.role');
        $response = $this->actingAs($admin)
            ->post('/admin_panel/roles/' . $role->id . '/permission',[
                'name' => '*.*.1',
            ]);
        $response->assertStatus(302);
        $permission = Permission::findOrCreate('*.*.1');
        $this->assertDatabaseHas('role_has_permissions',[
            'permission_id' => $permission->id,
            'role_id' => $role->id,
        ]);
    }
    public function test_destroy(): void {
        $admin = User::factory()->create();
        $admin->givePermissionTo(Permission::findOrCreate('*.*.*'))
            ->assignRole($adminRole = Role::findOrCreate('admin'));
        $role = Role::findOrCreate('test.role');
        $this->assertDatabaseHas('roles', [
            'name' => 'test.role',
        ]);
        $response = $this->actingAs($admin)
            ->delete('/roles/' . $role->id);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('roles', [
            'name' => 'test.role',
        ]);
    }
}
