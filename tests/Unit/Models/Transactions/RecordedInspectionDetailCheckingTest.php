<?php

use App\Models\Masters\Item;
use App\Models\Masters\Phase;
use App\Models\Masters\Product;
use App\Models\Masters\Specification;
use App\Models\Transactions\RecordedInspection;
use App\Models\Transactions\RecordedInspectionDetail;
use App\Models\Transactions\RecordedInspectionDetailChecking;
use App\Models\Transactions\RecordedProduct;
use App\Models\Transactions\SpecialSpecification;

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

test('仕様モデルを取得できる', function () {
    // Arrange
    $recordedInspection = RecordedInspection::first();

    // Action
    $recordedInspectionDetailChecking = RecordedInspectionDetailChecking::factory()->for( RecordedInspectionDetail::factory()->for($recordedInspection)->state(['type' => 'CHECKING']) )
    ->for(Specification::factory())->create([
        'type' => 'SPECIFICATION'
    ]);
    // Assert
    expect($recordedInspectionDetailChecking)->specification->toBeInstanceOf(Specification::class);
});

test('専用仕様モデルを取得できる', function () {
    // Arrange
    $recordedInspection = RecordedInspection::first();

    // Action
    $recordedInspectionDetailChecking = RecordedInspectionDetailChecking::factory()->for( RecordedInspectionDetail::factory()->for($recordedInspection)->state(['type' => 'CHECKING']) )
    ->for(SpecialSpecification::factory()->for($recordedInspection->recordedProduct))->create([
        'type' => 'SPECIALSPECIFICATION'
    ]);

    // Assert
    expect($recordedInspectionDetailChecking)->specialSpecification->toBeInstanceOf(SpecialSpecification::class);
});


