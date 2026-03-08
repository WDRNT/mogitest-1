<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 商品名で部分一致検索ができる(): void
    {
        Item::factory()->create(['name' => '赤いTシャツ']);
        Item::factory()->create(['name' => '青いパーカー']);
        Item::factory()->create(['name' => 'Tシャツ（白）']);

        $response = $this->get('/?keyword=Tシャツ');

        $response->assertStatus(200);
        $response->assertSee('赤いTシャツ');
        $response->assertSee('Tシャツ（白）');
        $response->assertDontSee('青いパーカー');
    }

    /** @test */
    public function 検索状態がマイリストでも保持されている(): void
    {
        $user = User::factory()->create();

        $hit = Item::factory()->create(['name' => '赤いTシャツ']);
        $miss = Item::factory()->create(['name' => '青いパーカー']);

        $user->likes()->attach($hit->id);

        $this->actingAs($user);

        $response1 = $this->get('/?keyword=Tシャツ');
        $response1->assertStatus(200);
        $response1->assertSee('赤いTシャツ');
        $response1->assertDontSee('青いパーカー');

        $response2 = $this->get('/?tab=mylist&keyword=Tシャツ');
        $response2->assertStatus(200);

        $response2->assertSee('value="Tシャツ"', false);

        $response2->assertSee('赤いTシャツ');
        $response2->assertDontSee('青いパーカー');
    }
}
