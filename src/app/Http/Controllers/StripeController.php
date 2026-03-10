<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;

class StripeController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = config('stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\UnexpectedValueException $e) {
            return response('Invalid payload', 400);
        } catch (SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            $itemId = (int) ($session->metadata->item_id ?? 0);
            $buyerId = (int) ($session->metadata->buyer_id ?? 0);

            DB::transaction(function () use ($itemId, $buyerId, $session) {
                $item = Item::lockForUpdate()->findOrFail($itemId);

                if ($item->status === 1) {
                        return;
                    }

                Purchase::create([
                    'user_id' => $buyerId,
                    'item_id' => $itemId,

                    'amount' => (int) ($session->metadata->amount ?? $item->price),
                    'payment_method' => (string) ($session->metadata->payment_method ?? 'card'),
                    'status' => 'paid',

                    'stripe_session_id' => $session->id,
                    'stripe_payment_intent_id' => $session->payment_intent ?? null,

                    'post_code' => (string) ($session->metadata->post_code ?? ''),
                    'address'   => (string) ($session->metadata->address ?? ''),
                    'building'  => (string) ($session->metadata->building ?? null),
                ]);

                $item->update([
                        'status' => 1
                    ]);

            });
        }

        return response('ok', 200);
    }
}
