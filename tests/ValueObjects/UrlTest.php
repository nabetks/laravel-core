<?php

namespace Aijoh\Core\Tests\ValueObjects;

use Aijoh\Core\ValueObjects\Url;
use Illuminate\Validation\ValidationException;

test('URL Test', function ($url, $expected) {
    try {
        $url = new Url($url);
        $this->assertTrue($expected);
    } catch (ValidationException $e) {
        $this->assertFalse($expected);
    }
})->with([
    ['https://www.google.com', true],
    ['com', false],
    ['http://www.google.com', true],
]);

test('URL同じかどうかのチェック', function () {})->with([

]);
