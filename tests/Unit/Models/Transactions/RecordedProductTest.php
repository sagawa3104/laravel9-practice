<?php

use App\Models\Masters\Phase;
use App\Models\Masters\Product;
use App\Models\Transactions\RecordedInspection;
use App\Models\Transactions\RecordedProduct;
use App\Models\Transactions\SpecialSpecification;

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

test('工程モデルを複数取得できる', function () {
    // Arrange
    $count = 5;
    $recordedProduct = RecordedProduct::factory()->for( Product::factory() )->has(Phase::factory()->count($count))->create();

    // Action

    // Assert
    expect($recordedProduct)->phases->toBeInstanceOf(Illuminate\Database\Eloquent\Collection::class)->toHaveCount(5)
    ->each(function($phase){
        $phase->toBeInstanceOf(Phase::class);
    });
});

test('工程との中間(検査実績)モデルを取得できる', function () {
    // Arrange
    $count = 5;
    RecordedProduct::factory()->for( Product::factory() )->has(Phase::factory()->count($count))->create();

    // Action
    $phase = Phase::first();

    // Assert
    expect($phase)->recordedProducts->each(function($recordedProduct){
        $recordedProduct->recordedInspection->toBeInstanceOf(RecordedInspection::class);
    });
});

test('専用仕様モデルを取得できる', function () {
    // Arrange
    $recordedProduct = RecordedProduct::first();
    SpecialSpecification::factory()->for($recordedProduct)->count(3)->create();

    // Action
    $recordedProduct->fresh();

    // Assert
    expect($recordedProduct)->specialSpecifications->each(function($specialSpecification){
        $specialSpecification->toBeInstanceOf(SpecialSpecification::class);
    });
});

test('検査実績作成済みカラムがfalseのデータを取得する', function(){
    // Arrange
    // beforeEach()でfalseのデータは1件作成済
    RecordedProduct::factory()->for(Product::first())->create([
        'is_created_recorded_inspections' => true
    ]);

    // Action
    $recordedProducts = RecordedProduct::isCreatedRecordedInspections(false)->get();

    // Assert
    expect($recordedProducts)->toHaveCount(1)->each(function($recordedProduct){
        // mysqlのbooleanはintの0で格納されているのでtoBeFalseではなくFalsyで検証する
        $recordedProduct->is_created_recorded_inspections->toBeFalsy();
    });
});

test('検査実績作成済みカラムがtrueのデータを取得する', function(){
    // Arrange
    // beforeEach()でfalseのデータは1件作成済
    RecordedProduct::factory()->for(Product::first())->create([
        'is_created_recorded_inspections' => true
    ]);

    // Action
    $recordedProducts = RecordedProduct::isCreatedRecordedInspections()->get();

    // Assert
    expect($recordedProducts)->toHaveCount(1)->each(function($recordedProduct){
        // mysqlのbooleanはintの0,1で格納されているのでtoBeTrueではなくTruthyで検証する
        $recordedProduct->is_created_recorded_inspections->toBeTruthy();
    });
});

test('検査実績モデルを作成する', function(){
    // Arrange
    Phase::factory()->hasAttached(Product::first())->create();
    // beforeEach()でfalseのデータは1件作成済
    $recordedProduct = RecordedProduct::first();

    // Action
    $recordedProduct->createRecordedInspections();

    // Assert
    expect($recordedProduct)->is_created_recorded_inspections->toBeTruthy()
    // 検査モデルの数(このケースでは品目(1)*工程(1)の1件)だけ作成している
    ->phases->toHaveCount(1)->each(function($phase){
        // 製造実績と工程の中間モデルが検査実績モデル
        $phase->recordedInspection->toBeInstanceOf(RecordedInspection::class);
    });
});

test('親となる品目モデルを変更する', function(){
    // Arrange
    $afterProduct = Product::factory()->create();
    Phase::factory()->hasAttached(Product::first())->create();
    // beforeEach()でfalseのデータは1件作成済
    $recordedProduct = RecordedProduct::first();
    // 整合性担保のため、検査実績は全て削除されるため、事前の存在検証
    $recordedProduct->createRecordedInspections();
    expect($recordedProduct)->is_created_recorded_inspections->toBeTruthy()
    ->phases->toHaveCount(1)->each(function($phase){
        $phase->recordedInspection->toBeInstanceOf(RecordedInspection::class);
    });
    $recordedProduct->save();

    // Action
    $recordedProduct->reassociate($afterProduct);
    $recordedProduct->save();
    $recordedProduct->refresh();

    // Assert
    expect($recordedProduct)->product->id->toBe($afterProduct->id)
    // 変更前の品目に基づく検査実績がdetachされていることを検証
    ->is_created_recorded_inspections->toBeFalsy()
    ->phases->toHaveCount(0);
});
