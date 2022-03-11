<?php

use App\Models\Masters\Phase;
use App\Models\Masters\Product;
use App\Models\Transactions\RecordedInspection;
use App\Models\Transactions\RecordedProduct;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    // Arrange
    RecordedProduct::factory()->for( Product::factory() )->has( Phase::factory() )->create();
});

test('工程モデルを取得できる', function () {
    // Action
    $recordedInspection = RecordedInspection::first();
    // Assert
    expect($recordedInspection)->phase->toBeInstanceOf(Phase::class);
});

test('製造実績モデルを取得できる', function () {
    // Action
    $recordedInspection = RecordedInspection::first();
    // Assert
    expect($recordedInspection)->recordedProduct->toBeInstanceOf(RecordedProduct::class);
});
