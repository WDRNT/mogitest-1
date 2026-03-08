<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Comment;

class ItemShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 商品詳細ページに必要な情報が表示される()
    {
        $user = User::factory()->create();

        $condition = Condition::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $user->id,
            'condition_id' => $condition->id,
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'price' => 3000,
            'description' => 'これはテスト商品です',
        ]);

        // カテゴリ作成
        $category = Category::factory()->create(['name' => 'メンズ']);
        $item->categories()->attach($category->id);

        // コメント作成
        $commentUser = User::factory()->create(['name' => 'コメントユーザー']);
        Comment::factory()->create([
            'user_id' => $commentUser->id,
            'item_id' => $item->id,
            'comment' => 'いい商品ですね！',
        ]);

        $response = $this->get("/item/{$item->id}");

        $response->assertStatus(200);

        // 商品情報
        $response->assertSee('テスト商品');
        $response->assertSee('テストブランド');
        $response->assertSee('3000');
        $response->assertSee('これはテスト商品です');

        // カテゴリ
        $response->assertSee('メンズ');

        // コメント
        $response->assertSee('いい商品ですね！');
        $response->assertSee('コメントユーザー');
    }

    /** @test */
    public function 複数選択されたカテゴリが表示されている()
    {
    $item = Item::factory()->create();

        $category1 = Category::factory()->create(['name' => 'メンズ']);
        $category2 = Category::factory()->create(['name' => 'トップス']);

        $item->categories()->attach([$category1->id, $category2->id]);

        $response = $this->get("/item/{$item->id}");

        $response->assertStatus(200);

        $response->assertSee('メンズ');
        $response->assertSee('トップス');
    }
}