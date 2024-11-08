<?php

namespace Aijoh\Core\ValueObjects\Japan;

use Aijoh\Core\Support\Japanese;

enum JapanPrefecture: string
{
    case HOKKAIDO = '北海道';
    case AOMORI = '青森県';
    case IWATE = '岩手県';
    case MIYAGI = '宮城県';
    case AKITA = '秋田県';
    case YAMAGATA = '山形県';
    case FUKUSHIMA = '福島県';
    case IBARAKI = '茨城県';
    case TOCHIGI = '栃木県';
    case GUNMA = '群馬県';
    case SAITAMA = '埼玉県';
    case CHIBA = '千葉県';
    case TOKYO = '東京都';
    case KANAGAWA = '神奈川県';
    case NIIGATA = '新潟県';
    case TOYAMA = '富山県';
    case ISHIKAWA = '石川県';
    case FUKUI = '福井県';
    case YAMANASHI = '山梨県';
    case NAGANO = '長野県';
    case GIFU = '岐阜県';
    case SHIZUOKA = '静岡県';
    case AICHI = '愛知県';
    case MIE = '三重県';
    case SHIGA = '滋賀県';
    case KYOTO = '京都府';
    case OSAKA = '大阪府';
    case HYOGO = '兵庫県';
    case NARA = '奈良県';
    case WAKAYAMA = '和歌山県';
    case TOTTORI = '鳥取県';
    case SHIMANE = '島根県';
    case OKAYAMA = '岡山県';
    case HIROSHIMA = '広島県';
    case YAMAGUCHI = '山口県';
    case TOKUSHIMA = '徳島県';
    case KAGAWA = '香川県';
    case EHIME = '愛媛県';
    case KOCHI = '高知県';
    case FUKUOKA = '福岡県';
    case SAGA = '佐賀県';
    case NAGASAKI = '長崎県';
    case KUMAMOTO = '熊本県';
    case OITA = '大分県';
    case MIYAZAKI = '宮崎県';
    case KAGOSHIMA = '鹿児島県';
    case OKINAWA = '沖縄県';

    /**
     * 都道府県名からインスタンスを生成
     *
     * @return int
     */
    public function code(): int|false
    {
        foreach (JapanPrefecture::cases() as $key => $prefecture) {
            if ($prefecture->value === $this->value) {
                return $key + 1;
            }
        }

        return false;
    }

    /**
     * ひらがな表記を取得
     */
    public function hiragana(): string
    {
        foreach (self::getKanaList() as $kana => $prefecture) {
            if ($prefecture === $this) {
                return $kana;
            }
        }

        return '';
    }

    /**
     * カタカナ表記を取得
     */
    public function katakana(): string
    {
        return Japanese::toKatakana($this->hiragana());
    }

    public function english(): string
    {
        return $this->name;
    }

    private static function getKanaList()
    {
        return [
            'ほっかいどう' => JapanPrefecture::HOKKAIDO,
            'あおもりけん' => JapanPrefecture::AOMORI,
            'いわてけん' => JapanPrefecture::IWATE,
            'みやぎけん' => JapanPrefecture::MIYAGI,
            'あきたけん' => JapanPrefecture::AKITA,
            'やまがたけん' => JapanPrefecture::YAMAGATA,
            'ふくしまけん' => JapanPrefecture::FUKUSHIMA,
            'いばらきけん' => JapanPrefecture::IBARAKI,
            'とちぎけん' => JapanPrefecture::TOCHIGI,
            'ぐんまけん' => JapanPrefecture::GUNMA,
            'さいたまけん' => JapanPrefecture::SAITAMA,
            'ちばけん' => JapanPrefecture::CHIBA,
            'とうきょうと' => JapanPrefecture::TOKYO,
            'かながわけん' => JapanPrefecture::KANAGAWA,
            'にいがたけん' => JapanPrefecture::NIIGATA,
            'とやまけん' => JapanPrefecture::TOYAMA,
            'いしかわけん' => JapanPrefecture::ISHIKAWA,
            'ふくいけん' => JapanPrefecture::FUKUI,
            'やまなしけん' => JapanPrefecture::YAMANASHI,
            'ながのけん' => JapanPrefecture::NAGANO,
            'ぎふけん' => JapanPrefecture::GIFU,
            'しずおかけん' => JapanPrefecture::SHIZUOKA,
            'あいちけん' => JapanPrefecture::AICHI,
            'みえけん' => JapanPrefecture::MIE,
            'しがけん' => JapanPrefecture::SHIGA,
            'きょうとふ' => JapanPrefecture::KYOTO,
            'おおさかふ' => JapanPrefecture::OSAKA,
            'ひょうごけん' => JapanPrefecture::HYOGO,
            'ならけん' => JapanPrefecture::NARA,
            'わかやまけん' => JapanPrefecture::WAKAYAMA,
            'とっとりけん' => JapanPrefecture::TOTTORI,
            'しまねけん' => JapanPrefecture::SHIMANE,
            'おかやまけん' => JapanPrefecture::OKAYAMA,
            'ひろしまけん' => JapanPrefecture::HIROSHIMA,
            'やまぐちけん' => JapanPrefecture::YAMAGUCHI,
            'とくしまけん' => JapanPrefecture::TOKUSHIMA,
            'かがわけん' => JapanPrefecture::KAGAWA,
            'えひめけん' => JapanPrefecture::EHIME,
            'こうちけん' => JapanPrefecture::KOCHI,
            'ふくおかけん' => JapanPrefecture::FUKUOKA,
            'さがけん' => JapanPrefecture::SAGA,
            'ながさきけん' => JapanPrefecture::NAGASAKI,
            'くまもとけん' => JapanPrefecture::KUMAMOTO,
            'おおいたけん' => JapanPrefecture::OITA,
            'みやざきけん' => JapanPrefecture::MIYAZAKI,
            'かごしまけん' => JapanPrefecture::KAGOSHIMA,
            'おきなわけん' => JapanPrefecture::OKINAWA,
        ];
    }

    /**
     * 都道府県名からインスタンスを生成
     */
    public static function make(string|int $name): ?JapanPrefecture
    {
        if (empty($name)) {
            return null;
        }

        if (is_numeric($name)) {
            return self::makeFromCode($name);
        }

        $methods = [
            'makeFromJapanese',
            'makeFromEnglish',
            'makeFromKana',
        ];

        foreach ($methods as $method) {
            $result = self::$method($name);
            if ($result !== null) {
                return $result;
            }
        }

        return null;
    }

    public static function makeFromCode(int $code): ?JapanPrefecture
    {
        if ($code < 1 || $code > 47) {
            return null;
        }

        return self::cases()[$code - 1];
    }

    /**
     * 日本語の都道府県名からインスタンスを生成
     */
    public static function makeFromJapanese(string $name): ?JapanPrefecture
    {
        if (empty($name)) {
            return null;
        }

        $result = self::tryFrom($name);
        if ($result !== null) {
            return $result;
        }

        return match ($name) {
            '北海' => self::HOKKAIDO,
            '東京' => self::TOKYO,
            '京都' => self::KYOTO,
            '大阪' => self::OSAKA,
            default => self::tryFrom($name.'県')
        };
    }

    public static function makeFromEnglish(string $name): ?JapanPrefecture
    {
        if (str_contains($name, '-')) {
            $name = explode('-', $name)[0];
        }
        $english = strtoupper($name);
        foreach (self::cases() as $prefecture) {
            if (strtoupper($prefecture->name) === $english) {
                return $prefecture;
            }
        }

        return match ($english) {
            'GUMMA' => self::GUNMA,
            default => null
        };
    }

    public static function makeFromKana(string $name): ?JapanPrefecture
    {
        $hiragana = Japanese::toHiragana($name);
        $hiraganaList = self::getKanaList();
        $prefecture = $hiraganaList[$hiragana] ?? null;
        if ($prefecture !== null) {
            return $prefecture;
        }

        switch ($hiragana) {
            case 'とうきょう':
                return self::TOKYO;
            case 'きょうと':
                return self::KYOTO;
            case 'おおさか':
                return self::OSAKA;
            case 'ほっかい':
                return self::HOKKAIDO;
            default:
                return $hiraganaList[$hiragana.'けん'] ?? null;
        }
    }
}
