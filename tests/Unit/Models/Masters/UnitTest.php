<?php

use App\Models\Masters\Item;
use App\Models\Masters\Phase;
use App\Models\Masters\Product;
use App\Models\Masters\ProductUnit;
use App\Models\Masters\Unit;
use App\Models\Transactions\RecordedInspection;
use App\Models\Transactions\RecordedInspectionDetail;
use App\Models\Transactions\RecordedInspectionDetailMapping;
use App\Models\Transactions\RecordedProduct;

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

test('検査実績明細マッピングモデルを取得できる', function () {
    // Arrange
    RecordedProduct::factory()->for( Product::factory() )->has( Phase::factory() )->create();
    $recordedInspection = RecordedInspection::first();
    $unit = Unit::factory()->create();
    RecordedInspectionDetailMapping::factory()->for( RecordedInspectionDetail::factory()->for($recordedInspection)->state(['type' => 'MAPPING']) )
    ->for($unit)->for(Item::factory())->create([
        'x_point' => $unit->x_length,
        'y_point' => $unit->y_length,
    ]);

    // Action
    $unit->refresh();

    // Assert
    expect($unit)->recordedInspectionDetailMappings->each(function($recordedInspectionDetailMapping){
        $recordedInspectionDetailMapping->toBeInstanceOf(RecordedInspectionDetailMapping::class);
    });
});
