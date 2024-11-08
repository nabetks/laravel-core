<?php

namespace Aijoh\Core\Support\Trait;

trait UnicodeExtendPattern {
    // 空白の正規表現
    private static string $allSpacePattern = '[[:all-space:]]';

    // 空白の正規表現
    private static string $spaceRegExp = '[\p{Cc}\p{Cf}\p{Z}\x{17b4}\x{17b5}\x{2800}\x{3164}\x{ffa0}\x{1d159}\x{034f}\x{115f}\x{1160}]';

    // 横棒の正規表現
    private static string $horizontalBarPattern = '[[:all-bar:]]';

    /**
     * 横棒の文字列一覧
     * @var array|string[]
     */
    public static array $horizontalBarList = [
        "\u{2D}",
        "\u{FF0D}",
        "\u{FE63}",
        "\u{2212}",
        "\u{2010}",
        "\u{2043}",
        "\u{2011}",
        "\u{2012}",
        "\u{2013}",
        "\u{2014}",
        "\u{fe58}",
        "\u{2015}",
        "\u{23AF}",
        "\u{23E4}",
        "\u{2D7}",
        "\u{2796}",
        "\u{208B}",
        "\u{30FC}",
        "\u{FF70}",
        "\u{2500}",
        "\u{2501}",
        "\u{2574}",
        "\u{2576}",
        "\u{2578}",
        "\u{257A}",
        "\u{25AC}",
        "\u{4E00}",
        "\u{2F00}",
        "\u{3192}",
        "\u{207B}",
    ];

    /**
     * 横棒の正規表現の追加
     */
    private static function replaceExtendPattern( string $pattern ) : string {
        $base = [
            self::$allSpacePattern,
            self::$horizontalBarPattern,
        ];
        $replace = [
            self::$spaceRegExp,
            '['.implode('', self::$horizontalBarList).']',
        ];
        return str_replace($base, $replace, $pattern);
    }

    /**
     * 置換を行う
     *
     * @param string|array $pattern
     * @param string|array $replace
     * @param array|string $subject
     * @param int $limit
     * @param $count
     * @return string
     */
    public static function replace( string|array $pattern, string|array $replace, array|string $subject, int $limit = -1, &$count = null ) : string {
        return preg_replace(self::replaceExtendPattern($pattern), $replace, $subject, $limit, $count);
    }

    /**
     * 拡張した正規表現のマッチングを行う
     * @param string $pattern
     * @param string $subject
     * @param array|null $matches
     * @param int $flags
     * @param int $offset
     * @return int|false
     */

    public static function match( string $pattern, string $subject, ?array &$matches = null, int $flags = 0, int $offset = 0 ) : int|false {
        return preg_match(self::replaceExtendPattern($pattern), $subject, $matches, $flags, $offset);
    }

    /**
     * 拡張した正規表現のマッチングを行う
     * @param string $pattern
     * @param string $subject
     * @param int $limit
     * @param int $flags
     * @return array
     */
    public static function split( string $pattern, string $subject, int $limit = -1, int $flags = 0 ) : array {
        $pattern = self::replaceExtendPattern($pattern);
        return preg_split($pattern, $subject, $limit, $flags);
    }

}
