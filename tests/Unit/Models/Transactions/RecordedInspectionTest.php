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

test('検索パラメータに合致する検査実績モデルを取得する_工程', function(){
    // Arrange
    Phase::factory()->create();
    $phases = Phase::all();
    RecordedProduct::factory()->for( Product::first() )->hasAttached($phases)->count(2)->create();
    $phase = Phase::first();
    $data = [
        'phase' => $phase->id
    ];

    // Action
    $recordedInspections = RecordedInspection::search($data)->get();

    // Assert
    expect($recordedInspections)->each(function($recordedInspection)use($phase){
        $recordedInspectionPhase = $recordedInspection->phase;
        $recordedInspectionPhase->id->toBe($phase->id);
    });
});

test('検索パラメータに合致する検査実績モデルを取得する_製造番号', function(){
    // Arrange
    Phase::factory()->create();
    $phases = Phase::all();
    RecordedProduct::factory()->for( Product::first() )->hasAttached($phases)->count(2)->create();
    $recordedProduct = RecordedProduct::first();
    $data = [
        'code' => $recordedProduct->code
    ];

    // Action
    $recordedInspections = RecordedInspection::search($data)->get();

    // Assert
    expect($recordedInspections)->each(function($recordedInspection)use($recordedProduct){
        $recordedInspectionRecordedProduct = $recordedInspection->recordedProduct;
        $recordedInspectionRecordedProduct->code->toBe($recordedProduct->code);
    });
});

test('検索パラメータに合致する検査実績モデルを取得する_工程・製造番号', function(){
    // Arrange
    Phase::factory()->create();
    $phases = Phase::all();
    RecordedProduct::factory()->for( Product::first() )->hasAttached($phases)->count(2)->create();
    $phase = Phase::first();
    $recordedProduct = RecordedProduct::first();
    $data = [
        'phase' => $phase->id,
        'code' => $recordedProduct->code
    ];

    // Action
    $recordedInspections = RecordedInspection::search($data)->get();

    // Assert
    expect($recordedInspections)->each(function($recordedInspection)use($recordedProduct, $phase){
        $recordedInspectionRecordedProduct = $recordedInspection->recordedProduct;
        $recordedInspectionPhase = $recordedInspection->phase;
        $recordedInspectionPhase->id->toBe($phase->id);
        $recordedInspectionRecordedProduct->code->toBe($recordedProduct->code);
    });
});
