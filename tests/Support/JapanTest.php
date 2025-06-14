<?php

namespace Aijoh\Core\Tests\Support;

use Aijoh\Core\Exception\EncodingException;
use Aijoh\Core\Support\Japanese;

test('normalize テスト', function ($base, $expected) {
    $this->assertEquals($expected, Japanese::normalize($base));
})->with(
    [
        '半角カタカナ=>全角カタカナ' => [
            'ｧｱｨｲｩｳｪｴｫｵｶｶﾞｷｷﾞｸｸﾞｹｹﾞｺｺﾞｻｻﾞｼｼﾞｽｽﾞｾｾﾞｿｿﾞﾀﾀﾞﾁﾁﾞｯﾂﾂﾞﾃﾃﾞﾄﾄﾞﾅﾆﾇﾈﾉﾊﾊﾞﾊﾟﾋﾋﾞﾋﾟﾌﾌﾞﾌﾟﾍﾍﾞﾍﾟﾎﾎﾞﾎﾟﾏﾐﾑﾒﾓｬﾔｭﾕｮﾖﾗﾘﾙﾚﾛﾜﾝﾞﾟ',
            'ァアィイゥウェエォオカガキギクグケゲコゴサザシジスズセゼソゾタダチヂッツヅテデトドナニヌネノハバパヒビピフブプヘベペホボポマミムメモャヤュユョヨラリルレロワン゛゜',
        ],
        '全角英数字(大文字・小文字)=>半角英数字(大文字・小文字)' => [
            'ＡＢＣＤＥＦＧＨＩＪＫＬＭＮＯＰＱＲＳＴＵＶＷＸＹＺａｂｃｄｅｆｇｈｉｊｋｌｍｎｏｐｑｒｓｔｕｖｗｘｙｚ０１２３４５６７８９',
            'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',
        ],
        '全角記号=>半角記号' => [
            '！”＃＄％＆’（）＊＋，－．／：；＜＝＞？＠［￥］＾＿‘｛｜｝',
            '!"#$%&\'()*+,-./:;<=>?@[\\]^_`{|}',
        ],
        '合成文字の変換' => [
            "か\u{3099}は\u{309A}ハ\u{3099}ワ\u{3099}",
            'がぱバヷ',
        ],
        '空白文字=>半角空白' => [
            "　あいうえお\u{1D17A}かきくけこ　さしすせそ",
            ' あいうえお かきくけこ さしすせそ',
        ],
    ]
);

test('ひらがなに変換', function ($base, $expected) {
    $this->assertEquals($expected, Japanese::toHiragana($base));
})->with(
    [
        '合成文字の変換' => [
            "か\u{3099}は\u{309A}ハ\u{3099}",
            'がぱば',
        ],
        '合成文字カタカナの変換' => [
            "ハ\u{3099}ヒ\u{3099}フ\u{3099}ヘ\u{3099}ホ\u{3099}ハ\u{309A}ヒ\u{309A}フ\u{309A}ヘ\u{309A}ホ\u{309A}",
            'ばびぶべぼぱぴぷぺぽ',
        ],
        '全角カタカナ=>ひらがな' => [
            'ァアィイゥウェエォオカガキギクグケゲコゴサザシジスズセゼソゾタダチヂッツヅテデトドナニヌネノハバパヒビピフブプヘベペホボポマミムメモャヤュユョヨラリルレロワン゛゜',
            'ぁあぃいぅうぇえぉおかがきぎくぐけげこごさざしじすずせぜそぞただちぢっつづてでとどなにぬねのはばぱひびぴふぶぷへべぺほぼぽまみむめもゃやゅゆょよらりるれろわん゛゜',
        ],
        '半角カタカナ=>ひらがな' => [
            'ｧｱｨｲｩｳｪｴｫｵｶｶﾞｷｷﾞｸｸﾞｹｹﾞｺｺﾞｻｻﾞｼｼﾞｽｽﾞｾｾﾞｿｿﾞﾀﾀﾞﾁﾁﾞｯﾂﾂﾞﾃﾃﾞﾄﾄﾞﾅﾆﾇﾈﾉﾊﾊﾞﾊﾟﾋﾋﾞﾋﾟﾌﾌﾞﾌﾟﾍﾍﾞﾍﾟﾎﾎﾞﾎﾟﾏﾐﾑﾒﾓｬﾔｭﾕｮﾖﾗﾘﾙﾚﾛﾜﾝﾞﾟ',
            'ぁあぃいぅうぇえぉおかがきぎくぐけげこごさざしじすずせぜそぞただちぢっつづてでとどなにぬねのはばぱひびぴふぶぷへべぺほぼぽまみむめもゃやゅゆょよらりるれろわん゛゜',
        ],
    ]
);

test('カタカナに変換', function ($base, $expected) {
    $this->assertEquals($expected, Japanese::toKatakana($base));
})->with(
    [
        '合成文字の変換' => [
            "か\u{3099}は\u{309A}ハ\u{3099}",
            'ガパバ',
        ],
        '合成文字カタカナの変換' => [
            "ハ\u{3099}ヒ\u{3099}フ\u{3099}ヘ\u{3099}ホ\u{3099}ハ\u{309A}ヒ\u{309A}フ\u{309A}ヘ\u{309A}ホ\u{309A}",
            'バビブベボパピプペポ',
        ],
        '全角ひらがな=>カタカナ' => [
            'ぁあぃいぅうぇえぉおかがきぎくぐけげこごさざしじすずせぜそぞただちぢっつづてでとどなにぬねのはばぱひびぴふぶぷへべぺほぼぽまみむめもゃやゅゆょよらりるれろわん゛゜',
            'ァアィイゥウェエォオカガキギクグケゲコゴサザシジスズセゼソゾタダチヂッツヅテデトドナニヌネノハバパヒビピフブプヘベペホボポマミムメモャヤュユョヨラリルレロワン゛゜',

        ],
        '半角カタカナ=>全角カタカナ' => [
            'ｧｱｨｲｩｳｪｴｫｵｶｶﾞｷｷﾞｸｸﾞｹｹﾞｺｺﾞｻｻﾞｼｼﾞｽｽﾞｾｾﾞｿｿﾞﾀﾀﾞﾁﾁﾞｯﾂﾂﾞﾃﾃﾞﾄﾄﾞﾅﾆﾇﾈﾉﾊﾊﾞﾊﾟﾋﾋﾞﾋﾟﾌﾌﾞﾌﾟﾍﾍﾞﾍﾟﾎﾎﾞﾎﾟﾏﾐﾑﾒﾓｬﾔｭﾕｮﾖﾗﾘﾙﾚﾛﾜﾝﾞﾟ',
            'ァアィイゥウェエォオカガキギクグケゲコゴサザシジスズセゼソゾタダチヂッツヅテデトドナニヌネノハバパヒビピフブプヘベペホボポマミムメモャヤュユョヨラリルレロワン゛゜',
        ],
    ]
);

/**
 * ひらがなのみ判定
 */
test('ひらがなのみ判定', function ($str, $expected) {
    $this->assertEquals($expected, Japanese::isHiragana($str));
})->with(
    [
        'ひらがなのみ' => ['あいうえお', true],
        'カタカナのみ' => ['アイウエオ', false],
        '英数字のみ' => ['1234567890', false],
        '記号のみ' => ['!"#$%&\'()*+,-./:;<=>?@[\\]^_`{|}', false],
        'ひらがなとカタカナ' => ['あいうえおアイウエオ', false],
    ]
);

/**
 * ひらがなのみ判定
 */
test('カタカナのみ判定', function ($str, $expected) {
    $this->assertEquals($expected, Japanese::isKatakana($str));
})->with(
    [
        'ひらがなのみ' => ['あいうえお', false],
        'カタカナのみ' => ['アイウエオカート', true],
        '英数字のみ' => ['1234567890', false],
        '記号のみ' => ['!"#$%&\'()*+,-./:;<=>?@[\\]^_`{|}', false],
        'ひらがなとカタカナ' => ['あいうえおアイウエオ', false],
    ]
);

test('日本語のみの判定', function ($str, $expected) {
    $this->assertEquals($expected, Japanese::isJapanese($str));
})->with(
    [
        'ひらがなのみ' => ['あいうえお', true],
        'カタカナのみ' => ['アイウエオカート', true],
        '英数字のみ' => ['1234567890', false],
        '記号のみ' => ['!"#$%&\'()*+,-./:;<=>?@[\\]^_`{|}', false],
        'ひらがなとカタカナ' => ['あいうえおアイウエオ', true],
        '漢字・ひらがな・カタカナ' => ['あいうえおアイウエオ漢字テスト', true],
        '空白記号入り' => ['あいうえおアイウエオ漢字 テスト', false],
    ]
);

test('文字コード変換可能かのチェック', function ($str, $expcted) {
    $this->assertEquals($expcted, Japanese::isEncodableToMs932($str));
})->with(
    [
        'ひらがな・カタカナ' => ['あいうえおワヲン', true],
        '波ダッシュ' => ['〜', false],
        '全角スペース' => ['　', true],
        '対応外の文字' => ['𠀋', false],
        '対応外の文字1' => ['𠮷野家', false],
    ]
);

test('エンコード変換後のバイト数チェック', function ($encode, $str, $expected, $exception) {
    try {
        $bytes = Japanese::getEncodeByte($str, $encode);
        $this->assertEquals($expected, $bytes);
    } catch (EncodingException $e) {
        $this->assertEquals($exception, true);
    }

})->with(
    [
        'EUC-JPでのバイト数チェック' => ['EUC-JP', 'あ', 2, false],
        'MS932でのバイト数チェック' => ['MS932', 'あ', 2, false],
        'EUC-JPでひらがなカタカナ交じりのバイト数チェック' => ['EUC-JP', 'あいうえおアイウエオ', 20, false],
        'MS932でひらがなカタカナ交じりのバイト数チェック' => ['MS932', 'あいうえおアイウエオ', 20, false],
        'UTF-8でのバイト数チェック' => ['UTF-8', 'あ', 3, false],
        'MS932半角、全角交じりのバイト数' => ['MS932', 'あいうえおｱｲｳｴｵ1234567890', 25, false],
        'EUC-JP半角、全角交じりのバイト数' => ['EUC-JP', 'あいうえおZDFGR1234567890', 25, false],
        'MS932変換エラー' => ['MS932', '𠀋', 0, true],
        'EUC-JP変換エラー' => ['EUC-JP', '𠀋', 0, true],
    ]
);
