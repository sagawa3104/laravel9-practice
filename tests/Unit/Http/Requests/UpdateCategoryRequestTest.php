<?php

use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);


test('カテゴリ名称の必須違反', function () {

    // Arrange
    $data = [
        'category_name' => '',
    ];
    $request = new UpdateCategoryRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('category_name');
    expect($validator->failed()['category_name'])->toHaveKey('Required');

});

test('カテゴリ名称の最大文字列長違反', function () {

    // Arrange
    $data = [
        'category_name' => str_repeat('a', 256),
    ];
    $request = new UpdateCategoryRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('category_name');
    expect($validator->failed()['category_name'])->toHaveKey('Max');

});

test('フォームの必須違反', function () {

    // Arrange
    $data = [
        'form' => '',
    ];
    $request = new UpdateCategoryRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('form');
    expect($validator->failed()['form'])->toHaveKey('Required');
});

test('フォームの指定値違反', function ($form) {

    // Arrange
    $data = [
        'form' => $form,
    ];
    $request = new UpdateCategoryRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('form');
    expect($validator->failed()['form'])->toHaveKey('In');
})->with([
    'test',
    '1234',
]);

test('カテゴリコード・名称の正常データ', function ($form) {

    // Arrange
    $data = [
        'category_name' => str_repeat('a', 255),
        'form' => $form,
    ];
    $request = new UpdateCategoryRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeFalse();

})->with([
    'MAPPING',
    'CHECKLIST',
]);

test('正常データ時の補間パラメータのテスト', function () {

    // Arrange
    $data = [
        'category_name' => str_repeat('a', 255),
        'form' => 'CHECKLIST',
        'code' => 'uninteded_parameter',
        'name' => 'uninteded_parameter',
    ];
    app()->instance('request', Request::create('', 'GET', $data));

    // Act
    $formRequest = app(UpdateCategoryRequest::class);
    $input = $formRequest->all();

    // Assert
    expect($input)->toHaveKeys(['name', 'is_by_recorded_product'])
    ->code->not->toBe($data['code'])
    ->name->not->toBe($data['name'])->toBe($data['category_name'])
    ->is_by_recorded_product->toBe(isset($data['is_by_recorded_product']));
});
