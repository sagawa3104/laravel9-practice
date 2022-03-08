@extends('layouts.app')

@section('content')

<div class="contents-wrapper">
    <label class="contents__title">工程管理&gt;登録</label>
    <div class="contents__content">
        <div class="contents__content__actions">
            <a class="button button--cancel" href="{{ route('phases.index') }}">戻る</a>
        </div>
        <div class="contents__content__form">
            <div class="form-box">
                <div class="form-box__header">
                    <h1>工程情報を入力</h1>
                </div>
                <div class="form-box__content">
                    <form class="form" method="POST" action="{{ route('phases.store') }}">
                        @csrf
                        <div class="form__group">
                            <label class="form-label" for="code">工程コード:</label>
                            <input class="form-input" type="text" id="code" name="phase_code">
                            @error('phase_code')
                                <p class="form-message form-message--error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form__group">
                            <label class="form-label" for="name">工程名称:</label>
                            <input class="form-input" type="text" id="name" name="phase_name">
                            @error('phase_name')
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
