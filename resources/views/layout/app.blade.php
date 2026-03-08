<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
@yield('css')
</head>

<body>
    <header class="header">
        <div class="header-inner">
            <a class="header-logo" href="/">
                <img src="{{ asset('image/logo.png') }}" alt="">
            </a>
            <form method="GET" action="/" class="header-search">
                <input
                    type="text"
                    name="keyword"
                    placeholder="なにをお探しですか？"
                    value="{{ request('keyword') }}"
                >
            </form>

            <nav class="nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        @guest
                            <a href="{{ route('login') }}">ログイン</a>
                        @endguest

                        @auth
                            <form class="form" action="/logout" method="POST">
                            @csrf
                                <button type="submit">ログアウト</button>
                            </form>
                        @endauth
                    </li>

                    <li class="nav-item"><a href="/mypage">マイページ</a></li>
                    <li class="nav-item"><a href="/sell">出品</a></li>
                </ul>
            </nav>
        </div>
    </header>

<main>
@yield('content')
</main>
</body>

</html>
