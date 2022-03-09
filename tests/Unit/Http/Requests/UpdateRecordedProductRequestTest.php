<?php

use App\Http\Requests\UpdateRecordedProductRequest;
use App\Models\Masters\Product;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

test('品目の必須違反', function () {

    // Arrange
    $data = [
        'product' => '',
    ];
    $request = new UpdateRecordedProductRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('product');
    expect($validator->failed()['product'])->toHaveKey('Required');
});

test('品目の存在違反', function () {

    // Arrange
    $product = Product::factory()->create();
    $data = [
        'product' => '999',
    ];
    $request = new UpdateRecordedProductRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('product');
    expect($validator->failed()['product'])->toHaveKey('Exists');
});

test('品目コード・名称の正常データ', function () {

    // Arrange
    $data = [
        'recorded_product_code' => str_repeat('a', 32),
        'product' => Product::factory()->create()->id,
    ];
    $request = new UpdateRecordedProductRequest();
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
        'recorded_product_code' => str_repeat('a', 255),
        'product' => Product::factory()->create()->id,
        'code' => 'uninteded_parameter',
    ];
    app()->instance('request', Request::create('', 'GET', $data));

    // Act
    $formRequest = app(UpdateRecordedProductRequest::class);
    $input = $formRequest->all();

    // Assert
    expect($input)->code->not->toBe($data['code']);
});
