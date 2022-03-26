<?php

use App\Models\Masters\Category;
use App\Models\Masters\CategoryItem;
use App\Models\Masters\Item;
use App\Models\Masters\Phase;
use App\Models\Masters\Product;
use App\Models\Masters\Unit;
use App\Models\Transactions\RecordedInspection;
use App\Models\Transactions\RecordedInspectionDetail;
use App\Models\Transactions\RecordedInspectionDetailChecking;
use App\Models\Transactions\RecordedInspectionDetailMapping;
use App\Models\Transactions\RecordedProduct;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);


test('カテゴリモデルを複数取得できる', function () {
    // Arrange
    $count = 5;
    $item = Item::factory()->has(Category::factory()->count($count))->create();

    // Action

    // Assert
    expect($item)->categories->toBeInstanceOf(Illuminate\Database\Eloquent\Collection::class)->toHaveCount(5)
    ->each(function($category){
        $category->toBeInstanceOf(Category::class);
    });
});

test('カテゴリとの中間モデルを取得できる', function () {
    // Arrange
    Item::factory()->has(Category::factory())->create();

    // Action
    $category = Category::first();
    // Assert
    expect($category)->items->each(function($item){
        $item->pivot->toBeInstanceOf(CategoryItem::class);
    });
});

test('検査実績明細マッピングモデルを取得できる', function () {
    // Arrange
    RecordedProduct::factory()->for( Product::factory() )->has( Phase::factory() )->create();
    $recordedInspection = RecordedInspection::first();
    $unit = Unit::factory()->create();
    $item = Item::factory()->create();
    RecordedInspectionDetailMapping::factory()->for( RecordedInspectionDetail::factory()->for($recordedInspection)->state(['type' => 'MAPPING']) )
    ->for($unit)->for($item)->create([
        'x_point' => $unit->x_length,
        'y_point' => $unit->y_length,
    ]);

    // Action
    $item->refresh();

    // Assert
    expect($item)->recordedInspectionDetailMappings->each(function($recordedInspectionDetailMapping){
        $recordedInspectionDetailMapping->toBeInstanceOf(RecordedInspectionDetailMapping::class);
    });
});

test('検査実績明細チェックリストモデルを取得できる', function () {
    // Arrange
    RecordedProduct::factory()->for( Product::factory() )->has( Phase::factory() )->create();
    $recordedInspection = RecordedInspection::first();
    $item = Item::factory()->create();
    RecordedInspectionDetailChecking::factory()->for( RecordedInspectionDetail::factory()->for($recordedInspection)->state(['type' => 'CHECKING']) )
    ->for($item)->create([
        'type' => 'ITEM'
    ]);

    // Action
    $item->refresh();

    // Assert
    expect($item)->recordedInspectionDetailCheckings->each(function($recordedInspectionDetailChecking){
        $recordedInspectionDetailChecking->toBeInstanceOf(RecordedInspectionDetailChecking::class);
    });
});
