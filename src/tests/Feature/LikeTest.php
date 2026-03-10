<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function いいねを押すといいね登録されカウントが増えアイコンが変化する()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->post("/item/{$item->id}/like");

        $response->assertStatus(302);

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $item = Item::findOrFail($item->id);
        $this->assertEquals(1, $item->likedUsers()->count());

        $response = $this->get("/item/{$item->id}");

        $response->assertSee('image/pink-heart.png');
        $response->assertSee('<span class="like-count">1</span>', false);
        $response->assertDontSee('image/heart.png');
    }

    /** @test */
    public function いいねを再度押すと解除されカウントが減りアイコンが戻る()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $this->post("/item/{$item->id}/like")->assertStatus(302);

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        $this->assertEquals(1, $item->likedUsers()->count());

        $this->post("/item/{$item->id}/like")->assertStatus(302);

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $item = Item::findOrFail($item->id);
        $this->assertEquals(0, $item->likedUsers()->count());

        $response = $this->get("/item/{$item->id}");
        $response->assertSee('heart.png');
        $response->assertSee('<span class="like-count">0</span>', false);
        $response->assertDontSee('pink-heart.png');
    }
}
