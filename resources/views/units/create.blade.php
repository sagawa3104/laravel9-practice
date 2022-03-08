@extends('layouts.app')

@section('content')

<div class="contents-wrapper">
    <label class="contents__title">部位管理&gt;登録</label>
    <div class="contents__content">
        <div class="contents__content__actions">
            <a class="button button--cancel" href="{{ route('units.index') }}">戻る</a>
        </div>
        <div class="contents__content__form">
            <div class="form-box">
                <div class="form-box__header">
                    <h1>部位情報を入力</h1>
                </div>
                <div class="form-box__content">
                    <form class="form" method="POST" action="{{ route('units.store') }}">
                        @csrf
                        <div class="form__group">
                            <label class="form-label" for="code">部位コード:</label>
                            <input class="form-input" type="text" id="code" name="unit_code">
                            @error('unit_code')
                                <p class="form-message form-message--error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form__group">
                            <label class="form-label" for="name">部位名称:</label>
                            <input class="form-input" type="text" id="name" name="unit_name">
                            @error('unit_name')
                                <p class="form-message form-message--error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form__group">
                            <label class="form-label" for="name">X軸:</label>
                            <input class="form-input" type="text" id="name" name="x_length">
                            @error('x_length')
                                <p class="form-message form-message--error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form__group">
                            <label class="form-label" for="name">Y軸:</label>
                            <input class="form-input" type="text" id="name" name="y_length">
                            @error('y_length')
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
