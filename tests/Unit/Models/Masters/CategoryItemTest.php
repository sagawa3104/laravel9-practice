<?php

use App\Models\Masters\Category;
use App\Models\Masters\CategoryItem;
use App\Models\Masters\Item;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    // Arrange
    $category = Category::factory()->create();
    Item::factory()->hasAttached($category)->create();
});

test('カテゴリモデルを取得できる', function () {
    // Action
    $categoryItem = CategoryItem::first();
    // Assert
    expect($categoryItem)->category->toBeInstanceOf(Category::class);
});

test('項目モデルを取得できる', function () {
    // Action
    $categoryItem = CategoryItem::first();
    // Assert
    expect($categoryItem)->item->toBeInstanceOf(Item::class);
});
