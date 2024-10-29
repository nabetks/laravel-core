<?php

use Aijoh\Core\ValueObjects\Url;

test('Url Test', function () {
    $url = new Url('https://www.google.com');
    expect($url->isHttps())->toBeTrue();
});
