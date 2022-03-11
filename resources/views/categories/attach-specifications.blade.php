@extends('layouts.app')

@section('content')

<div class="contents-wrapper">
    <label class="contents__title">カテゴリ管理&gt;変更</label>
    <div class="contents__content">
        <div class="contents__content__actions">
            <a class="button button--cancel" href="{{ route('categories.index') }}">戻る</a>
        </div>
        <div class="contents__content__form">
            <div class="form-box">
                <div class="form-box__header">
                    <h1>カテゴリに仕様を割当て</h1>
                </div>
                <div class="form-box__content">
                    <form class="form" method="POST" action="{{ route('categories.apply-specifications', [$category->id]) }}">
                        @method('PUT')
                        @csrf
                        <div class="attach-list">
                            <div class="attach-list__item">
                                <input class="toggle-input" type="checkbox" id="all-select" name="all[select]" value="1">
                                <label class="toggle-label" for="all-select"></label>
                                <label class="form-label form-label--right form-label--left" for="all-select">全選択</label>
                            </div>
                            <div class="attach-list__item">
                                <input class="toggle-input" type="checkbox" id="all-release" name="all[release]" value="1" >
                                <label class="toggle-label" for="all-release"></label>
                                <label class="form-label form-label--right form-label--left" for="all-release">全解除</label>
                            </div>
                            @foreach ($specifications as $specification)
                            <div class="attach-list__item">
                                <input class="toggle-input" type="checkbox" id="{{$specification->code}}" name="specifications[]" value="{{$specification->id}}" {{$category->specifications->contains($specification->id)? 'checked':''}}>
                                <label class="toggle-label" for="{{$specification->code}}"></label>
                                <label class="form-label form-label--right form-label--left" for="{{$specification->code}}">{{$specification->name}}</label>
                            </div>
                            @endforeach
                            @error('all')
                            <p class="form-message form-message--error">{{ $message }}</p>
                            @enderror
                            @error('specifications.*')
                            <p class="form-message form-message--error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form__buttons">
                            <button class="button" type="submit">変更</button>
                        </div>
                    </form>
                </div>
                <div class="form-box__footer"></div>
            </div>
        </div>
    </div>
</div>
@endsection
