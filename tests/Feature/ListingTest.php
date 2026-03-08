<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Models\Condition;

class ListingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 商品出品画面にて必要な情報が保存できる(){

        $user = User::factory()->create();
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();

        $this->actingAs($user);

        $path = 'items/sample.jpg';

        $response = $this->post('/list', [
            'name' => 'テスト商品',
            'image' => $path,
            'price' => 3000,
            'description' => 'テスト用の商品説明',
            'brand' => 'テストブランド',
            'condition_id' => 1,
            'category_id' => [$category1->id, $category2->id],
        ]);

        $this->assertDatabaseHas('items', [
            'name' => 'テスト商品',
            'price' => 3000,
            'description' => 'テスト用の商品説明',
            'brand' => 'テストブランド',
            'condition_id' => 1,
        ]);

        $item = Item::first();

        $this->assertDatabaseHas('category_item', [
            'item_id' => $item->id,
            'category_id' => $category1->id,
        ]);

        $this->assertDatabaseHas('category_item', [
            'item_id' => $item->id,
            'category_id' => $category2->id,
        ]);
    }
}
