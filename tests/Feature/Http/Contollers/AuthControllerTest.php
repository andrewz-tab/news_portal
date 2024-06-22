<?php

namespace Http\Contollers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use function Laravel\Prompts\password;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_view(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200)
        ->assertViewIs('auth.login');
    }
    public function test_login(): void
    {
        $user = User::factory()->create([
            'email' => 'test@test.com',
            'password' => Hash::make('Qqwerty1!'),
        ]);
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'Qqwerty1!',
        ]);

        $response->assertStatus(302);
    }
    public function test_register_view(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200)
        ->assertViewIs('auth.register');
    }
    public function test_register(): void
    {
        $password = 'Qqwerty1!@#';
        $response = $this->post('/register', [
            'email' => 'test@test.com',
            'name' => 'Test User',
            'password' => $password,
            'password_confirmation' => $password,
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'email' => 'test@test.com',
        ]);
    }
}
