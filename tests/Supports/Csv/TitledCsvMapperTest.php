<?php

use Aijoh\Core\Supports\Csv\TitledCsvMapper;

test('空のタイトル配列で初期化するとInvalidArgumentExceptionが発生する', function () {
    expect(fn() => new TitledCsvMapper([]))
        ->toThrow(InvalidArgumentException::class, 'タイトルは1つ以上必要です。');
});

test('正常なタイトル配列で初期化できる', function () {
    $titles = ['名前', '年齢', '住所'];
    $mapper = new TitledCsvMapper($titles);
    expect($mapper->getTitles())->toBe($titles);
});

test('findIndex()は存在するタイトルのインデックスを返す', function () {
    $mapper = new TitledCsvMapper(['名前', '年齢', '住所']);
    expect($mapper->findIndex('年齢'))->toBe(1);
});

test('findIndex()は存在しないタイトルに対して-1を返す', function () {
    $mapper = new TitledCsvMapper(['名前', '年齢', '住所']);
    expect($mapper->findIndex('電話番号'))->toBe(-1);
});

test('findIndex()は有効な数値インデックスをそのまま返す', function () {
    $mapper = new TitledCsvMapper(['名前', '年齢', '住所']);
    expect($mapper->findIndex(1))->toBe(1);
});

test('findIndex()は範囲外のインデックスに対して-1を返す', function () {
    $mapper = new TitledCsvMapper(['名前', '年齢', '住所']);
    expect($mapper->findIndex(3))->toBe(-1);
    expect($mapper->findIndex(-1))->toBe(-1);
});

test('findIndexAll()は複数のタイトルに対応するインデックスの配列を返す', function () {
    $mapper = new TitledCsvMapper(['名前', '年齢', '住所']);
    expect($mapper->findIndexAll(['名前', '住所']))->toBe([0, 2]);
});

test('findIndexAll()は無効な型の要素が含まれる場合にInvalidArgumentExceptionを投げる', function () {
    $mapper = new TitledCsvMapper(['名前', '年齢', '住所']);
    expect(fn() => $mapper->findIndexAll(['名前', null]))
        ->toThrow(InvalidArgumentException::class);
});

test('glob()はパターンにマッチするタイトルとインデックスの配列を返す', function (array $titles,$pattern,$results) {
    $mapper = new TitledCsvMapper($titles);
    expect($mapper->glob($pattern))->toBe($results);
})->with(
        [
            [
                ['user_name', 'user_age', 'address'],
                'user_*',
                ['user_name' => 0, 'user_age' => 1]
            ]
        ],
        [
            [
                ['user_name', 'user_age', 'address'],
                'add*',
                ['address' => 2]
            ]
        ],
        [
            [
                ['title1', 'title11', 'title111'],
                'title?',
                ['title1' => 0]
            ]
        ]
);

test('globAll()は複数のパターンに対するマッチング結果を返す', function () {
    $mapper = new TitledCsvMapper(['user_name', 'user_age', 'address']);
    expect($mapper->globAll(['user_*', '*ss']))->toBe([
        ['user_name' => 0, 'user_age' => 1],
        ['address' => 2]
    ]);
});

test('globAll()は文字列以外のパターンが含まれる場合にInvalidArgumentExceptionを投げる', function () {
    $mapper = new TitledCsvMapper(['名前', '年齢', '住所']);
    expect(fn() => $mapper->globAll(['user_*', null]))
        ->toThrow(InvalidArgumentException::class);
});

test('match()は正規表現パターンにマッチするタイトルとインデックスの配列を返す', function () {
    $mapper = new TitledCsvMapper(['user_name', 'user_age', 'address']);
    expect($mapper->match('/^user_/'))->toBe([
        'user_name' => 0,
        'user_age' => 1
    ]);
});

test('match()は無効な正規表現パターンの場合にInvalidArgumentExceptionを投げる', function () {
    $mapper = new TitledCsvMapper(['user_name', 'user_age', 'address']);
    expect(fn() => $mapper->match('/[/'))
        ->toThrow(InvalidArgumentException::class);
});
