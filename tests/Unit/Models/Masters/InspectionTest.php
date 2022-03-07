<?php

use App\Models\Masters\Inspection;
use App\Models\Masters\Phase;
use App\Models\Masters\Product;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    // Arrange
    $product = Product::factory()->create();
    Phase::factory()->hasAttached($product)->create();
});

test('品目モデルを取得できる', function () {
    // Action
    $inspection = Inspection::first();
    // Assert
    expect($inspection)->product->toBeInstanceOf(Product::class);
});

test('工程モデルを取得できる', function () {
    // Action
    $inspection = Inspection::first();
    // Assert
    expect($inspection)->phase->toBeInstanceOf(Phase::class);
});
