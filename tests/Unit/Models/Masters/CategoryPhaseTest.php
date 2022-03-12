<?php

use App\Models\Masters\Category;
use App\Models\Masters\CategoryPhase;
use App\Models\Masters\Phase;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    // Arrange
    $category = Category::factory()->create();
    Phase::factory()->hasAttached($category)->create();
});

test('カテゴリモデルを取得できる', function () {
    // Action
    $categoryPhase = CategoryPhase::first();
    // Assert
    expect($categoryPhase)->category->toBeInstanceOf(Category::class);
});

test('工程モデルを取得できる', function () {
    // Action
    $categoryPhase = CategoryPhase::first();
    // Assert
    expect($categoryPhase)->phase->toBeInstanceOf(Phase::class);
});
