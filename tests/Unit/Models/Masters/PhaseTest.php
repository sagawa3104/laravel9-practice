<?php

use App\Models\Masters\Inspection;
use App\Models\Masters\Product;
use App\Models\Masters\Phase;
use App\Models\Transactions\RecordedInspection;
use App\Models\Transactions\RecordedProduct;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);


test('品目モデルを複数取得できる', function () {
    // Arrange
    $count = 5;
    $phase = Phase::factory()->has(Product::factory()->count($count))->create();

    // Action

    // Assert
    expect($phase)->products->toBeInstanceOf(Illuminate\Database\Eloquent\Collection::class)->toHaveCount(5)
    ->each(function($product){
        $product->toBeInstanceOf(Product::class);
    });
});

test('品目との中間(検査)モデルを取得できる', function () {
    // Arrange
    $count = 5;
    Phase::factory()->has(Product::factory()->count($count))->create();

    // Action
    $product = Product::first();
    // Assert
    expect($product)->phases->each(function($phase){
        $phase->inspection->toBeInstanceOf(Inspection::class);
    });
});

test('製造実績モデルを複数取得できる', function () {
    // Arrange
    $count = 5;
    $phase = Phase::factory()->has(RecordedProduct::factory()->for( Product::factory() )->count($count))->create();

    // Action

    // Assert
    expect($phase)->recordedProducts->toBeInstanceOf(Illuminate\Database\Eloquent\Collection::class)->toHaveCount(5)
    ->each(function($recordedProduct){
        $recordedProduct->toBeInstanceOf(RecordedProduct::class);
    });
});

test('製造実績との中間(検査実績)モデルを取得できる', function () {
    // Arrange
    $count = 5;
    Phase::factory()->has(RecordedProduct::factory()->for( Product::factory() )->count($count))->create();

    // Action
    $recordedProduct = RecordedProduct::first();

    // Assert
    expect($recordedProduct)->phases->each(function($phase){
        $phase->recordedInspection->toBeInstanceOf(RecordedInspection::class);
    });
});
