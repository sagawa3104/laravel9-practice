<?php

use App\Models\Masters\Item;
use App\Models\Masters\Phase;
use App\Models\Masters\Product;
use App\Models\Masters\Unit;
use App\Models\Transactions\RecordedInspection;
use App\Models\Transactions\RecordedInspectionDetail;
use App\Models\Transactions\RecordedInspectionDetailMapping;
use App\Models\Transactions\RecordedProduct;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    // Arrange
    RecordedProduct::factory()->for( Product::factory() )->has( Phase::factory() )->create();
    $recordedInspection = RecordedInspection::first();
    $unit = Unit::factory()->create();
    RecordedInspectionDetailMapping::factory()->for( RecordedInspectionDetail::factory()->for($recordedInspection)->state(['type' => 'MAPPING']) )
    ->for($unit)->for(Item::factory())->create([
        'x_point' => $unit->x_length,
        'y_point' => $unit->y_length,
    ]);
});

test('検査実績明細モデルを取得できる', function () {
    // Action
    $recordedInspectionDetailMapping = RecordedInspectionDetailMapping::first();
    // Assert
    expect($recordedInspectionDetailMapping)->recordedInspectionDetail->toBeInstanceOf(RecordedInspectionDetail::class);
});

test('部位モデルを取得できる', function () {
    // Action
    $recordedInspectionDetailMapping = RecordedInspectionDetailMapping::first();
    // Assert
    expect($recordedInspectionDetailMapping)->unit->toBeInstanceOf(Unit::class);
});

test('項目モデルを取得できる', function () {
    // Action
    $recordedInspectionDetailMapping = RecordedInspectionDetailMapping::first();
    // Assert
    expect($recordedInspectionDetailMapping)->item->toBeInstanceOf(Item::class);
});


