<?php

namespace Aijoh\Core\Tests\ValueObjects;

use Aijoh\Core\ValueObjects\PhoneNumber;
use Illuminate\Validation\ValidationException;

test('電話番号フォーマット変換確認', function ($tel, $results) {
    $number = new PhoneNumber($tel);
    $this->assertEquals($results, $number->value());
})->with([
    '電話番号のフォーマット確認' => ['090-1234-5678', '09012345678'],
    '電話番号のフォーマット確認市外局番()あり' => ['03(1234)5678', '0312345678'],
    '全角数字の電話番号のフォーマット確認' => ['０９０１２３４５６７８', '09012345678'],
    '国際番号形式での入力' => ['+819012345678', '09012345678'],
    '国際番号形式の入力2' => ['81312345678', '0312345678'],
]);

test('電話番号の入力値の確認', function ($tel, $results) {
    try {
        new PhoneNumber($tel);
        $this->assertTrue($results);
    } catch (ValidationException $e) {
        $this->assertFalse($results);
    }
})->with([
    '正しい番号の入力' => ['09012345678', true],
    '数字以外が含まれている' => ['0901234567a', false],
    '全角数字での入力' => ['０９０１２３４５６７８', true],
    '桁数が少ない' => ['0901234', false],
    '桁数が多い' => ['090123456789000000', false],
]);

test('国際番号変換', function ($tel, $results) {
    $number = new PhoneNumber($tel);
    $this->assertEquals($results, $number->getInternationalPhoneNumber());
})->with([
    '国際番号変換1' => ['09012345678', '+819012345678'],
    '国際番号変換2' => ['0312345678', '+81312345678'],
    '国際番号変換3' => ['０９０１２３４５６７８', '+819012345678'],
]);

