@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('content')

<div class="layout">

    <div class="page-list">
        <ul class="list">
            <li class="list__item">
                <a href="/" class="{{ $tab !== 'mylist' ? 'active' : '' }}">おすすめ</a>
            </li>
            <li class="list__item">
                <a href="/?tab=mylist" class="{{ $tab === 'mylist' ? 'active' : '' }}">マイリスト</a>
            </li>
        </ul>
    </div>

    <div class="card">
        @foreach($items as $item)
            <a href="/item/{{ $item->id }}">
                <article class="card-content">
                    <div class="card-img">
                        <img src="{{ $item->image_url }}">
                        @if ($item->status == 1)
                            <div class="sold-label">SOLD</div>
                        @endif
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