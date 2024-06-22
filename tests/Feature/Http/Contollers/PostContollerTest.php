<?php

namespace Tests\Feature\Http\Contollers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class PostContollerTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_index_view()
    {
        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertViewIs('post.index');
    }

    public function test_post_show_view(): void
    {
        $users = User::factory(3)->create();
        $posts = Post::factory(3)->create();
        $response = $this->get('/news/' . $posts[2]->id);
        $response->assertStatus(200)
        ->assertViewIs('post.show');
    }

    public function test_post_store(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo(Permission::create(['name' => 'post.create']));
        $post = Post::factory()->make();
        $response = $this->actingAs($user)
            ->post('/news', [
                'title' => $post->title,
                'content' => $post->content,
            ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('posts', [
            'title' => $post->title,
            'content' => $post->content,
        ]);
        $this->assertDatabaseCount('posts', 1);
    }
    public function test_post_destroy(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $this->assertNotSoftDeleted($post);
        $user->givePermissionTo(Permission::create(['name' => 'post.*.' . $post->id]));
        $response = $this->actingAs($user)
            ->delete('/news/' . $post->id);
        $response->assertStatus(302);
        $this->assertSoftDeleted($post);
    }
    public function test_post_edit_view(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $this->assertNotSoftDeleted($post);
        $user->givePermissionTo(Permission::create(['name' => 'post.*.' . $post->id]));
        $response = $this->actingAs($user)
            ->get('/news/' . $post->id . '/edit');
        $response->assertStatus(200)
            ->assertViewIs('post.edit');
        ;
    }
    public function test_post_update(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $this->assertNotSoftDeleted($post);
        $user->givePermissionTo(Permission::create(['name' => 'post.*.' . $post->id]));
        $response = $this->actingAs($user)
            ->patch('/news/' . $post->id, [
                'title' => 'another text',
                'content' => 'another content',
            ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('posts', [
            'title' => 'another text',
            'content' => '<p>another content</p>',
        ]);
    }
    public function test_post_restore(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['deleted_at' => now()]);
        $this->assertSoftDeleted($post);
        $user->givePermissionTo(Permission::create(['name' => 'post.*.' . $post->id]));
        $response = $this->actingAs($user)
            ->post('/news/' . $post->id . '/restore');
        $response->assertStatus(302);
        $this->assertNotSoftDeleted($post);
    }
}
