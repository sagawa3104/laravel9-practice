<?php

use App\Models\Masters\Item;
use App\Models\Masters\Phase;
use App\Models\Masters\Product;
use App\Models\Transactions\RecordedInspection;
use App\Models\Transactions\RecordedInspectionDetail;
use App\Models\Transactions\RecordedInspectionDetailChecking;
use App\Models\Transactions\RecordedProduct;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    // Arrange
    RecordedProduct::factory()->for( Product::factory() )->has( Phase::factory() )->create();
    $recordedInspection = RecordedInspection::first();
    RecordedInspectionDetailChecking::factory()->for( RecordedInspectionDetail::factory()->for($recordedInspection)->state(['type' => 'CHECKING']) )
    ->for(Item::factory())->create([
        'type' => 'ITEM'
    ]);
});

test('検査実績明細モデルを取得できる', function () {
    // Action
    $recordedInspectionDetailChecking = RecordedInspectionDetailChecking::first();
    // Assert
    expect($recordedInspectionDetailChecking)->recordedInspectionDetail->toBeInstanceOf(RecordedInspectionDetail::class);
});

test('項目モデルを取得できる', function () {
    // Action
    $recordedInspectionDetailChecking = RecordedInspectionDetailChecking::first();
    // Assert
    expect($recordedInspectionDetailChecking)->item->toBeInstanceOf(Item::class);
});


