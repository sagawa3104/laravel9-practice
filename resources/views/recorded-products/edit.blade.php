@extends('layouts.app')

@section('content')

<div class="contents-wrapper">
    <label class="contents__title">製造実績管理&gt;変更</label>
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
                    <form class="form" method="POST" action="{{ route('recorded-products.update', [$recordedProduct->id]) }}">
                        @method('PUT')
                        @csrf
                        <div class="form__group">
                            <label class="form-label" for="code">製造実績コード:</label>
                            <input class="form-input form-input" type="text" id="code" name="recorded_product_code" value="{{$recordedProduct->code}}" disabled>
                        </div>
                        <div class="form__group">
                            <label class="form-label" for="product">品目:</label>
                            <select class="form-input form-input--select" type="text" id="product" name="product">
                                <option value="">----</option>
                                @foreach ($products as $product)
                                <option value="{{$product->id}}" {{$recordedProduct->product->id === $product->id? 'selected':''}}>{{$product->code . $product->name}}</option>
                                @endforeach
                            </select>
                            @error('product')
                                <p class="form-message form-message--error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form__buttons">
                            <button class="button" type="submit">変更</button>
                            <a class="button button--delete" href="#modal_id">削除</a>
                        </div>
                    </form>
                </div>
                <div class="form-box__footer"></div>
            </div>
        </div>
        <div class="modal-wrapper" id="modal_id">
            <a href="#!" class="modal-wrapper__overlay"></a>
            <div class="modal-wrapper__window">
                <a href="#!" class="modal-wrapper__window__close-mark">X</a>
                <div class="form-box">
                    <div class="form-box__header">
                        <h1>{{$recordedProduct->code. ':' .$recordedProduct->name}}</h1>
                    </div>
                    <div class="form-box__content">
                        <p>本当に削除しますか？</p>
                    </div>
                    <div class="form-box__footer">
                        <form method="POST" action="{{ route('recorded-products.destroy', [$recordedProduct->id])}}" >
                            @method('DELETE')
                            @csrf
                            <button class="button" type="submit">削除</button>
                            <a class="button button--cancel" href="#!">キャンセル</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
