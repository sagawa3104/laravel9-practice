<?php

use App\Models\Masters\Category;
use App\Models\Masters\CategoryInspection;
use App\Models\Masters\CategoryItem;
use App\Models\Masters\Inspection;
use App\Models\Masters\Item;
use App\Models\Masters\Phase;
use App\Models\Masters\Product;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    // Arrange
    $product = Product::factory()->create();
    Phase::factory()->hasAttached($product)->create();
    Category::factory()->hasAttached(Inspection::first())->create();
});

test('カテゴリモデルを取得できる', function () {
    // Action
    $categoryInspection = CategoryInspection::first();
    // Assert
    expect($categoryInspection)->category->toBeInstanceOf(Category::class);
});

test('検査モデルを取得できる', function () {
    // Action
    $categoryInspection = CategoryInspection::first();
    // Assert
    expect($categoryInspection)->inspection->toBeInstanceOf(Inspection::class);
});
