<?php

use App\Models\Masters\Product;
use App\Models\Masters\ProductUnit;
use App\Models\Masters\Unit;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);


test('品目モデルを複数取得できる', function () {
    // Arrange
    $count = 5;
    $unit = Unit::factory()->has(Product::factory()->count($count))->create();

    // Action

    // Assert
    expect($unit)->products->toBeInstanceOf(Illuminate\Database\Eloquent\Collection::class)->toHaveCount($count)
    ->each(function($product){
        $product->toBeInstanceOf(Product::class);
    });
});

test('品目との中間モデルを取得できる', function () {
    // Arrange
    Unit::factory()->has(Product::factory())->create();

    // Action
    $product = Product::first();
    // Assert
    expect($product)->units->each(function($unit){
        $unit->pivot->toBeInstanceOf(ProductUnit::class);
    });
});
