<?php

use App\Http\Requests\UpdateSpecificationRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

test('仕様名称の必須違反', function () {

    // Arrange
    $data = [
        'specification_name' => '',
    ];
    $request = new UpdateSpecificationRequest();
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
    $request = new UpdateSpecificationRequest();
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
        'specification_name' => str_repeat('a', 255),
    ];
    $request = new UpdateSpecificationRequest();
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
        'specification_name' => str_repeat('a', 255),
        'code' => 'uninteded_parameter',
        'name' => 'uninteded_parameter',
    ];
    app()->instance('request', Request::create('', 'GET', $data));

    // Act
    $formRequest = app(UpdateSpecificationRequest::class);
    $input = $formRequest->all();

    // Assert
    expect($input)->toHaveKeys(['name'])
    ->code->not->toBe($data['code'])
    ->name->not->toBe($data['name'])->toBe($data['specification_name']);
});
