@extends('layout.auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}" />
@endsection

@section('content')
<div class="layout">
    <h1>会員登録</h1>

    <form class="form" action="/register" method="post">
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
                ユーザー名
            </div>
            <div class="content-text">
                <input type="text" name="name" value="{{ old('name') }}" >
            </div>

            <div class="content-title">
                メールアドレス
            </div>
            <div class="content-text">
                <input type="text" name="email" value="{{ old('email') }}" >
            </div>

            <div class="content-title">
                パスワード
            </div>
            <div class="content-text">
                <input type="password" name="password" >
            </div>

            <div class="content-title">
                確認用パスワード
            </div>
            <div class="content-text">
                <input type="password" name="password_confirmation" >
            </div>

        </div>

        <button class="create" type="submit">登録する</button>
    </form>

    <a class="link-center" href="/login">ログインはこちら</a>
</div>


@endsection