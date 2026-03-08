@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}" />
@endsection

@section('content')

<div class="layout">
    <div class="item-img">
        <img src="{{ $item->image_url }}">
    </div>

    <div class="item-content">
        <h1>{{ $item->name }}</h1>
        <span>{{ $item->brand }}</span>
            <div class="price-text">
                ￥{{ $item->price }}<span>(税込み)</span>
            </div>

            <div class="icon-content">
                <div class="img-content">
                    <form action="/item/{{ $item->id }}/like" method="POST">
                        @csrf
                        <button type="submit">
                        <img
                            src="{{ $liked ? asset('image/pink-heart.png') : asset('image/heart.png') }}"
                            style="cursor:pointer;"
                        >
                        </button>
                        <span class="like-count">{{ $like }}</span>
                    </form>
                </div>

                <div class="img-content">
                    <img src="{{ asset('/image/speech-bubble.png') }}">
                    <span class="comment-count">{{ $comment }}</span>
                </div>
            </div>
        <div class="button-layout">
            <a href="/purchase/{{ $item->id }}">購入手続きへ</a>
        </div>
        <div>
            <h2>商品説明</h2>
            <p>
                {{ $item->description }}
            </p>
        </div>

        <div>
            <h2>商品の情報</h2>
            <div>
                <div>
                    <div>カテゴリー</div>
                    <div>
                        @foreach($item->categories as $category)
                            {{ $category->name }}
                        @endforeach
                    </div>
                </div>
                <div>
                    <div>商品の状態</div>
                    <div>{{ $item->condition->name }}</div>
                </div>
            </div>
        </div>

        <div>
            <form action="/item/{{ $item->id }}/comments" method="POST">
                @csrf
                <h2>コメント({{ $item->comments->count() }})</h2>
                @error('comment')
                    <p class="error">{{ $message }}</p>
                @enderror
                @foreach($item->comments as $comment)
                <div class="icon-flex">
                    <div class="profile-image">
                        @if(!empty($comment->user->profile->image))
                            <img src="{{ asset('storage/'.$comment->user->profile->image) }}">
                        @endif
                    </div>

                    <span>{{ $comment->user->name }}</span>
                    <span>{{ $comment->comment }}</span>
                </div>
                @endforeach
                <div class="textarea-layout">
                    商品へのコメント
                    <textarea name="comment"></textarea>
                </div>
                <div class="button-layout" >
                    <button type="submit">コメントを送信する</button>
                </div>

            </form>
        </div>
    </div>
</div>


@endsection