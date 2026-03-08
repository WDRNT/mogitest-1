<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemIndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 商品一覧に全商品が表示される(): void
    {
        $seller1 = User::factory()->create();
        $seller2 = User::factory()->create();

        $item1 = Item::factory()->for($seller1)->create(['name' => 'Tシャツ']);
        $item2 = Item::factory()->for($seller2)->create(['name' => 'スニーカー']);

        $res = $this->get('/');

        $res->assertOk();
        $res->assertSee($item1->name);
        $res->assertSee($item2->name);
    }

    /** @test */
    public function 購入済み商品にSoldと表示される(): void
    {
        $seller = User::factory()->create();

        $notSold = Item::factory()
            ->for($seller)
            ->create([
                'name' => '未購入アイテム',
                'status' => 0,
            ]);

        $sold = Item::factory()
            ->for($seller)
            ->create([
                'name' => '購入済みアイテム',
                'status' => 1,
            ]);

        $res = $this->get('/');

        $res->assertOk();

        $res->assertSee($notSold->name);
        $res->assertSee($sold->name);

        $res->assertSee('SOLD');
    }

    /** @test */
    public function 自分の出品を一覧に表示させない(): void
    {
        $me = User::factory()->create();
        $other = User::factory()->create();

        $myItem = Item::factory()->for($me)->create(['name' => '自分の出品']);
        $otherItem = Item::factory()->for($other)->create(['name' => '他人の出品']);

        $res = $this->actingAs($me)->get('/');

        $res->assertOk();

        $res->assertDontSee($myItem->name);

        $res->assertSee($otherItem->name);
    }
}


