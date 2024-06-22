<?php

namespace Http\Contollers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_comment_store(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo(Permission::create(['name' => 'comment.create']));
        $post = Post::factory()->create();
        $comment = Comment::factory()->make();
        $response = $this->actingAs($user)
            ->post('/news/' . $post->id . '/comments', [
                'text' => $comment->text,
            ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('comments', [
            'text' => $comment->text,
        ]);
        $this->assertDatabaseCount('comments', 1);
    }
    public function test_comment_destroy(): void
    {
        $user = User::factory()->create();
        Post::factory()->create();
        $comment = Comment::factory()->create();
        $this->assertNotSoftDeleted($comment);
        $user->givePermissionTo(Permission::create(['name' => 'comment.*.' . $comment->id]));
        $response = $this->actingAs($user)
            ->delete('/comments/' . $comment->id);
        $response->assertStatus(302);
        $this->assertSoftDeleted($comment);
    }
    public function test_comment_edit_view(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $comment = Comment::factory()->create();
        $this->assertNotSoftDeleted($comment);
        $user->givePermissionTo(Permission::create(['name' => 'comment.*.' . $comment->id]));
        $response = $this->actingAs($user)
            ->get('/comments/' . $comment->id . '/edit');
        $response->assertStatus(200)
            ->assertViewIs('comment.edit');
        ;
    }

    public function test_comment_update(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $comment = Comment::factory()->create();
        $this->assertNotSoftDeleted($comment);
        $user->givePermissionTo(Permission::create(['name' => 'comment.*.' . $comment->id]));
        $response = $this->actingAs($user)
            ->patch('/comments/' . $comment->id, [
                'text' => 'another text',
            ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('comments', [
            'text' => 'another text',
        ]);
    }
    public function test_comment_restore(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $comment = Comment::factory()->create(['deleted_at' => now()]);
        $this->assertSoftDeleted($comment);
        $user->givePermissionTo(Permission::create(['name' => 'comment.*.' . $comment->id]));
        $response = $this->actingAs($user)
            ->post('/comments/' . $comment->id . '/restore');
        $response->assertStatus(302);
        $this->assertNotSoftDeleted($comment);
    }
}
