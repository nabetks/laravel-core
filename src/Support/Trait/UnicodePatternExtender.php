<?php

namespace Aijoh\Core\Support\Trait;

trait UnicodePatternExtender
{
    private static string $spaceRegExp = '[\p{Cc}\p{Cf}\p{Z}\x{17b4}\x{17b5}\x{2800}\x{3164}\x{ffa0}\x{1d159}\x{034f}\x{115f}\x{1160}]';

    private static function replaceSpacePattern(string $pattern): string
    {
        return str_replace('[[:all-space:]]', self::$spaceRegExp, $pattern);
    }

    public static function replace(string|array $pattern, string|array $replace, array|string $subject, int $limit = -1, &$count = null): string
    {
        return preg_replace(self::replaceSpacePattern($pattern), $replace, $subject, $limit, $count);
    }

    public static function match(string $pattern, string $subject, ?array &$matches = null, int $flags = 0, int $offset = 0): int|false
    {
        return preg_match(self::replaceSpacePattern($pattern), $subject, $matches, $flags, $offset);
    }



}
