<?php

namespace Aijoh\Core\Tests\Support;

use Aijoh\Core\Support\Unicode;

$spaceChars = [
    "\u{0009}",
    "\u{0020}",
    "\u{00A0}",
    "\u{00AD}",
    "\u{034F}",
    "\u{061C}",
    "\u{115F}",
    "\u{1160}",
    "\u{17B4}",
    "\u{17B5}",
    "\u{180E}",
    "\u{2000}",
    "\u{2001}",
    "\u{2002}",
    "\u{2003}",
    "\u{2004}",
    "\u{2005}",
    "\u{2006}",
    "\u{2007}",
    "\u{2008}",
    "\u{2009}",
    "\u{200A}",
    "\u{200B}",
    "\u{200C}",
    "\u{200D}",
    "\u{200E}",
    "\u{200F}",
    "\u{202F}",
    "\u{205F}",
    "\u{2060}",
    "\u{2061}",
    "\u{2062}",
    "\u{2063}",
    "\u{2064}",
    "\u{206A}",
    "\u{206B}",
    "\u{206C}",
    "\u{206D}",
    "\u{206E}",
    "\u{206F}",
    "\u{3000}",
    "\u{2800}",
    "\u{3164}",
    "\u{FEFF}",
    "\u{FFA0}",
    "\u{1D159}",
    "\u{1D173}",
    "\u{1D174}",
    "\u{1D175}",
    "\u{1D176}",
    "\u{1D177}",
    "\u{1D178}",
    "\u{1D179}",
    "\u{1D17A}",
];

$spaceAllChars = implode('', $spaceChars);

test('trimSpaceのテスト', function ($str, $expected) {
    $val = Unicode::trimSpace($str);
    $this->assertSame($expected, $val);
})->with([
    '両方の全角空白削除' => ['　あいうえお　', 'あいうえお'],
    '前方の全角空白削除' => ['　あいうえお', 'あいうえお'],
    '後方の全角空白削除' => ['あいうえお　', 'あいうえお'],
    '削除せず' => ['あいうえお', 'あいうえお'],
    '半角・全角交じりの空白文字の削除' => [' 　 あいうえお 　', 'あいうえお'],
    '全ての空白文字の削除' => [$spaceAllChars, ''],
    '全ての空白文字の削除1' => [$spaceAllChars.'あいうえお'.$spaceAllChars, 'あいうえお'],
]);

test('ltrimSpaceのテスト', function ($str, $expected) {
    $val = Unicode::ltrimSpace($str);
    $this->assertSame($expected, $val);
})->with([
    '前方の全角空白のみ削除' => ['　あいうえお　', 'あいうえお　'],
    '前方の全角空白削除' => ['　あいうえお', 'あいうえお'],
    '後方の全角空白削除せず' => ['あいうえお　', 'あいうえお　'],
    '削除せず' => ['あいうえお', 'あいうえお'],
    '半角・全角交じりの空白文字の削除' => [' 　 あいうえお 　', 'あいうえお 　'],
    '全ての空白文字の削除' => [$spaceAllChars, ''],
    '前方の全角空白の削除' => [$spaceAllChars.'あいうえお'.$spaceAllChars, 'あいうえお'.$spaceAllChars],
]);

test('rtrimSpaceのテスト', function ($str, $expected) {
    $val = Unicode::rtrimSpace($str);
    $this->assertSame($expected, $val);
})->with(
    [
        '前方の全角空白削除せず' => ['　あいうえお　', '　あいうえお'],
        '前方の全角空白削除' => ['　あいうえお', '　あいうえお'],
        '後方の全角空白のみ削除' => ['あいうえお　', 'あいうえお'],
        '削除せず' => ['あいうえお', 'あいうえお'],
        '半角・全角交じりの空白文字の削除' => [' 　 あいうえお 　', ' 　 あいうえお'],
        '全ての空白文字の削除' => [$spaceAllChars, ''],
        '後方の全角空白の削除' => [$spaceAllChars.'あいうえお'.$spaceAllChars, $spaceAllChars.'あいうえお'],
    ]
);

test('空白を削除', function ($str, $expected) {
    $val = Unicode::removeSpace($str);
    $this->assertSame($expected, $val);
})->with(
    [
        '全ての場所の空白文字を削除1' => ['　あい う'.$spaceAllChars.'えお　', 'あいうえお'],
    ]
);

test('空白で分割', function ($str, $expected) {
    $val = Unicode::splitBlank($str);
    $this->assertSame($expected, $val);
})->with(
    [
        '半角空白で分割' => ['あ い う え お', ['あ', 'い', 'う', 'え', 'お']],
        '全角空白で分割' => ['あ　い　う　え　お', ['あ', 'い', 'う', 'え', 'お']],
        '様々な空白文字で分割' => ['あ　い'.$spaceAllChars.'う 　え　お', ['あ', 'い', 'う', 'え', 'お']],
    ]
);

test('横棒の置換', function ($str, $replace, $expected) {
    $replace = Unicode::replaceHorizontalBar($str, $replace);
    $this->assertSame($expected, $replace);
})->with(
    [
        '横棒の削除' => ['', '‐―ー－—⁻₋ｰ-',  ''],
        '横棒をハイフンに置換' => ['-', '‐―ー－—⁻₋ｰ-',  '---------'],
    ]
);

test('横棒で分割', function ($str, $expected) {
    $val = Unicode::splitHorizontalBar($str);
    $this->assertSame($expected, $val);
})->with(
    [
        'ハイフンで分割' => ['あ-い-う-え-お', ['あ', 'い', 'う', 'え', 'お']],
        '様々な横棒で分割' => ['あ-いーう-え-お', ['あ', 'い', 'う', 'え', 'お']],
    ]
);
