<?php

namespace Aijoh\Core\Tests\Supports\File;

use Aijoh\Core\Exceptions\FileNotFoundException;
use Aijoh\Core\Supports\File\FileEncodingValidator;

test('it validates file encoding successfully', function () {
    $filePath = __DIR__.'/resources/utf8-file.txt';
    file_put_contents($filePath, 'This is a UTF-8 file', FILE_TEXT);

    $result = FileEncodingValidator::validate($filePath, 'UTF-8');
    expect($result)->toBe(true);

    unlink($filePath);
});

test('it throws FileNotFoundException if file does not exist', function () {
    $filePath = __DIR__.'/resources/nonexistent-file.txt';

    expect(fn () => FileEncodingValidator::validate($filePath, 'UTF-8'))
        ->toThrow(FileNotFoundException::class);
});

test('it returns false if file encoding does not match', function () {
    $filePath = __DIR__.'/resources/different-encoding-file.txt';
    file_put_contents($filePath, mb_convert_encoding('これはUTF-8ではありません。', 'MS932', 'UTF-8'));

    $result = FileEncodingValidator::validate($filePath, 'UTF-8');
    expect($result)->toBe(false);

    unlink($filePath);
});

test('MS932文字のチェック成功', function () {
    $filePath = __DIR__.'/resources/ms932-file.txt';
    file_put_contents($filePath, mb_convert_encoding('これはMS932のファイルです。', 'MS932', 'UTF-8'));
    $result = FileEncodingValidator::validate($filePath, 'MS932');
    expect($result)->toBe(true);

    unlink($filePath);
});

test('無効なエンコードのチェック', function () {
    $filePath = __DIR__.'/resources/ms932-file.txt';
    file_put_contents($filePath, mb_convert_encoding('これはMS932のファイルです。', 'MS932', 'UTF-8'));
    $result = FileEncodingValidator::validate($filePath, 'INVALID-ENCODING');
    expect($result)->toBe(false);

    unlink($filePath);
});
