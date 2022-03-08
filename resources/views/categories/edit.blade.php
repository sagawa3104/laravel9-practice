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
                    <h1>カテゴリ情報を入力</h1>
                </div>
                <div class="form-box__content">
                    <form class="form" method="POST" action="{{ route('categories.update', [$category->id]) }}">
                        @method('PUT')
                        @csrf
                        <div class="form__group">
                            <label class="form-label" for="code">カテゴリコード:</label>
                            <input class="form-input form-input" type="text" id="code" name="category_code" value="{{$category->code}}" disabled>
                        </div>
                        <div class="form__group">
                            <label class="form-label" for="name">カテゴリ名称:</label>
                            <input class="form-input" type="text" id="name" name="category_name" value="{{$category->name}}">
                            @error('category_name')
                                <p class="form-message form-message--error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form__group">
                            <label class="form-label" for="form">検査方式:</label>
                            <select class="form-input form-input--select" type="text" id="form" name="form">
                                <option value="">----</option>
                                <option value="CHECKLIST" {{$category->form == 'CHECKLIST'? 'selected':''}}>CHECKLIST</option>
                                <option value="MAPPING" {{$category->form == 'MAPPING'? 'selected':''}}>MAPPING</option>
                            </select>
                            @error('form')
                                <p class="form-message form-message--error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form__group">
                            <label class="form-label" for="is_by_recorded_product">製番ごとに項目を登録する:</label>
                            <input class="toggle-input" type="checkbox" id="is_by_recorded_product" name="is_by_recorded_product" value="1" {{$category->is_by_recorded_product? 'checked':''}}>
                            <label class="toggle-label" for="is_by_recorded_product"></label>
                            @error('is_by_recorded_product')
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
                        <h1>{{$category->code. ':' .$category->name}}</h1>
                    </div>
                    <div class="form-box__content">
                        <p>本当に削除しますか？</p>
                    </div>
                    <div class="form-box__footer">
                        <form method="POST" action="{{ route('categories.destroy', [$category->id])}}" >
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
