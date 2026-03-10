<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\Profile;

class UserGetTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function プロフィール画像、ユーザー名、出品した商品一覧、購入した商品一覧が正しく表示される(){
        $user = User::factory()->create(['name' => 'テストユーザ']);
        $purchasedItem = Item::factory()->create(['name' => 'テスト購入品']);

        $this->actingAs($user);

        Profile::factory()->create([
            'user_id' => $user->id,
            'post_code' => '111-1111',
            'address' => 'テスト住所11',
            'building' => 'テストビル',
        ]);

        Item:: factory()->create([
            'name' => 'テスト出品',
            'user_id' => $user->id,
        ]);

        Purchase::create([
        'user_id' => $user->id,
        'item_id' => $purchasedItem->id,
        'amount' => 3000,
        'payment_method' => 'card',
        'status' => 'paid',
        'post_code' => '222-1111',
        'address' => 'テスト1-1-1',
        'building' => 'テストビル202',
        ]);

        $response = $this->get('/mypage?page=sell');

        $response->assertSee('items/sample.jpg');
        $response->assertSee('テストユーザ');
        $response->assertSee('テスト出品');
        $response->assertDontSee('テスト購入品');

        $response = $this->get('/mypage?page=buy');

        $response->assertSee('items/sample.jpg');
        $response->assertSee('テストユーザ');
        $response->assertSee('テスト購入品');
        $response->assertDontSee('テスト出品');

    }
}
