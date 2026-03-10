@extends('layout.auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/.css') }}" />
@endsection

@section('content')
<div class="layout">

<p>登録していただいたメールアドレスに認証メールを送付しました。<br>メール認証を完了してください。
</p>

<form method="POST" action="{{ route('verification.send') }}">
    @csrf
    <button type="submit">
        認証はこちらから
    </button>
</form>

@if (session('status') == 'verification-link-sent')
    <p style="color: green;">
        認証メールを送信しました。メールをご確認ください。
    </p>
@endif


    <a href="/login">ログインはこちら</a>
</div>


@endsection