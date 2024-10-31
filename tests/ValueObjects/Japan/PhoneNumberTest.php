<?php

namespace Aijoh\Core\Tests\ValueObjects\Japan;

use Aijoh\Core\ValueObjects\Japan\PhoneNumber;
use Aijoh\Core\ValueObjects\Japan\PostalCode;
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
    '空のデータ' => ['', ''],
    'nullのデータ' => [null, ''],
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

test('携帯電話判別', function ($tel, $results) {
    $number = new PhoneNumber($tel);
    $this->assertEquals($results, $number->isMobile());
})->with([
    '携帯電話(090)' => ['09012345678', true],
    '携帯電話(080)' => ['08012345678', true],
    '携帯電話(070)' => ['07012345678', true],
    '携帯電話(060)' => ['06012345678', true],
    '携帯電話(090)国際番号' => ['+819012345678', true],
    '携帯電話(080)国際番号' => ['+818012345678', true],
    '携帯電話(070)国際番号' => ['+817012345678', true],
    '携帯電話(060)国際番号' => ['+816012345678', true],
]);

test('オブジェクトの比較', function ($tel1, $tel2, $results) {
    $number1 = new PhoneNumber($tel1);
    $number2 = new PhoneNumber($tel2);
    $this->assertEquals($results, $number1->equals($number2));
})->with([
    '同じ電話番号' => ['09012345678', '09012345678', true],
    '違う電話番号' => ['09012345678', '0312345678', false],
    'nullのデータ' => ['', '0312345678', false],
    'nullのデータ2' => ['09012345678', '', false],
    'nullのデータ3' => ['', '', true],
]);

test('別のオブジェクト比較', function ($tel, $postal) {
    $number = new PhoneNumber($tel);
    $postal = new PostalCode($postal);
    $this->assertFalse($number->equals($postal));
})->with([
    '電話番号と郵便番号' => ['09012345678', '100-0001'],
    '電話番号とnull' => ['09012345678', null],
    '電話番号と空' => ['09012345678', ''],
    '空の電話番号と郵便番号' => ['', ''],
]);
