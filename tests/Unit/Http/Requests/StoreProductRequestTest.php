<?php

use App\Http\Requests\StoreProductRequest;
use App\Models\Masters\Product;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);


test('品目コードの必須違反', function () {

    // Arrange
    $data = [
        'product_code' => '',
    ];
    $request = new StoreProductRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('product_code');
    expect($validator->failed()['product_code'])->toHaveKey('Required');
});

test('品目コードの最大文字列長違反', function () {

    // Arrange
    $data = [
        'product_code' => str_repeat('a', 33),
    ];
    $request = new StoreProductRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('product_code');
    expect($validator->failed()['product_code'])->toHaveKey('Max');

});

test('品目コードのDBユニーク違反', function () {

    // Arrange
    $data = [
        'product_code' => Product::factory()->create()->code,
    ];
    $request = new StoreProductRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('product_code');
    expect($validator->failed()['product_code'])->toHaveKey('Unique');

});

test('品目名称の必須違反', function () {

    // Arrange
    $data = [
        'product_name' => '',
    ];
    $request = new StoreProductRequest();
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
    $request = new StoreProductRequest();
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
        'product_code' => str_repeat('a', 32),
        'product_name' => str_repeat('a', 255),
    ];
    $request = new StoreProductRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeFalse();

});

test('正常データ時の補間パラメータのテスト', function () {

    // Arrange
    $data = [
        'product_code' => str_repeat('a', 32),
        'product_name' => str_repeat('a', 255),
        'code' => 'uninteded_parameter',
        'name' => 'uninteded_parameter',
    ];
    app()->instance('request', Request::create('', 'GET', $data));

    // Act
    $formRequest = app(StoreProductRequest::class);
    $input = $formRequest->all();

    // Assert
    expect($input)->toHaveKeys(['code', 'name'])
    ->code->not->toBe($data['code'])->toBe($data['product_code'])
    ->name->not->toBe($data['name'])->toBe($data['product_name']);
});
