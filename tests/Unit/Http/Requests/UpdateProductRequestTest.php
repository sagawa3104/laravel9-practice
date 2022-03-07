<?php

use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Validator;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

test('品目名称の必須違反', function () {

    // Arrange
    $data = [
        'product_name' => '',
    ];
    $request = new UpdateProductRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('product_name');
    expect($validator->failed()['product_name'])->toHaveKey('Required');

});

test('品目名称の最大文字列長違反', function () {

    // Arrange
    $data = [
        'product_name' => str_repeat('a', 256),
    ];
    $request = new UpdateProductRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('product_name');
    expect($validator->failed()['product_name'])->toHaveKey('Max');

});

test('品目コード・名称の正常データ', function () {

    // Arrange
    $data = [
        'product_name' => str_repeat('a', 255),
    ];
    $request = new UpdateProductRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeFalse();

});
