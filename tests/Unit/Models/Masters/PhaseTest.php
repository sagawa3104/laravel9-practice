<?php

use App\Models\Masters\Inspection;
use App\Models\Masters\Product;
use App\Models\Masters\Phase;

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
