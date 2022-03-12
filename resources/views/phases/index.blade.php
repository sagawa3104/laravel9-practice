@extends('layouts.app')

@section('content')

<div class="contents-wrapper">
    <label class="contents__title">品目管理</label>
    <div class="contents__content">
        <div class="contents__content__actions">
            <a class="button" href="{{ route('phases.create') }}">登録</a>
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
                    @foreach ($phases as $phase)
                    <tr>
                        <td>{{ $phase->code }}</td>
                        <td>{{ $phase->name }}</td>
                        <td><a class="button" href={{ route('phases.edit', [$phase->id]) }}>編集</a></td>
                        <td><a class="button" href={{ route('phases.attach-categories', [$phase->id]) }}>カテゴリ割当て</a></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="list-table__foot">
                </tfoot>
            </table>
        </div>
        {{-- ペジネータを作る --}}
        {{$phases->links('pagination::bootstrap-4')}}
    </div>
</div>
@endsection
