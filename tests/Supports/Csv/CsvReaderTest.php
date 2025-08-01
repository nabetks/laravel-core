<?php

use Aijoh\Core\Supports\Csv\CsvReader;

test('文字コード別 CSVデータの読み込み', function ($encoding) {
    $csvFile = "/test001{$encoding}.csv";
    $csvText = <<< '__END__'
01,02,03
1,2,3
あいうえお,かきくけこ,さしすせそ
"漢字","カタカナ",alphabet
__END__;

    file_put_contents($csvFile, mb_convert_encoding($csvText, $encoding, 'UTF-8'));
    $reader = new CsvReader($csvFile, $encoding);
    $results = $reader->getCsv();
    expect($results)->toBe(['01', '02', '03']);
    $reader->next();
    $results = $reader->getCsv();
    expect($results)->toBe(['1', '2', '3']);

    $reader->next();
    $results = $reader->getCsv();
    expect($results)->toBe(['あいうえお', 'かきくけこ', 'さしすせそ']);

    $reader->next();
    $results = $reader->getCsv();
    expect($results)->toBe(['漢字', 'カタカナ', 'alphabet']);

    $reader->next();
    $results = $reader->getCsv();
    expect($results)->toBe(false);

    unlink($csvFile);
})->with(
    [
        'UTF-8',
        'MS932',
        'EUC-JP',
    ]
);

test('文字コード別 Seekテスト', function ($encoding) {
    $csvFile = "/test001{$encoding}.csv";
    $csvText = <<< '__END__'
01,02,03
1,2,3
あいうえお,かきくけこ,さしすせそ
"漢字","カタカナ",alphabet
__END__;

    file_put_contents($csvFile, mb_convert_encoding($csvText, $encoding, 'UTF-8'));
    $reader = new CsvReader($csvFile, $encoding);
    $results = $reader->getCsv();
    $reader->next();
    $reader->next();
    $reader->next();
    $reader->seekLine(2);
    $results = $reader->getCsv();
    expect($results)->toBe(['あいうえお', 'かきくけこ', 'さしすせそ']);

    unlink($csvFile);
})->with(
    [
        'UTF-8',
        'MS932',
        'EUC-JP',
    ]
);
