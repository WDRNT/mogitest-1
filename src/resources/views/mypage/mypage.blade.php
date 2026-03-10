@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}" />
@endsection

@section('content')
<div class="layout">

    <div class="icon-flex">
        <div class="profile-box">
            <div class="profile-image">
                @if(!empty($profile->image))
                    <img src="{{ asset('storage/'.$profile->image) }}">
                @endif
            </div>

            <div class="profile-name">
                {{ $user->name }}
            </div>
        </div>

        <div class="profile-link">
            <a href="/mypage/profile">プロフィールを編集</a>
        </div>
    </div>

    <div class="page-list">
        <ul class="list">
            <li class="list__item">
                <a href="/mypage?page=sell" class="{{ $page === 'sell' ? 'active' : '' }}">出品した商品</a>
            </li>
            <li class="list__item">
                <a href="/mypage?page=buy" class="{{ $page === 'buy' ? 'active' : '' }}">購入した商品</a>
            </li>
        </ul>
    </div>

    <div class="card">
        @foreach($items as $item)
            <a href="/item/{{ $item->id }}">
                <article class="card-content">
                    <div class="card-img">
                        <img src="{{ $item->image_url }}">
                    </div>
                    <div class="text">
                        <span>{{ $item->name }}</span>
                    </div>
                </article>
            </a>
        @endforeach
    </div>
</div>


@endsection