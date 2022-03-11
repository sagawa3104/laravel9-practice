<?php

use App\Models\Masters\Category;
use App\Models\Masters\CategorySpecification;
use App\Models\Masters\Product;
use App\Models\Masters\ProductSpecification;
use App\Models\Masters\Specification;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);


test('品目モデルを複数取得できる', function () {
    // Arrange
    $count = 5;
    $specification = Specification::factory()->has(Product::factory()->count($count))->create();

    // Action

    // Assert
    expect($specification)->products->toBeInstanceOf(Illuminate\Database\Eloquent\Collection::class)->toHaveCount($count)
    ->each(function($product){
        $product->toBeInstanceOf(Product::class);
    });
});

test('品目との中間モデルを取得できる', function () {
    // Arrange
    Specification::factory()->has(Product::factory())->create();

    // Action
    $product = Product::first();
    // Assert
    expect($product)->specifications->each(function($specification){
        $specification->pivot->toBeInstanceOf(ProductSpecification::class);
    });
});

test('カテゴリモデルを複数取得できる', function () {
    // Arrange
    $count = 5;
    $specification = Specification::factory()->has(Category::factory()->count($count))->create();

    // Action

    // Assert
    expect($specification)->categories->toBeInstanceOf(Illuminate\Database\Eloquent\Collection::class)->toHaveCount($count)
    ->each(function($category){
        $category->toBeInstanceOf(Category::class);
    });
});

test('カテゴリとの中間モデルを取得できる', function () {
    // Arrange
    Specification::factory()->has(Category::factory())->create();

    // Action
    $category = Category::first();
    // Assert
    expect($category)->specifications->each(function($specification){
        $specification->pivot->toBeInstanceOf(CategorySpecification::class);
    });
});
