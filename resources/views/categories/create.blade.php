@extends('layouts.app')

@section('content')

<div class="contents-wrapper">
    <label class="contents__title">カテゴリ管理&gt;登録</label>
    <div class="contents__content">
        <div class="contents__content__actions">
            <a class="button button--cancel" href="{{ route('categories.index') }}">戻る</a>
        </div>
        <div class="contents__content__form">
            <div class="form-box">
                <div class="form-box__header">
                    <h1>カテゴリ情報を入力</h1>
                </div>
                <div class="form-box__content">
                    <form class="form" method="POST" action="{{ route('categories.store') }}">
                        @csrf
                        <div class="form__group">
                            <label class="form-label" for="code">カテゴリコード:</label>
                            <input class="form-input" type="text" id="code" name="category_code">
                            @error('category_code')
                                <p class="form-message form-message--error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form__group">
                            <label class="form-label" for="name">カテゴリ名称:</label>
                            <input class="form-input" type="text" id="name" name="category_name">
                            @error('category_name')
                                <p class="form-message form-message--error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form__group">
                            <label class="form-label" for="form">検査方式:</label>
                            <select class="form-input form-input--select" type="text" id="form" name="form">
                                <option value="">----</option>
                                <option value="CHECKLIST">CHECKLIST</option>
                                <option value="MAPPING">MAPPING</option>
                            </select>
                            @error('form')
                                <p class="form-message form-message--error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form__group">
                            <label class="form-label" for="is_by_recorded_product">製番ごとに項目を登録する:</label>
                            <input class="toggle-input" type="checkbox" id="is_by_recorded_product" name="is_by_recorded_product" value="1">
                            <label class="toggle-label" for="is_by_recorded_product"></label>
                            @error('is_by_recorded_product')
                                <p class="form-message form-message--error">{{ $message }}</p>
                            @enderror
                        </div>
                        <button class="button" type="submit">登録</button>
                    </form>
                </div>
                <div class="form-box__footer"></div>
            </div>
        </div>
    </div>
</div>
@endsection
