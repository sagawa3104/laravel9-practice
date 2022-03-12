@extends('layouts.app')

@section('content')

<div class="contents-wrapper">
    <label class="contents__title">工程管理&gt;変更</label>
    <div class="contents__content">
        <div class="contents__content__actions">
            <a class="button button--cancel" href="{{ route('phases.index') }}">戻る</a>
        </div>
        <div class="contents__content__form">
            <div class="form-box">
                <div class="form-box__header">
                    <h1>工程にカテゴリを割当て</h1>
                </div>
                <div class="form-box__content">
                    <form class="form" method="POST" action="{{ route('phases.apply-categories', [$phase->id]) }}">
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
                            @foreach ($categories as $category)
                            <div class="attach-list__item">
                                <input class="toggle-input" type="checkbox" id="{{$category->code}}" name="categories[]" value="{{$category->id}}" {{$phase->categories->contains($category->id)? 'checked':''}}>
                                <label class="toggle-label" for="{{$category->code}}"></label>
                                <label class="form-label form-label--right form-label--left" for="{{$category->code}}">{{$category->name}}</label>
                            </div>
                            @endforeach
                            @error('all')
                            <p class="form-message form-message--error">{{ $message }}</p>
                            @enderror
                            @error('categories.*')
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
