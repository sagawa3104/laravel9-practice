<?php

use App\Http\Requests\ApplyItemsForCategoryRequest;
use App\Models\Masters\Item;
use Illuminate\Support\Facades\Validator;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

test('選択部位の存在違反', function () {

    // Arrange
    Item::factory()->create();
    $data = [
        'items' => ['9999'],
    ];
    $request = new ApplyItemsForCategoryRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('items.0');
    expect($validator->failed()['items.0'])->toHaveKey('Exists');

});

test('全選択全解除択一違反', function () {

    // Arrange
    $data = [
        'all' => ['select'=>'1', 'release' =>'1'],
    ];
    $request = new ApplyItemsForCategoryRequest();
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
    $ids = Item::factory()->count(5)->create()->pluck('id');
    $data = [
        'items' => $ids->toArray()
    ];
    $request = new ApplyItemsForCategoryRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeFalse();

});

