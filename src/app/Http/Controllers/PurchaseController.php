<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\StripeClient;
use App\Models\Item;

class PurchaseController extends Controller
{

    public function index($item_id){
        $user = auth()->user();
        $item = Item::findOrFail($item_id);

        $sessionKey = "purchase.shipping_edit.$item_id";
        if (session()->has($sessionKey)) {
            $saved = session($sessionKey);
            $post_code = $saved['post_code'] ?? '';
            $address   = $saved['address']   ?? '';
            $building  = $saved['building']  ?? '';
        } else {
            $post_code = $user->profile?->post_code ?? '';
            $address   = $user->profile?->address   ?? '';
            $building  = $user->profile?->building  ?? '';
        }

        $paymentSessionKey = "purchase.payment_method.$item_id";
        $paymentMethod = session($paymentSessionKey, 'card');

        $paymentMethodText = $paymentMethod === 'konbini' ? 'コンビニ' : 'カード';

        return view('purchase.order', compact(
        'item',
        'user',
        'post_code',
        'address',
        'building',
        'paymentMethod',
        'paymentMethodText'
        ));
    }

    public function edit($item_id){
        $item = Item::findOrFail($item_id);
        $user = auth()->user();

        $sessionKey = "purchase.shipping_edit.$item_id";

        if (session()->has($sessionKey)) {
        $saved = session($sessionKey);
            $post_code = $saved['post_code'] ?? '';
            $address   = $saved['address']   ?? '';
            $building  = $saved['building']  ?? '';
        } else {
            $post_code = $user->profile?->post_code ?? '';
            $address   = $user->profile?->address   ?? '';
            $building  = $user->profile?->building  ?? '';
        }

        return view('purchase.shipping_edit', compact('item', 'post_code', 'address', 'building'));
    }

    public function update(Request $request, $item_id){
            $item = Item::findOrFail($item_id);

            $data = $request->all();

            $sessionKey = "purchase.shipping_edit.$item_id";
            session([$sessionKey => $data]);

            return redirect("/purchase/{$item_id}");
    }

    public function updatePaymentMethod(Request $request, $item_id)
    {
        $request->validate([
            'payment_method' => ['required', 'in:card,konbini'],
        ]);

        $sessionKey = "purchase.payment_method.$item_id";
        session([$sessionKey => $request->payment_method]);

        return redirect("/purchase/{$item_id}");
    }

    public function start(Request $request, Item $item)
    {
        abort_if($item->user_id === auth()->id(), 403);

        $user = auth()->user();

        $shippingSessionKey = "purchase.shipping_edit.$item->id";
        $saved = session($shippingSessionKey, []);

        $postCode = $saved['post_code'] ?? $user->profile?->post_code ?? '';
        $address  = $saved['address']   ?? $user->profile?->address   ?? '';
        $building = $saved['building']  ?? $user->profile?->building  ?? '';

        $paymentSessionKey = "purchase.payment_method.$item->id";
        $paymentMethod = session($paymentSessionKey, 'card');

        $stripe = new StripeClient(config('stripe.secret'));

        $types = $paymentMethod === 'konbini'
            ? ['konbini']
            : ['card'];

        $session = $stripe->checkout->sessions->create([
            'payment_method_types' => $types,
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'unit_amount' => (int) $item->price,
                    'product_data' => [
                        'name' => $item->name,
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'metadata' => [
                'item_id' => (string) $item->id,
                'buyer_id' => (string) $user->id,
                'amount' => (string) $item->price,
                'payment_method' => (string) $paymentMethod,
                'post_code' => (string) $postCode,
                'address' => (string) $address,
                'building' => (string) $building,
            ],
            'success_url' => url('/'),
            'cancel_url' => url('/mypage'),
        ]);

        return redirect()->away($session->url);
    }

    public function success(Request $request)
    {
        return view('purchase.success');
    }

    public function cancel()
    {
        return view('purchase.cancel');
    }
}