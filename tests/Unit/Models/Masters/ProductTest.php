<?php

use App\Models\Masters\Inspection;
use App\Models\Masters\Phase;
use App\Models\Masters\Unit;
use App\Models\Masters\Product;
use App\Models\Masters\ProductUnit;

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
