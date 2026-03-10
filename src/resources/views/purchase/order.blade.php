@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}" />
@endsection

@section('content')

<div class="layout">
    <div>
        <div>
            <img src="{{ $item->image_url }}">
        </div>
        <div>
            <h2>{{ $item->name }}</h2>
            <span>{{ $item->price }}</span>
        </div>
    </div>

    <div>
        <h2>お支払方法</h2>
        <form action="{{ route('purchase.payment', ['item' => $item->id]) }}" method="POST">
            @csrf
            <select name="payment_method" onchange="this.form.submit()">
                <option value="card" {{ $paymentMethod === 'card' ? 'selected' : '' }}>カード</option>
                <option value="konbini" {{ $paymentMethod === 'konbini' ? 'selected' : '' }}>コンビニ</option>
            </select>
        </form>
    </div>

    <div>
        <div><h2>配送先</h2></div>
        <div><a href="/purchase/address/{{$item->id}}">変更する</a></div>
    </div>

    <div>
        <div>{{ $post_code ?? '未登録' }}</div>
        <div>{{ $address ?? '未登録' }}</div>
        <div>{{ $building ?? '未登録' }}</div>
    </div>

    <table>
        <tr>
            <th>小計</th>
            <td>¥{{ $item->price }}</td>
        </tr>
        <tr>
            <th>支払方法</th>
            <td>{{ $paymentMethodText }}</td>
        </tr>
    </table>

    <form action="{{ route('purchase.start', ['item' => $item->id]) }}" method="POST">
        @csrf

        <button type="submit">購入する</button>
    </form>
</div>
@endsection