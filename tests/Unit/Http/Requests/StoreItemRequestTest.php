<?php

use App\Http\Requests\StoreItemRequest;
use App\Models\Masters\Item;
use Illuminate\Support\Facades\Validator;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);


test('項目コードの必須違反', function () {

    // Arrange
    $data = [
        'item_code' => '',
    ];
    $request = new StoreItemRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('item_code');
    expect($validator->failed()['item_code'])->toHaveKey('Required');
});

test('項目コードの最大文字列長違反', function () {

    // Arrange
    $data = [
        'item_code' => str_repeat('a', 33),
    ];
    $request = new StoreItemRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('item_code');
    expect($validator->failed()['item_code'])->toHaveKey('Max');

});

test('項目コードのDBユニーク違反', function () {

    // Arrange
    $data = [
        'item_code' => Item::factory()->create()->code,
    ];
    $request = new StoreItemRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('item_code');
    expect($validator->failed()['item_code'])->toHaveKey('Unique');

});

test('項目名称の必須違反', function () {

    // Arrange
    $data = [
        'item_name' => '',
    ];
    $request = new StoreItemRequest();
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
    $request = new StoreItemRequest();
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
        'item_code' => str_repeat('a', 32),
        'item_name' => str_repeat('a', 255),
    ];
    $request = new StoreItemRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeFalse();

});
