@extends('layouts.app')

@section('content')

<div class="contents-wrapper">
    <label class="contents__title">Home</label>
    <div class="contents__content">
        <p>ログイン後ページ</p>
        <br>
        <p>メモ</p>
        <ul class="vertical-list vertical-list--indent">
            <li>工程
                <ul class="vertical-list vertical-list--indent">
                    <li>工程は複数の品目と紐づけられ、組み合わせによって検査方式を決定する。</li>
                </ul>
            </li>
            <li>品目
                <ul class="vertical-list vertical-list--indent">
                    <li>品目は複数の部位を持つ</li>
                    <li>品目は複数の仕様を持つ</li>
                    <li>品目は複数の生産実績を持つ</li>
                    <li>品目は複数の工程と紐づけられ、組み合わせによって検査方式を決定する。</li>
                </ul>
            </li>
            <li>生産実績
                <ul class="vertical-list vertical-list--indent">
                    <li>生産実績はある品目について登録される実績データ </li>
                    <li>製造番号によって識別される。</li>
                    <li>生産実績ごとに検査が実施される</li>
                </ul>
            </li>
            <li>部位
                <ul class="vertical-list vertical-list--indent">
                    <li>部位は複数の品目に適用される</li>
                    <li>部位は一枚の図面を持つ</li>
                </ul>
            </li>
            <li>仕様
                <ul class="vertical-list vertical-list--indent">
                    <li>仕様は複数の品目に適用される</li>
                </ul>
            </li>
            <li>専用仕様
                <ul class="vertical-list vertical-list--indent">
                    <li>専用仕様は製造番号ごとに追加される固有の仕様である。</li>
                </ul>
            </li>
            <li>検査方式
                <ul class="vertical-list vertical-list--indent">
                    <li>チェックリスト方式とマッピング方式がある</li>
                    <li>検査方式は品目・工程によって決まる</li>
                    <li>品目・工程ごとに両方の検査方式を設定できる</li>
                </ul>
            </li>
            <li>検査項目
                <ul class="vertical-list vertical-list--indent">
                    <li>チェックリスト方式の場合、品目の仕様および製番ごとの専用仕様から構成される</li>
                    <li>マッピング方式の場合、工程・検査方式に割り当てられた検査項目カテゴリに属するマッピング項目から構成される</li>
                </ul>
            </li>
            <li>マッピング項目
                <ul class="vertical-list vertical-list--indent">
                    <li>マッピング項目は特定の検査項目カテゴリに属する</li>
                    <li>検査明細の内容として参照される。</li>
                </ul>
            </li>
            <li>検査項目カテゴリ
                <ul class="vertical-list vertical-list--indent">
                    <li>品目・工程ごとに複数割り当てられる</li>
                </ul>
            </li>
            <li>検査実績
                <ul class="vertical-list vertical-list--indent">
                    <li>製造番号・工程ごとに実施される実績データ</li>
                    <li>検査結果として検査項目を複数持つ</li>
                </ul>
            </li>
            <li>検査実績明細
                <ul class="vertical-list vertical-list--indent">
                    <li>製造番号ごとに複数登録される実績データ</li>
                    <li>明細が登録される特定の部位を持つ</li>
                    <li>実績チェックリスト項目か実績マッピング項目を持つ</li>
                </ul>
            </li>
            <li>実績チェックリスト項目
                <ul class="vertical-list vertical-list--indent">
                    <li>検査実績明細ごとに登録される実績データ</li>
                    <li>仕様か専用仕様を参照する</li>
                </ul>
            </li>
        </ul>
    </div>
</div>
@endsection
