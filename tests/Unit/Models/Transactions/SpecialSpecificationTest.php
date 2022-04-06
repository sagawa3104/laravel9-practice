<?php

use App\Models\Masters\Phase;
use App\Models\Masters\Product;
use App\Models\Transactions\RecordedInspection;
use App\Models\Transactions\RecordedProduct;
use App\Models\Transactions\SpecialSpecification;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);


beforeEach(function () {
    // Arrange
    SpecialSpecification::factory()->for(RecordedProduct::factory()->for(Product::factory() ) )->create();
});

test('製造実績モデルを取得できる', function () {
    // Action
    $specialSpecification = SpecialSpecification::first();
    // Assert
    expect($specialSpecification)->recordedProduct->toBeInstanceOf(RecordedProduct::class);
});
