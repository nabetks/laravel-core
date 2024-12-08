<?php

namespace Aijoh\Core\Rules;

use Illuminate\Support\Facades\Validator;

test('データのチェック', function (string $encode, int $min, int $max, string $txt, bool $expected) {
    $validator = Validator::make(
        [
            'str' => $txt,
        ],
        [
            'str' => [new EncodeByteBetweenRule($encode, $min, $max)],
        ]
    );

    if ($validator->fails()) {
        $this->assertFalse($expected);
    } else {
        $this->assertTrue($expected);
    }

})->with(
    [

        'ひらがなのバイト数チェック' => ['EUC-JP', 1, 3, 'あ', true],
        'ひらがなのバイト数オーバーチェック' => ['EUC-JP', 1, 3, 'ああ', false],
        '漢字バイト数最小バイト数と同じ' => ['MS932', 2, 2, '漢', true],
        '漢字バイト数最小バイト数より小さい' => ['MS932', 3, 3, '亜', false],
    ]
);
