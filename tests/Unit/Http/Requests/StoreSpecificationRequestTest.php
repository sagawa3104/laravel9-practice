<?php

use App\Http\Requests\StoreSpecificationRequest;
use App\Models\Masters\Specification;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);


test('仕様コードの必須違反', function () {

    // Arrange
    $data = [
        'specification_code' => '',
    ];
    $request = new StoreSpecificationRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('specification_code');
    expect($validator->failed()['specification_code'])->toHaveKey('Required');
});

test('仕様コードの最大文字列長違反', function () {

    // Arrange
    $data = [
        'specification_code' => str_repeat('a', 33),
    ];
    $request = new StoreSpecificationRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('specification_code');
    expect($validator->failed()['specification_code'])->toHaveKey('Max');

});

test('仕様コードのDBユニーク違反', function () {

    // Arrange
    $data = [
        'specification_code' => Specification::factory()->create()->code,
    ];
    $request = new StoreSpecificationRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('specification_code');
    expect($validator->failed()['specification_code'])->toHaveKey('Unique');

});

test('仕様名称の必須違反', function () {

    // Arrange
    $data = [
        'specification_name' => '',
    ];
    $request = new StoreSpecificationRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('specification_name');
    expect($validator->failed()['specification_name'])->toHaveKey('Required');

});

test('仕様名称の最大文字列長違反', function () {

    // Arrange
    $data = [
        'specification_name' => str_repeat('a', 256),
    ];
    $request = new StoreSpecificationRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('specification_name');
    expect($validator->failed()['specification_name'])->toHaveKey('Max');

});

test('仕様コード・名称の正常データ', function () {

    // Arrange
    $data = [
        'specification_code' => str_repeat('a', 32),
        'specification_name' => str_repeat('a', 255),
    ];
    $request = new StoreSpecificationRequest();
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
        'specification_code' => str_repeat('a', 32),
        'specification_name' => str_repeat('a', 255),
        'code' => 'uninteded_parameter',
        'name' => 'uninteded_parameter',
    ];
    app()->instance('request', Request::create('', 'GET', $data));

    // Act
    $formRequest = app(StoreSpecificationRequest::class);
    $input = $formRequest->all();

    // Assert
    expect($input)->toHaveKeys(['code', 'name'])
    ->code->not->toBe($data['code'])->toBe($data['specification_code'])
    ->name->not->toBe($data['name'])->toBe($data['specification_name']);
});
