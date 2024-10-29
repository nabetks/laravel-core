<?php

namespace Aijoh\Core\Tests\ValueObjects;

use Aijoh\Core\ValueObjects\Url;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Orchestra\Testbench\TestCase as Orchestra;
use PHPUnit\Framework\Attributes\DataProvider;

test('URL Test',function($url,$expected){
    try {
        $url = new Url($url);
        $this->assertTrue($expected);
    }catch (ValidationException $e){
        $this->assertFalse($expected);
    }
})->with([
    ['https://www.google.com',true],
    ['com',false],
    ['http://www.google.com',true],
]);

