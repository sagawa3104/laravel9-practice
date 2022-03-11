<?php

use App\Models\Masters\Product;
use App\Models\Masters\ProductSpecification;
use App\Models\Masters\Specification;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    // Arrange
    $product = Product::factory()->create();
    Specification::factory()->hasAttached($product)->create();
});

test('品目モデルを取得できる', function () {
    // Action
    $productSpecification = ProductSpecification::first();
    // Assert
    expect($productSpecification)->product->toBeInstanceOf(Product::class);
});

test('仕様モデルを取得できる', function () {
    // Action
    $productSpecification = ProductSpecification::first();
    // Assert
    expect($productSpecification)->specification->toBeInstanceOf(Specification::class);
});
