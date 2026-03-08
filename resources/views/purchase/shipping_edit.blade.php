@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}" />
@endsection

@section('content')
<div class="layout">
    <h1>住所の変更</h1>

    <form class="form" action="" method="post">
        @csrf
        @if ($errors->any())
        <div style="margin:12px 0; color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="content">

            <div class="content-title">
                郵便番号
            </div>
            <div class="content-text">
                <input type="text" name="post_code" value="{{ old('post_code', $profile->post_code ?? '') }}">
            </div>

            <div class="content-title">
                住所
            </div>
            <div class="content-text">
                <input type="text" name="address" value="{{ old('address', $profile->address ?? '') }}" >
            </div>

            <div class="content-title">
                建物名
            </div>
            <div class="content-text">
                <input type="text" name="building" value="{{ old('building', $profile->building ?? '') }}" >
            </div>

        </div>

        <button class="create" type="submit">更新する</button>

    </form>
</div>
@endsection