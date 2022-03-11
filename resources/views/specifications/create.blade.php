@extends('layouts.app')

@section('content')

<div class="contents-wrapper">
    <label class="contents__title">仕様管理&gt;登録</label>
    <div class="contents__content">
        <div class="contents__content__actions">
            <a class="button button--cancel" href="{{ route('specifications.index') }}">戻る</a>
        </div>
        <div class="contents__content__form">
            <div class="form-box">
                <div class="form-box__header">
                    <h1>仕様情報を入力</h1>
                </div>
                <div class="form-box__content">
                    <form class="form" method="POST" action="{{ route('specifications.store') }}">
                        @csrf
                        <div class="form__group">
                            <label class="form-label" for="code">仕様コード:</label>
                            <input class="form-input" type="text" id="code" name="specification_code">
                            @error('specification_code')
                                <p class="form-message form-message--error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form__group">
                            <label class="form-label" for="name">仕様名称:</label>
                            <input class="form-input" type="text" id="name" name="specification_name">
                            @error('specification_name')
                                <p class="form-message form-message--error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form__group">
                            <label class="form-label" for="is_mapping_specification">マッピング用の仕様:</label>
                            <input class="toggle-input" type="checkbox" id="is_mapping_specification" name="is_mapping_specification" value="1">
                            <label class="toggle-label" for="is_mapping_specification"></label>
                            @error('is_mapping_specification')
                                <p class="form-message form-message--error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form__group">
                            <label class="form-label" for="is_checking_specification">チェックリスト用の仕様:</label>
                            <input class="toggle-input" type="checkbox" id="is_checking_specification" name="is_checking_specification" value="1">
                            <label class="toggle-label" for="is_checking_specification"></label>
                            @error('is_checking_specification')
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
