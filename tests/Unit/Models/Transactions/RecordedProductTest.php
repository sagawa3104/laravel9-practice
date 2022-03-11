<?php

use App\Models\Masters\Phase;
use App\Models\Masters\Product;
use App\Models\Transactions\RecordedInspection;
use App\Models\Transactions\RecordedProduct;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);


beforeEach(function () {
    // Arrange
    Product::factory()->has(RecordedProduct::factory())->create();
});

test('品目モデルを取得できる', function () {
    // Action
    $recordedProduct = RecordedProduct::first();
    // Assert
    expect($recordedProduct)->product->toBeInstanceOf(Product::class);
});

test('工程モデルを複数取得できる', function () {
    // Arrange
    $count = 5;
    $recordedProduct = RecordedProduct::factory()->for( Product::factory() )->has(Phase::factory()->count($count))->create();

    // Action

    // Assert
    expect($recordedProduct)->phases->toBeInstanceOf(Illuminate\Database\Eloquent\Collection::class)->toHaveCount(5)
    ->each(function($phase){
        $phase->toBeInstanceOf(Phase::class);
    });
});

test('工程との中間(検査実績)モデルを取得できる', function () {
    // Arrange
    $count = 5;
    RecordedProduct::factory()->for( Product::factory() )->has(Phase::factory()->count($count))->create();

    // Action
    $phase = Phase::first();

    // Assert
    expect($phase)->recordedProducts->each(function($recordedProduct){
        $recordedProduct->recordedInspection->toBeInstanceOf(RecordedInspection::class);
    });
});
