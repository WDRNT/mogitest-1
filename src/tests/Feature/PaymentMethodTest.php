<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 選択した支払方法が正しく反映されている()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->post("/purchase/payment/{$item->id}", [
            'payment_method' => 'konbini',
        ]);

        $response->assertRedirect("/purchase/{$item->id}");

        $response = $this->get("/purchase/{$item->id}");
        $response->assertSee('コンビニ');
    }
}
