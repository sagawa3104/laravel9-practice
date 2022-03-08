@extends('layouts.app')

@section('content')

<div class="contents-wrapper">
    <label class="contents__title">部位管理</label>
    <div class="contents__content">
        <div class="contents__content__actions">
            <a class="button" href="{{ route('units.create') }}">登録</a>
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
                    </tr>
                </thead>
                <tbody class="list-table__body">
                    @foreach ($units as $unit)
                    <tr>
                        <td>{{ $unit->code }}</td>
                        <td>{{ $unit->name }}</td>
                        <td>{{ $unit->x_length }}</td>
                        <td>{{ $unit->y_length }}</td>
                        <td><a class="button" href={{ route('units.edit', [$unit->id]) }}>編集</a></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="list-table__foot">
                </tfoot>
            </table>
        </div>
        {{-- ペジネータを作る --}}
        {{$units->links('pagination::bootstrap-4')}}
    </div>
</div>
@endsection
