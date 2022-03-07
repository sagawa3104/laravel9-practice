<?php

use App\Models\Masters\Category;
use App\Models\Masters\CategoryItem;
use App\Models\Masters\Item;

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
