@extends('layouts.app')

@section('content')

<div class="contents-wrapper">
    <label class="contents__title">検査実績管理</label>
    <div class="contents__content">
        <div class="contents__content__actions">
        </div>
        <div class="contents__content__table">
            <table class="list-table">
                <thead class="list-table__head">
                    <tr>
                        <th>カラム1</th>
                        <th>カラム2</th>
                        <th>カラム3</th>
                        <th>カラム4</th>
                    </tr>
                </thead>
                <tbody class="list-table__body">
                    @foreach ($recordedInspections as $recordedInspection)
                    <tr>
                        <td>{{ $recordedInspection->phase->name }}</td>
                        <td>{{ $recordedInspection->recordedProduct->product->name }}</td>
                        <td>{{ $recordedInspection->recordedProduct->code }}</td>
                        <td><a class="button" href={{ route('recorded-inspections.show', [$recordedInspection->id]) }}>詳細</a></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="list-table__foot">
                </tfoot>
            </table>
        </div>
        {{-- ペジネータを作る --}}
        {{$recordedInspections->links('pagination::bootstrap-4')}}
    </div>
</div>
@endsection
