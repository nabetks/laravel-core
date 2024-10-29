<?php

namespace Aijoh\Core\Macro\MixIn\Trait;

trait UnicodeSpacePattern
{
    private static string $spaceRegExp = '[\p{Cc}\p{Cf}\p{Z}\x{17b4}\x{17b5}\x{2800}\x{3164}\x{ffa0}\x{1d159}\x{034f}\x{115f}\x{1160}]';

    private function replaceSpacePattern(string $pattern): string
    {
        return str_replace('[[:all-space:]]', self::$spaceRegExp, $pattern);
    }
}
