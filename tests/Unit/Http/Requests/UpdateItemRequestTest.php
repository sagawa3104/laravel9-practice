<?php

use App\Http\Requests\UpdateItemRequest;
use Illuminate\Support\Facades\Validator;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

test('項目名称の必須違反', function () {

    // Arrange
    $data = [
        'item_name' => '',
    ];
    $request = new UpdateItemRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('item_name');
    expect($validator->failed()['item_name'])->toHaveKey('Required');

});

test('項目名称の最大文字列長違反', function () {

    // Arrange
    $data = [
        'item_name' => str_repeat('a', 256),
    ];
    $request = new UpdateItemRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('item_name');
    expect($validator->failed()['item_name'])->toHaveKey('Max');

});

test('項目コード・名称の正常データ', function () {

    // Arrange
    $data = [
        'item_name' => str_repeat('a', 255),
    ];
    $request = new UpdateItemRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeFalse();

});
