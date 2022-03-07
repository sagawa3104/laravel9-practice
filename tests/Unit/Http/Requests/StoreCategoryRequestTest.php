<?php

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Masters\Category;
use Illuminate\Support\Facades\Validator;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);


test('カテゴリコードの必須違反', function () {

    // Arrange
    $data = [
        'category_code' => '',
    ];
    $request = new StoreCategoryRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('category_code');
    expect($validator->failed()['category_code'])->toHaveKey('Required');
});

test('カテゴリコードの最大文字列長違反', function () {

    // Arrange
    $data = [
        'category_code' => str_repeat('a', 33),
    ];
    $request = new StoreCategoryRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('category_code');
    expect($validator->failed()['category_code'])->toHaveKey('Max');

});

test('カテゴリコードのDBユニーク違反', function () {

    // Arrange
    $data = [
        'category_code' => Category::factory()->create()->code,
    ];
    $request = new StoreCategoryRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('category_code');
    expect($validator->failed()['category_code'])->toHaveKey('Unique');

});

test('カテゴリ名称の必須違反', function () {

    // Arrange
    $data = [
        'category_name' => '',
    ];
    $request = new StoreCategoryRequest();
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
    $request = new StoreCategoryRequest();
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
    $request = new StoreCategoryRequest();
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
    $request = new StoreCategoryRequest();
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
        'category_code' => str_repeat('a', 32),
        'category_name' => str_repeat('a', 255),
        'form' => $form,
    ];
    $request = new StoreCategoryRequest();
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
