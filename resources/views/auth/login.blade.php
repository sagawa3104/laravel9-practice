<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="./css/destyle.css" media="all">
        <link rel="stylesheet" type="text/css" href="./css/app.css" media="all">
    </head>
    <body>
        <title>ログイン</title>
        <div class="flex-container">
            <main class="login-wrapper">
                <section class="login-form-box">
                    <div class="login-form-box__header">
                        <h1>このアプリにログイン</h1>
                    </div>
                    <div class="login-form-box__content">
                        <form class="form" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form__group">
                                <label class="form-label" for="email">メールアドレス:</label>
                                <input class="form-input" type="text" id="email" name="email">
                            </div>
                            <div class="form__group">
                                <label class="form-label" for="password">パスワード:</label>
                                <input class="form-input" type="password" id="password" name="password">
                            </div>
                            <button class="button" type="submit">ログイン</button>
                        </form>
                    </div>
                    <div class="login_form_box__footer"></div>
                </section>
            </main>
        </div>
    </body>
</html>
