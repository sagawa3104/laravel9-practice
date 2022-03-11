<?php

use App\Models\Masters\Category;
use App\Models\Masters\CategoryItem;
use App\Models\Masters\CategorySpecification;
use App\Models\Masters\Item;
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
