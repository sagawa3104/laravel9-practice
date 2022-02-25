<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="./css/destyle.css" media="all">
        <link rel="stylesheet" type="text/css" href="./css/app.css" media="all">
    </head>
    <body>
        <title>Laravel</title>
        <header class="header">
            <nav class="header__nav">
                <ul class="horizontal-list horizontal-list--left">
                    <li class="horizontal-list__item">left_menu1</li>
                    <li class="horizontal-list__item">left_menu2</li>
                </ul>
                <ul class="horizontal-list horizontal-list--right">
                    <li class="horizontal-list__item">
                        <a href="{{route('login')}}">ログイン</a>
                    </li>
                    <li class="horizontal-list__item">right_menu2</li>
                </ul>
            </nav>
        </header>
        <main>
            <h1>welcome top page!!</h1>
        </main>
        <footer class="footer">
            <p>フッターテキスト</p>
        </footer>
    </body>
</html>
