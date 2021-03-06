@extends('layouts.app')

@section('content')

<div class="contents-wrapper">
    <label class="contents__title">品目管理</label>
    <div class="contents__content">
        <div class="contents__content__actions">
            <a class="button" href="{{ route('products.create') }}">登録</a>
        </div>
        <div class="contents__content__table">
            <table class="list-table">
                <thead class="list-table__head">
                    <tr>
                        <th>カラム1</th>
                        <th>カラム2</th>
                        <th>カラム3</th>
                        <th>カラム4</th>
                        <th>カラム5</th>
                        <th>カラム6</th>
                    </tr>
                </thead>
                <tbody class="list-table__body">
                    @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->code }}</td>
                        <td>{{ $product->name }}</td>
                        <td><a class="button" href={{ route('products.edit', [$product->id]) }}>編集</a></td>
                        <td><a class="button" href={{ route('products.attach-units', [$product->id]) }}>部位割当て</a></td>
                        <td><a class="button" href={{ route('products.attach-specifications', [$product->id]) }}>仕様割当て</a></td>
                        <td><a class="button" href={{ route('products.attach-phases', [$product->id]) }}>検査登録（工程割当て）</a></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="list-table__foot">
                </tfoot>
            </table>
        </div>
        {{-- ペジネータを作る --}}
        {{$products->links('pagination::bootstrap-4')}}
    </div>
</div>
@endsection
