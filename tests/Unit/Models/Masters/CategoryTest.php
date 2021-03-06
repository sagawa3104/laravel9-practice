<?php

use App\Models\Masters\Category;
use App\Models\Masters\CategoryItem;
use App\Models\Masters\CategoryPhase;
use App\Models\Masters\CategorySpecification;
use App\Models\Masters\Item;
use App\Models\Masters\Phase;
use App\Models\Masters\Specification;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);


test('項目モデルを複数取得できる', function () {
    // Arrange
    $count = 5;
    $category = Category::factory()->has(Item::factory()->count($count))->create();

    // Action

    // Assert
    expect($category)->items->toBeInstanceOf(Illuminate\Database\Eloquent\Collection::class)->toHaveCount(5)
    ->each(function($item){
        $item->toBeInstanceOf(Item::class);
    });
});

test('項目との中間モデルを取得できる', function () {
    // Arrange
    Category::factory()->has(Item::factory())->create();

    // Action
    $item = Item::first();
    // Assert
    expect($item)->categories->each(function($category){
        $category->pivot->toBeInstanceOf(CategoryItem::class);
    });
});

test('工程モデルを複数取得できる', function () {
    // Arrange
    $count = 5;
    $category = Category::factory()->has(Phase::factory()->count($count))->create();

    // Action

    // Assert
    expect($category)->phases->toBeInstanceOf(Illuminate\Database\Eloquent\Collection::class)->toHaveCount(5)
    ->each(function($item){
        $item->toBeInstanceOf(Phase::class);
    });
});

test('工程との中間モデルを取得できる', function () {
    // Arrange
    Category::factory()->has(Phase::factory())->create();

    // Action
    $phase = Phase::first();
    // Assert
    expect($phase)->categories->each(function($category){
        $category->pivot->toBeInstanceOf(CategoryPhase::class);
    });
});

test('仕様モデルを複数取得できる', function () {
    // Arrange
    $count = 5;
    $category = Category::factory()->has(Specification::factory()->count($count))->create();

    // Action

    // Assert
    expect($category)->specifications->toBeInstanceOf(Illuminate\Database\Eloquent\Collection::class)->toHaveCount(5)
    ->each(function($specification){
        $specification->toBeInstanceOf(Specification::class);
    });
});

test('仕様との中間モデルを取得できる', function () {
    // Arrange
    Category::factory()->has(Specification::factory())->create();

    // Action
    $specification = Specification::first();
    // Assert
    expect($specification)->categories->each(function($category){
        $category->pivot->toBeInstanceOf(CategorySpecification::class);
    });
});


test('マッピングカテゴリに対するisMappingThen・isCheckingThenメソッドのテスト', function () {
    // Arrange
    $category = Category::factory()->create([
        'form' => 'MAPPING',
    ]);

    // Action
    // Assert
    expect($category)->isMappingThen(fn($category) => true)->toBeTrue();
    expect($category)->isCheckingThen(fn($category) => true)->toBeFalse();
});

test('チェックリストカテゴリカテゴリに対するisMappingThen・isCheckingThenメソッドのテスト', function () {
    // Arrange
    $category = Category::factory()->create([
        'form' => 'CHECKLIST',
    ]);

    // Action
    // Assert
    expect($category)->isMappingThen(fn($category) => true)->toBeFalse();
    expect($category)->isCheckingThen(fn($category) => true)->toBeTrue();
});
