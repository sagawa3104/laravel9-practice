<?php

use App\Models\Masters\Category;
use App\Models\Masters\CategoryItem;
use App\Models\Masters\Item;

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
