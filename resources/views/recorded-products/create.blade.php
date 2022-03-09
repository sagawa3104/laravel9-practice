@extends('layouts.app')

@section('content')

<div class="contents-wrapper">
    <label class="contents__title">製造実績管理&gt;登録</label>
    <div class="contents__content">
        <div class="contents__content__actions">
            <a class="button button--cancel" href="{{ route('recorded-products.index') }}">戻る</a>
        </div>
        <div class="contents__content__form">
            <div class="form-box">
                <div class="form-box__header">
                    <h1>製造実績情報を入力</h1>
                </div>
                <div class="form-box__content">
                    <form class="form" method="POST" action="{{ route('recorded-products.store') }}">
                        @csrf
                        <div class="form__group">
                            <label class="form-label" for="product">品目:</label>
                            <select class="form-input form-input--select" type="text" id="product" name="product">
                                <option value="">----</option>
                                @foreach ($products as $product)
                                <option value="{{$product->id}}">{{$product->code . $product->name}}</option>
                                @endforeach
                            </select>
                            @error('product')
                                <p class="form-message form-message--error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form__group">
                            <label class="form-label" for="code">製造実績コード:</label>
                            <input class="form-input" type="text" id="code" name="recorded_product_code">
                            @error('recorded_product_code')
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
