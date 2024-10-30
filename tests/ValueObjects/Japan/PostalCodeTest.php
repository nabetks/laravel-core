<?php

namespace Aijoh\Core\Tests\ValueObjects\Japan;

use Aijoh\Core\ValueObjects\Japan\PostalCode;

test('郵便番号フォーマット',function($code,$results){
    $postalCode = new PostalCode($code);
    $this->assertEquals($results,$postalCode->value());
})->with([
    'ハイフンなしのフォーマット確認' => ['1234567', '1234567'],
    '郵便番号のフォーマット確認' => ['123-4567', '1234567'],
    '全角数字の郵便番号のフォーマット確認' => ['１２３４５６７', '1234567'],
    '全角数字の郵便番号のフォーマット確認2' => ['１２３-４５６７', '1234567'],
    '全角数字の郵便番号のフォーマット確認3' => ['１２３－４５６７', '1234567'],
]);


