<?php

use Aijoh\Core\Supports\Csv\TitledCsvReader;
use Aijoh\Core\Exceptions\IOException;
use Aijoh\Core\Exceptions\FileNotFoundException;
use Aijoh\Core\Exceptions\InvalidFileEncodingException;

test('タイトル行を持つCSVファイルを正しく読み込める', function($encoding) {
    $csvFile = "/test_titled_csv_{$encoding}.csv";
    $csvText = <<< __END__
名前,年齢,住所
山田太郎,30,東京都
佐藤花子,25,大阪府
鈴木一郎,40,北海道
__END__;

    file_put_contents($csvFile, mb_convert_encoding($csvText, $encoding, 'UTF-8'));

    $reader = new TitledCsvReader($csvFile, $encoding);

    // タイトル行が正しく読み込まれていることを確認
    expect($reader->getTitles())->toBe(['名前', '年齢', '住所']);

    // 1行目のデータを取得して確認
    $row1 = $reader->next();
    expect($row1)->not->toBeNull();
    expect($row1->get('名前'))->toBe('山田太郎');
    expect($row1->get('年齢'))->toBe('30');
    expect($row1->get('住所'))->toBe('東京都');

    // 2行目のデータを取得して確認
    $row2 = $reader->next();
    expect($row2)->not->toBeNull();
    expect($row2->get('名前'))->toBe('佐藤花子');
    expect($row2->get('年齢'))->toBe('25');
    expect($row2->get('住所'))->toBe('大阪府');

    // 3行目のデータを取得して確認
    $row3 = $reader->next();
    expect($row3)->not->toBeNull();
    expect($row3->get('名前'))->toBe('鈴木一郎');
    expect($row3->get('年齢'))->toBe('40');
    expect($row3->get('住所'))->toBe('北海道');

    // ファイルの終端に達したらnullが返ることを確認
    $row4 = $reader->next();
    expect($row4)->toBeNull();

    unlink($csvFile);
})->with([
    'UTF-8',
    'MS932',
    'EUC-JP',
]);

test('存在しないファイルを指定した場合にFileNotFoundExceptionが発生する', function() {
    expect(fn() => new TitledCsvReader('/not_existing_file.csv'))
        ->toThrow(FileNotFoundException::class);
});

test('タイトル行が空のCSVファイルを読み込むとIOExceptionが発生する', function() {
    $csvFile = "/test_empty_csv.csv";
    file_put_contents($csvFile, '');

    expect(fn() => new TitledCsvReader($csvFile))
        ->toThrow(IOException::class, 'タイトル行の読み込みに失敗しました。');

    unlink($csvFile);
});

test('インデックスを使って値を取得できる', function() {
    $csvFile = "/test_titled_csv_index.csv";
    $csvText = <<< __END__
名前,年齢,住所
山田太郎,30,東京都
__END__;

    file_put_contents($csvFile, $csvText);

    $reader = new TitledCsvReader($csvFile);
    $row = $reader->next();

    expect($row->get(0))->toBe('山田太郎');
    expect($row->get(1))->toBe('30');
    expect($row->get(2))->toBe('東京都');

    unlink($csvFile);
});

test('異なる区切り文字とエンクロージャーを使用したCSVファイルを読み込める', function() {
    $csvFile = "/test_titled_csv_delimiter.csv";
    $csvText = <<< __END__
"名前";"年齢";"住所"
"山田太郎";"30";"東京都"
__END__;

    file_put_contents($csvFile, $csvText);

    $reader = new TitledCsvReader($csvFile, 'UTF-8', ';', '"');

    expect($reader->getTitles())->toBe(['名前', '年齢', '住所']);

    $row = $reader->next();
    expect($row)->not->toBeNull();
    expect($row->get('名前'))->toBe('山田太郎');
    expect($row->get('年齢'))->toBe('30');
    expect($row->get('住所'))->toBe('東京都');

    unlink($csvFile);
});

test('タイトル行の列数より少ない列数のデータ行を読み込める', function() {
    $csvFile = "/test_titled_csv_less_columns.csv";
    $csvText = <<< __END__
名前,年齢,住所,電話番号
山田太郎,30,東京都
佐藤花子,25
__END__;

    file_put_contents($csvFile, $csvText);

    $reader = new TitledCsvReader($csvFile);

    // 1行目のデータを取得して確認（電話番号列がない）
    $row1 = $reader->next();
    expect($row1)->not->toBeNull();
    expect($row1->get('名前'))->toBe('山田太郎');
    expect($row1->get('年齢'))->toBe('30');
    expect($row1->get('住所'))->toBe('東京都');
    expect($row1->get('電話番号'))->toBeNull();

    // 2行目のデータを取得して確認（住所と電話番号列がない）
    $row2 = $reader->next();
    expect($row2)->not->toBeNull();
    expect($row2->get('名前'))->toBe('佐藤花子');
    expect($row2->get('年齢'))->toBe('25');
    expect($row2->get('住所'))->toBeNull();
    expect($row2->get('電話番号'))->toBeNull();

    unlink($csvFile);
});

test('無効な文字エンコーディングを指定した場合にInvalidFileEncodingExceptionが発生する', function() {
    $csvFile = "/test_titled_csv_encoding.csv";
    $csvText = <<< __END__
名前,年齢,住所
山田太郎,30,東京都
__END__;

    file_put_contents($csvFile, $csvText);

    expect(fn() => new TitledCsvReader($csvFile, 'INVALID_ENCODING'))
        ->toThrow(InvalidFileEncodingException::class);

    unlink($csvFile);
});
