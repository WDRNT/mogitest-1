<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Comment;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ログイン済みユーザはコメントを送信できる(){
        $user = User::factory()->create();
        $item =Item::factory()->create();

        $this->actingAs($user);

        $response = $this->post("/item/{$item->id}/comments", [
            'comment' => 'テストコメント'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'テストコメント',
        ]);

        $this->assertEquals(1, $item->comments()->count());

        $response = $this->get("/item/{$item->id}");

        $response->assertSee('<span class="comment-count">1</span>', false);
    }

    /** @test */
    public function ログイン前のユーザはコメントを送信できない(){
        $item = Item::factory()->create();

        $response = $this->post("/item/{$item->id}/comments", [
            'comment' => 'テストコメント'
        ]);

        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
            'comment' => 'テストコメント',
        ]);
    }

     /** @test */
    public function コメントが入力されていない場合バリデーションメッセージが表示される(){
        $user = User::factory()->create();
        $item =Item::factory()->create();

        $this->actingAs($user);

        $response = $this->post("/item/{$item->id}/comments", [
            'comment' => ''
        ]);

        $response->assertSessionHasErrors(['comment']);
        $response->assertSessionHasErrors([
            'comment' => 'コメントを入力してください',
        ]);
    }

     /** @test */
    public function コメントが255文字以上の場合バリデーションエラー()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $comment = str_repeat('a', 256);

        $response = $this->post("/item/{$item->id}/comments", [
            'comment' => $comment,
        ]);

        $response->assertSessionHasErrors('comment');
        $response->assertSessionHasErrors([
            'comment' => 'コメントは255文字以内で入力してください',
        ]);
    }


}
