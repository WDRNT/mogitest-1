@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/create.css') }}" />
@endsection

@section('content')
<div class="layout">
    <h1>商品の出品</h1>

    <form action="/sell" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="content">
            <div class="content-title">
                商品画像
            </div>
            <div class="image-upload">
                <input type="file" id="image" name='image'class="file-input">
                <label for="image" class="file-label">
                    画像を選択する
                </label>
            </div>

            <h2>商品の詳細</h2>
            <div class="content-title">
                カテゴリー
            </div>
            <div class="category-list">
                @foreach($categories as $category)
                    <label>
                        <input type="checkbox" name="category_ids[]" value="{{ $category->id }}">
                        <span>{{ $category->name }}</span>
                    </label>
                @endforeach
            </div>

            <div class="content-title">
                商品の状態
            </div>
            <div class="content-text">
                <select class="content-select" name="condition_id">
                    <option value="">選択してください</option>
                    @foreach($conditions as $condition)
                    <option value="{{ $condition->id }}"> {{ $condition->name }} </option>
                    @endforeach
                </select>
            </div>

            <div>
                <h2>商品名と説明</h2>
            </div>

            <div class="content-title">
                商品名
            </div>
            <div class="content-text">
                <input type="text" name="name">
            </div>

            <div class="content-title">
                ブランド名
            </div>
            <div class="content-text">
                <input type="text" name="brand">
            </div>

            <div class="content-title">
                商品の説明
            </div>
            <textarea class="content-textarea" name="description"></textarea>

            <div class="content-title">
                販売価格
            </div>
            <div class="price-input">
                <span class="yen">¥</span>
                <input type="text" name="price">
            </div>
        </div>

        <button class="create" type="submit">出品する</button>
    </form>
</div>


@endsection