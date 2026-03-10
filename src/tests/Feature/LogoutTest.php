<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ログアウトができる()
    {
        // 1. ユーザー作成
        $user = User::factory()->create();

        // 2. ログイン状態にする
        $this->actingAs($user);

        // 3. ログアウト処理（POST /logout）
        $response = $this->post('/logout');

        // 4. ログアウト後はログインしていない状態
        $this->assertGuest();

        // 5. リダイレクト確認（任意）
        $response->assertRedirect('/');
    }
}
