<?php

use App\Http\Requests\StoreRecordedProductRequest;
use App\Models\Masters\Product;
use App\Models\Transactions\RecordedProduct;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);


test('品目の必須違反', function () {

    // Arrange
    $data = [
        'product' => '',
    ];
    $request = new StoreRecordedProductRequest();
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
    $request = new StoreRecordedProductRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('product');
    expect($validator->failed()['product'])->toHaveKey('Exists');
});

test('製造番号の必須違反', function () {

    // Arrange
    $data = [
        'recorded_product_code' => '',
    ];
    $request = new StoreRecordedProductRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('recorded_product_code');
    expect($validator->failed()['recorded_product_code'])->toHaveKey('Required');
});

test('製造番号の最大文字列長違反', function () {

    // Arrange
    $data = [
        'recorded_product_code' => str_repeat('a', 33),
    ];
    $request = new StoreRecordedProductRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('recorded_product_code');
    expect($validator->failed()['recorded_product_code'])->toHaveKey('Max');

});

test('製造番号のDBユニーク違反', function () {

    // Arrange
    $data = [
        'recorded_product_code' => RecordedProduct::factory()->for( Product::factory()->create() )->create()->code,
    ];
    $request = new StoreRecordedProductRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('recorded_product_code');
    expect($validator->failed()['recorded_product_code'])->toHaveKey('Unique');

});

test('品目・製番コードの正常データ', function () {

    // Arrange
    $data = [
        'recorded_product_code' => str_repeat('a', 32),
        'product' => Product::factory()->create()->id,
    ];
    $request = new StoreRecordedProductRequest();
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
        'recorded_product_code' => str_repeat('a', 32),
        'product' => Product::factory()->create()->id,
        'code' => 'uninteded_parameter',
    ];
    app()->instance('request', Request::create('', 'GET', $data));

    // Act
    $formRequest = app(StoreRecordedProductRequest::class);
    $input = $formRequest->all();

    // Assert
    expect($input)->toHaveKeys(['code'])
    ->code->not->toBe($data['code'])->toBe($data['recorded_product_code'])
    ->is_created_recorded_inspections->toBe(isset($data['is_created_recorded_inspections']));
});


