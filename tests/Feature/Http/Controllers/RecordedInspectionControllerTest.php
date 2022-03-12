<?php

use App\Models\Masters\Phase;
use App\Models\Masters\Product;
use App\Models\Transactions\RecordedProduct;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    // Arrange
    $count = 16;
    RecordedProduct::factory()->count($count)
    ->for(Product::factory())
    ->hasAttached(Phase::factory())
    ->create();
});

test('検査実績管理 一覧', function () {

    // Act
    $res = $this->get('/recorded-inspections');

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    // 取得データの確認
    $res->assertViewHas('recordedInspections', function(Illuminate\Pagination\LengthAwarePaginator $viewRecordedInspections){
        return $viewRecordedInspections->lastPage() === 2;
    });
});

// test('製造実績管理 削除処理_異常(DB整合性)', function () {

// });
