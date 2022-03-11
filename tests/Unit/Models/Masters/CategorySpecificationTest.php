<?php

use App\Models\Masters\Category;
use App\Models\Masters\CategorySpecification;
use App\Models\Masters\Specification;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    // Arrange
    $category = Category::factory()->create();
    Specification::factory()->hasAttached($category)->create();
});

test('カテゴリモデルを取得できる', function () {
    // Action
    $categorySpecification = CategorySpecification::first();
    // Assert
    expect($categorySpecification)->category->toBeInstanceOf(Category::class);
});

test('仕様モデルを取得できる', function () {
    // Action
    $categorySpecification = CategorySpecification::first();
    // Assert
    expect($categorySpecification)->specification->toBeInstanceOf(Specification::class);
});
