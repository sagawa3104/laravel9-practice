<?php

use App\Models\Masters\Category;
use App\Models\Masters\CategoryItem;
use App\Models\Masters\Item;
use App\Models\Masters\Product;
use App\Models\Masters\ProductUnit;
use App\Models\Masters\Unit;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    // Arrange
    $product = Product::factory()->create();
    Unit::factory()->hasAttached($product)->create();
});

test('品目モデルを取得できる', function () {
    // Action
    $productUnit = ProductUnit::first();
    // Assert
    expect($productUnit)->product->toBeInstanceOf(Product::class);
});

test('部位モデルを取得できる', function () {
    // Action
    $productUnit = ProductUnit::first();
    // Assert
    expect($productUnit)->unit->toBeInstanceOf(Unit::class);
});
