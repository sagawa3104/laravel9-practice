@extends('layouts.app')

@section('content')

<div class="contents-wrapper">
    <label class="contents__title">項目管理&gt;登録</label>
    <div class="contents__content">
        <div class="contents__content__actions">
            <a class="button button--cancel" href="{{ route('items.index') }}">戻る</a>
        </div>
        <div class="contents__content__form">
            <div class="form-box">
                <div class="form-box__header">
                    <h1>項目情報を入力</h1>
                </div>
                <div class="form-box__content">
                    <form class="form" method="POST" action="{{ route('items.store') }}">
                        @csrf
                        <div class="form__group">
                            <label class="form-label" for="code">項目コード:</label>
                            <input class="form-input" type="text" id="code" name="item_code">
                            @error('item_code')
                                <p class="form-message form-message--error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form__group">
                            <label class="form-label" for="name">項目名称:</label>
                            <input class="form-input" type="text" id="name" name="item_name">
                            @error('item_name')
                                <p class="form-message form-message--error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form__group">
                            <label class="form-label" for="is_mapping_item">マッピング用の項目:</label>
                            <input class="toggle-input" type="checkbox" id="is_mapping_item" name="is_mapping_item" value="1">
                            <label class="toggle-label" for="is_mapping_item"></label>
                            @error('is_mapping_item')
                                <p class="form-message form-message--error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form__group">
                            <label class="form-label" for="is_checking_item">チェックリスト用の項目:</label>
                            <input class="toggle-input" type="checkbox" id="is_checking_item" name="is_checking_item" value="1">
                            <label class="toggle-label" for="is_checking_item"></label>
                            @error('is_checking_item')
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
