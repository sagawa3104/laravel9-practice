@extends('layouts.app')

@section('content')

<div class="contents-wrapper">
    <label class="contents__title">製造実績管理</label>
    <div class="contents__content">
        <div class="contents__content__actions">
            <a class="button" href="{{ route('recorded-products.create') }}">登録</a>
        </div>
        <div class="contents__content__table">
            <table class="list-table">
                <thead class="list-table__head">
                    <tr>
                        <th>カラム1</th>
                        <th>カラム2</th>
                        <th>カラム3</th>
                    </tr>
                </thead>
                <tbody class="list-table__body">
                    @foreach ($recordedProducts as $recordedProduct)
                    <tr>
                        <td>{{ $recordedProduct->code }}</td>
                        <td>{{ $recordedProduct->product->name }}</td>
                        <td><a class="button" href={{ route('recorded-products.edit', [$recordedProduct->id]) }}>編集</a></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="list-table__foot">
                </tfoot>
            </table>
        </div>
        {{-- ペジネータを作る --}}
        {{$recordedProducts->links('pagination::bootstrap-4')}}
    </div>
</div>
@endsection
