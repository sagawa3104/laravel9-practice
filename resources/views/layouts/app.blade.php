<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="{{asset('css/destyle.css')}}" media="all">
        <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}" media="all">
        @yield('scripts')
    </head>
    <body>
        <title>ログイン</title>
        <header class="header">
            <nav class="header__nav">
                <a class="header__logo" href="{{ route('home') }}">Laravel-sample Project</a>
                <ul class="horizontal-list horizontal-list--right">
                    <li class="horizontal-list__item">
                        <form method="POST" action="{{route('logout')}}">
                            @csrf
                            <button type="submit">ログアウト</button>
                        </form>
                    </li>
                    <li class="horizontal-list__item">right_menu2</li>
                </ul>
            </nav>
        </header>
        <div class="flex-container">
            <aside class="side-bar">
                <p>サイドメニューエリア</p>
                <br>
                <br>
                <section class="side-bar__category">
                    <label class="side-bar__category__label">マスタ管理</label>
                    <ul class="side-bar__category__list">
                        <li class="side-bar__category__list__item">
                            <a href="{{ route('processes.index') }}">工程管理</a>
                        </li>
                        <li class="side-bar__category__list__item">
                            <a href="{{ route('products.index') }}">品目管理</a>
                        </li>
                        <li class="side-bar__category__list__item">
                            <a href="{{ route('parts.index') }}">部位管理</a>
                        </li>
                        <li class="side-bar__category__list__item">
                            <a href="{{ route('specifications.index') }}">仕様管理</a>
                        </li>
                        <li class="side-bar__category__list__item">
                            <a href="{{ route('inspecting-forms.index') }}">検査方式管理</a>
                        </li>
                    </ul>
                </section>
                <br>
                <section class="side-bar__category">
                    <label class="side-bar__category__label">実績管理</label>
                    <ul class="side-bar__category__list">
                        <li class="side-bar__category__list__item">
                            <a href="{{ route('recorded-products.index') }}">生産実績管理</a>
                        </li>
                        <li class="side-bar__category__list__item">
                            <a href="{{ route('inspections.index') }}">検査実績管理</a>
                        </li>
                    </ul>
                </section>
                <br>
                <section class="side-bar__category">
                    <label class="side-bar__category__label">検査</label>
                    <ul class="side-bar__category__list">
                        <li class="side-bar__category__list__item">
                            <a href="http://localhost/react/search">Reactテスト</a>
                        </li>
                    </ul>
                </section>
                <section class="side-bar__category">
                    <label class="side-bar__category__label">デザイン用</label>
                    <ul class="side-bar__category__list">
                        <li class="side-bar__category__list__item">
                            <a href="statics/sample-page.html">ページ</a>
                        </li>
                    </ul>
                </section>
            </aside>
            <main class="">
                @yield('content')
            </main>
        </div>
    </body>
</html>
