<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Profile;


class UserUpdateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 各項目の初期値が正しく表示されている(){
        $user = User::factory()->create(['name' => 'テストユーザ']);

        $this->actingAs($user);

        Profile::factory()->create([
            'user_id' => $user->id,
            'post_code' => '111-1111',
            'address' => 'テストアドレス1-1',
            'building' => 'テストビル101',
        ]);

        $response = $this->get("/mypage/profile");

        $response->assertSee('items/sample.jpg');
        $response->assertSee('テストユーザ');
        $response->assertSee('111-1111');
        $response->assertSee('テストアドレス1-1');
        $response->assertSee('テストビル101');

    }
}
