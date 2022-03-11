<?php

use App\Http\Requests\ApplySpecificationsForCategoryRequest;
use App\Models\Masters\Specification;
use Illuminate\Support\Facades\Validator;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

test('選択部位の存在違反', function () {

    // Arrange
    Specification::factory()->create();
    $data = [
        'specifications' => ['9999'],
    ];
    $request = new ApplySpecificationsForCategoryRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('specifications.0');
    expect($validator->failed()['specifications.0'])->toHaveKey('Exists');

});

test('全選択全解除択一違反', function () {

    // Arrange
    $data = [
        'all' => ['select'=>'1', 'release' =>'1'],
    ];
    $request = new ApplySpecificationsForCategoryRequest();
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
    $ids = Specification::factory()->count(5)->create()->pluck('id');
    $data = [
        'specifications' => $ids->toArray()
    ];
    $request = new ApplySpecificationsForCategoryRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeFalse();

});

