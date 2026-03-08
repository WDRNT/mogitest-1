<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class MylistIndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function いいねした商品だけが表示される(){
        {
        $user = User::factory()->create();

        $likedItem = Item::factory()->create([
            'name' => 'LIKED_ITEM',
        ]);

        $notLikedItem = Item::factory()->create([
            'name' => 'NOT_LIKED_ITEM',
        ]);

        $likedItem->likedUsers()->syncWithoutDetaching([$user->id]);

        $this->actingAs($user)
            ->get('/?tab=mylist')
            ->assertStatus(200)
            ->assertSee('LIKED_ITEM')
            ->assertDontSee('NOT_LIKED_ITEM');
        }
    }

    /** @test */
    public function 購入済み商品にはSoldと表示される()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create([
            'name' => 'SOLD_ITEM',
            'status' => 1, // ← 購入済み
        ]);

        // いいねしてマイリストに出す
        $item->likedUsers()->syncWithoutDetaching([$user->id]);

        $this->actingAs($user)
            ->get('/?tab=mylist')
            ->assertStatus(200)
            ->assertSee('SOLD_ITEM')
            ->assertSee('Sold');
    }

    /** @test */
    public function 未ログインならマイリストは何も表示されない()
    {
        // 何か商品が存在しても未ログインなら表示されない、の想定
        $item = Item::factory()->create([
            'name' => 'ITEM',
        ]);

        $this->get('/?tab=mylist')
            ->assertStatus(200)
            ->assertDontSee('ITEM');

        // もし「何も表示されない」が「リスト要素が0件」を意味するなら、
        // HTML構造に合わせて以下みたいな検証もOK（例）
        // ->assertSee('class="card"', false);
    }
}
