<?php

namespace Http\Contollers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class SubscriptionControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_subscribe(): void
    {
        $author = User::factory()->create();
        $user = User::factory()->create();
        $user->givePermissionTo(Permission::findOrCreate('subscription.create'));
        $response = $this->actingAs($user)
            ->post('/author/' . $author->id . '/subscribe');

        $response->assertStatus(302);
        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'author_id' => $author->id,
            'deleted_at' => null,
        ]);
    }
    public function test_unsubscribe(): void
    {
        $author = User::factory()->create();
        $user = User::factory()->create();
        $user->givePermissionTo(Permission::findOrCreate('subscription.create'));
        $user->subscriptions()->attach($author->id);
        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'author_id' => $author->id,
            'deleted_at' => null,
        ]);

        $response = $this->actingAs($user)
            ->post('/author/' . $author->id . '/subscribe');
        $response->assertStatus(302);
        $this->assertDatabaseMissing('subscriptions', [
            'user_id' => $user->id,
            'author_id' => $author->id,
            'deleted_at' => null,
        ]);
    }
}
