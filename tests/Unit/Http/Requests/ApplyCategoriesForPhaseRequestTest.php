<?php

use App\Http\Requests\ApplyCategoriesForPhaseRequest;
use App\Models\Masters\Category;
use App\Models\Masters\Phase;
use Illuminate\Support\Facades\Validator;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

test('選択部位の存在違反', function () {

    // Arrange
    Category::factory()->create();
    $data = [
        'categories' => ['9999'],
    ];
    $request = new ApplyCategoriesForPhaseRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('categories.0');
    expect($validator->failed()['categories.0'])->toHaveKey('Exists');

});

test('全選択全解除択一違反', function () {

    // Arrange
    $data = [
        'all' => ['select'=>'1', 'release' =>'1'],
    ];
    $request = new ApplyCategoriesForPhaseRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('all');
    expect($validator->failed()['all'])->toHaveKey('Max');

});

test('正常データ', function () {

    // Arrange
    $ids = Category::factory()->count(5)->create()->pluck('id');
    $data = [
        'categories' => $ids->toArray()
    ];
    $request = new ApplyCategoriesForPhaseRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeFalse();

});

