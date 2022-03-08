@extends('layouts.app')

@section('content')

<div class="contents-wrapper">
    <label class="contents__title">品目管理&gt;変更</label>
    <div class="contents__content">
        <div class="contents__content__actions">
            <a class="button button--cancel" href="{{ route('products.index') }}">戻る</a>
        </div>
        <div class="contents__content__form">
            <div class="form-box">
                <div class="form-box__header">
                    <h1>品目に部位を割当て</h1>
                </div>
                <div class="form-box__content">
                    <form class="form" method="POST" action="{{ route('products.apply-units', [$product->id]) }}">
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
                            @foreach ($units as $unit)
                            <div class="attach-list__item">
                                <input class="toggle-input" type="checkbox" id="{{$unit->code}}" name="units[]" value="{{$unit->id}}" {{$product->units->contains($unit->id)? 'checked':''}}>
                                <label class="toggle-label" for="{{$unit->code}}"></label>
                                <label class="form-label form-label--right form-label--left" for="{{$unit->code}}">{{$unit->name}}</label>
                                <img src="http://localhost/img/200x150.png" alt="サンプル">
                            </div>
                            @endforeach
                            @error('all')
                            <p class="form-message form-message--error">{{ $message }}</p>
                            @enderror
                            @error('units.*')
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
