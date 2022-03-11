<?php

use App\Models\Masters\Inspection;
use App\Models\Masters\Phase;
use App\Models\Masters\Unit;
use App\Models\Masters\Product;
use App\Models\Masters\ProductSpecification;
use App\Models\Masters\ProductUnit;
use App\Models\Masters\Specification;
use App\Models\Transactions\RecordedProduct;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);


test('部位モデルを複数取得できる', function () {
    // Arrange
    $count = 5;
    $product = Product::factory()->has(Unit::factory()->count($count))->create();

    // Action

    // Assert
    expect($product)->units->toBeInstanceOf(Illuminate\Database\Eloquent\Collection::class)->toHaveCount(5)
    ->each(function($unit){
        $unit->toBeInstanceOf(Unit::class);
    });
});

test('部位との中間モデルを取得できる', function () {
    // Arrange
    $count = 5;
    Product::factory()->has(Unit::factory()->count($count))->create();

    // Action
    $unit = Unit::first();
    // Assert
    expect($unit)->products->each(function($product){
        $product->pivot->toBeInstanceOf(ProductUnit::class);
    });
});

test('仕様モデルを複数取得できる', function () {
    // Arrange
    $count = 5;
    $product = Product::factory()->has(Specification::factory()->count($count))->create();

    // Action

    // Assert
    expect($product)->specifications->toBeInstanceOf(Illuminate\Database\Eloquent\Collection::class)->toHaveCount(5)
    ->each(function($specification){
        $specification->toBeInstanceOf(Specification::class);
    });
});

test('仕様との中間モデルを取得できる', function () {
    // Arrange
    $count = 5;
    Product::factory()->has(Specification::factory()->count($count))->create();

    // Action
    $specification = Specification::first();
    // Assert
    expect($specification)->products->each(function($product){
        $product->pivot->toBeInstanceOf(ProductSpecification::class);
    });
});

test('工程モデルを複数取得できる', function () {
    // Arrange
    $count = 5;
    $product = Product::factory()->has(Phase::factory()->count($count))->create();

    // Action

    // Assert
    expect($product)->phases->toBeInstanceOf(Illuminate\Database\Eloquent\Collection::class)->toHaveCount(5)
    ->each(function($phase){
        $phase->toBeInstanceOf(Phase::class);
    });
});

test('工程との中間(検査)モデルを取得できる', function () {
    // Arrange
    $count = 5;
    Product::factory()->has(Phase::factory()->count($count))->create();

    // Action
    $phase = Phase::first();
    // Assert
    expect($phase)->products->each(function($product){
        $product->inspection->toBeInstanceOf(Inspection::class);
    });
});

test('製造実績モデルを複数取得できる', function () {
    // Arrange
    $count = 5;
    $product = Product::factory()->has(RecordedProduct::factory()->count($count))->create();

    // Action

    // Assert
    expect($product)->recordedProducts->toBeInstanceOf(Illuminate\Database\Eloquent\Collection::class)->toHaveCount(5)
    ->each(function($recordedProduct){
        $recordedProduct->toBeInstanceOf(RecordedProduct::class);
    });
});
