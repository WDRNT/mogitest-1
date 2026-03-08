<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Purchase;
use App\Models\Profile;


class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 購入するボタンを押すと購入が完了する(){
    $user= User::factory()->create();
    $item = Item::factory()->create([
            'price' => 3000,
        ]);

        Purchase::create([
        'user_id' => $user->id,
        'item_id' => $item->id,
        'amount' => 3000,
        'payment_method' => 'card',
        'status' => 'paid',
        'post_code' => '111-1111',
        'address' => 'テスト1-1-1',
        'building' => 'テストビル',
        ]);

        $this->assertDatabaseHas('purchases', [
        'user_id' => $user->id,
        'item_id' => $item->id,
        'amount' => 3000,
        'payment_method' => 'card',
        'status' => 'paid',
        'post_code' => '111-1111',
        'address' => 'テスト1-1-1',
        'building' => 'テストビル',
    ]);
    }

    /** @test */
    public function 購入した商品は一覧画面でsoldと表示される(){
        $item = Item::factory()->create([
            'status' => 1,
        ]);

        $response = $this->get("/");
        $response->assertStatus(200);

        $response->assertSee('SOLD');
    }

    /** @test */
    public function プロフィールの購入した商品一覧に表示される(){
        $user= User::factory()->create();
        $item = Item::factory()->create([
            'name' => 'テストアイテム',
            'status' => 1,
        ]);

        $this->actingAs($user);

        Purchase::create([
        'user_id' => $user->id,
        'item_id' => $item->id,
        'amount' => 3000,
        'payment_method' => 'card',
        'status' => 'paid',
        'post_code' => '111-1111',
        'address' => 'テスト1-1-1',
        'building' => 'テストビル',
        ]);

        $response = $this->get("/mypage?page=buy");
        $response->assertStatus(200);

        $response->assertSee('テストアイテム');
    }

}
