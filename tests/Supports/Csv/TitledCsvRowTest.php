<?php

use Aijoh\Core\Supports\Csv\TitledCsvMapper;
use Aijoh\Core\Supports\Csv\TitledCsvRow;

test('タイトルを指定して値を取得できる', function () {
    $titles = ['名前', '年齢', '住所'];
    $values = ['山田太郎', '30', '東京都'];
    $mapper = new TitledCsvMapper($titles);
    $row = new TitledCsvRow($mapper, $values);

    expect($row->get('名前'))->toBe('山田太郎');
    expect($row->get('年齢'))->toBe('30');
    expect($row->get('住所'))->toBe('東京都');
});

test('インデックスを指定して値を取得できる', function () {
    $titles = ['名前', '年齢', '住所'];
    $values = ['山田太郎', '30', '東京都'];
    $mapper = new TitledCsvMapper($titles);
    $row = new TitledCsvRow($mapper, $values);

    expect($row->get(0))->toBe('山田太郎');
    expect($row->get(1))->toBe('30');
    expect($row->get(2))->toBe('東京都');
});

test('存在しないタイトルを指定するとnullが返る', function () {
    $titles = ['名前', '年齢', '住所'];
    $values = ['山田太郎', '30', '東京都'];
    $mapper = new TitledCsvMapper($titles);
    $row = new TitledCsvRow($mapper, $values);

    expect($row->get('電話番号'))->toBeNull();
});

test('範囲外のインデックスを指定するとnullが返る', function () {
    $titles = ['名前', '年齢', '住所'];
    $values = ['山田太郎', '30', '東京都'];
    $mapper = new TitledCsvMapper($titles);
    $row = new TitledCsvRow($mapper, $values);

    expect($row->get(3))->toBeNull();
    expect($row->get(-1))->toBeNull();
});

test('getAll()で複数のタイトルに対応する値を取得できる', function () {
    $titles = ['名前', '年齢', '住所', '電話番号'];
    $values = ['山田太郎', '30', '東京都', '03-1234-5678'];
    $mapper = new TitledCsvMapper($titles);
    $row = new TitledCsvRow($mapper, $values);

    expect($row->getAll(['名前', '住所']))->toBe(['山田太郎', '東京都']);
});

test('glob()でパターンに一致するタイトルの値を取得できる', function () {
    $titles = ['user_name', 'user_age', 'address', 'phone'];
    $values = ['山田太郎', '30', '東京都', '03-1234-5678'];
    $mapper = new TitledCsvMapper($titles);
    $row = new TitledCsvRow($mapper, $values);

    expect($row->glob('user_*'))->toBe([
        'user_name' => '山田太郎',
        'user_age' => '30'
    ]);
});

test('match()で正規表現パターンに一致するタイトルの値を取得できる', function () {
    $titles = ['user_name', 'user_age', 'address', 'phone'];
    $values = ['山田太郎', '30', '東京都', '03-1234-5678'];
    $mapper = new TitledCsvMapper($titles);
    $row = new TitledCsvRow($mapper, $values);

    expect($row->match('/^user_/'))->toBe([
        'user_name' => '山田太郎',
        'user_age' => '30'
    ]);
});

test('getTitles()でタイトルの配列を取得できる', function () {
    $titles = ['名前', '年齢', '住所'];
    $values = ['山田太郎', '30', '東京都'];
    $mapper = new TitledCsvMapper($titles);
    $row = new TitledCsvRow($mapper, $values);

    expect($row->getTitles())->toBe($titles);
});

test('getValues()で値の配列を取得できる', function () {
    $titles = ['名前', '年齢', '住所'];
    $values = ['山田太郎', '30', '東京都'];
    $mapper = new TitledCsvMapper($titles);
    $row = new TitledCsvRow($mapper, $values);

    expect($row->getValues())->toBe($values);
});

test('値の数がタイトルの数より少ない場合でも正常に動作する', function () {
    $titles = ['名前', '年齢', '住所', '電話番号'];
    $values = ['山田太郎', '30', '東京都']; // 電話番号の値がない
    $mapper = new TitledCsvMapper($titles);
    $row = new TitledCsvRow($mapper, $values);

    expect($row->get('名前'))->toBe('山田太郎');
    expect($row->get('電話番号'))->toBeNull();
});
