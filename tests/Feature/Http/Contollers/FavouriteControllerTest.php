<?php

namespace Http\Contollers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class FavouriteControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_like(): void
    {
        User::factory()->create(); //author
        $post = Post::factory()->create();
        $user = User::factory()->create();
        $user->givePermissionTo(Permission::findOrCreate('favourite.create'));
        $response = $this->actingAs($user)
            ->post('/news/' . $post->id . '/favourite');

        $response->assertStatus(302);
        $this->assertDatabaseHas('favourites', [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'deleted_at' => null,
        ]);
    }
    public function test_unlike(): void
    {
        User::factory()->create(); //author
        $post = Post::factory()->create();
        $user = User::factory()->create();
        $user->givePermissionTo(Permission::findOrCreate('favourite.create'));
        $user->favourites()->attach($post->id);
        $this->assertDatabaseHas('favourites', [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'deleted_at' => null,
        ]);

        $response = $this->actingAs($user)
            ->post('/news/' . $post->id . '/favourite');
        $response->assertStatus(302);
        $this->assertDatabaseMissing('favourites', [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'deleted_at' => null,
        ]);
    }
}
