<?php

use App\Models\Masters\Product;
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
