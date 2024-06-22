<?php

namespace Http\Contollers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_favourite_list_view(): void
    {
        User::factory()->create(); //author
        $user = User::factory()->hasFavourites(3)->create();
        $response = $this->actingAs($user)
            ->get('/favourites');
        $response->assertStatus(200)
        ->assertViewIs('profile.favourites');
    }
    public function test_subscriptions_list_view(): void
    {
        User::factory()->create(); //author
        $user = User::factory()->hasSubscriptions(3)->create();
        $response = $this->actingAs($user)
            ->get('/subscription');
        $response->assertStatus(200)
            ->assertViewIs('profile.subscriptions');
    }
    public function test_index_view(): void
    {
        User::factory()->create(); //author
        $user = User::factory()->hasFavourites(3)
            ->hasSubscriptions(3)->create();
        $response = $this->actingAs($user)
            ->get('/profile');
        $response->assertStatus(200)
            ->assertViewIs('profile.index');
    }
    public function test_news_view(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->get('/news/subscriptions');
        $response->assertStatus(200)
            ->assertViewIs('profile.news');
    }
    public function test_settings_view(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->get('/profile/settings');
        $response->assertStatus(200)
            ->assertViewIs('profile.settings');
    }
    public function test_update_general(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->patch('/update_general',[
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
    public function test_update_password(): void
    {
        $old_password = '12345678';
        $new_password = 'Qqwerty1!@#';
        $user = User::factory()->create(['password' => Hash::make($old_password)]);
        $response = $this->actingAs($user)
            ->patch('/update_password',[
                'old_password' => $old_password,
                'new_password' => $new_password,
                'new_password_confirmation' => $new_password,
            ]);
        $response->assertStatus(302);
        $user = $user->fresh();
        $this->assertEquals(true, Hash::check($new_password, $user->password));
    }
}
