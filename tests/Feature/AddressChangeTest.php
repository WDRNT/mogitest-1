<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class AddressChangeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 登録した住所が商品購入画面に正しく反映される(){
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $this->post("/purchase/address/{$item->id}", [
            'post_code' => '111-1111',
            'address' => 'テスト住所11',
            'building' => 'テストビル101',
        ]);

        $response = $this->get("/purchase/{$item->id}");

        $response->assertSee('111-1111');
        $response->assertSee('テスト住所11');
        $response->assertSee('テストビル101');
    }

     /** @test */
    public function 正しく送付先住所が紐づいている(){
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $this->post("/purchase/address/{$item->id}", [
            'post_code' => '111-1111',
            'address' => 'テスト住所11',
            'building' => 'テストビル101',
        ]);
    }
}
