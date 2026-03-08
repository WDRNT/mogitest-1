<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 全て正しく入力すれば登録成功しプロフィールへ遷移する()
    {
        $res = $this->postRegister();

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'name'  => 'テスト太郎',
        ]);

        $this->assertAuthenticated();

        $res->assertRedirect('/mypage/profile');
    }

    /** @test */
    private function postRegister(array $override = [])
    {
        $payload = array_merge([
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ], $override);

        return $this->from('/register')->post('/register', $payload);
    }

    /** @test */
    public function 名前が未入力ならエラーになる()
    {
        $res = $this->postRegister(['name' => '']);

        $res->assertRedirect('/register');
        $res->assertSessionHasErrors('name');

        $res->assertSessionHasErrors([
            'name' => 'お名前を入力してください',
        ]);
    }

    /** @test */
    public function メールが未入力ならエラーになる()
    {
        $res = $this->postRegister(['email' => '']);

        $res->assertRedirect('/register');
        $res->assertSessionHasErrors('email');
        $res->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
        ]);
    }

    /** @test */
    public function パスワード未入力ならエラーになる()
    {
        $res = $this->postRegister([
            'password' => '',
            'password_confirmation' => '',
        ]);

        $res->assertRedirect('/register');
        $res->assertSessionHasErrors('password');
        $res->assertSessionHasErrors([
            'password' => 'パスワードを入力してください',
        ]);
    }

    /** @test */
    public function パスワードが7文字以下ならエラーになる()
    {
        $res = $this->postRegister([
            'password' => '1234567',
            'password_confirmation' => '1234567',
        ]);

        $res->assertRedirect('/register');
        $res->assertSessionHasErrors('password');
        $res->assertSessionHasErrors([
            'password' => 'パスワードは8文字以上で入力してください',
        ]);
    }

    /** @test */
    public function 確認用パスワードと不一致ならエラーになる()
    {
        $res = $this->postRegister([
            'password' => 'password123',
            'password_confirmation' => 'password999',
        ]);

        $res->assertRedirect('/register');
        $res->assertSessionHasErrors('password');
        $res->assertSessionHasErrors([
            'password' => 'パスワードと一致しません',
        ]);
    }
}

