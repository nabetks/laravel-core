<?php

namespace Aijoh\Core\Macro\MixIn;

use Aijoh\Core\Macro\MixIn\Trait\UnicodeSpacePattern;

class Unicode
{
    use UnicodeSpacePattern;

    /**
     * 文章の前後の空白を削除する。
     *
     * @param  string  $value  前後の空白を削除する文字列又は配列
     * @return string 前後の空白を削除した文字列又は配列
     */
    public function trimSpace(): \Closure
    {
        return function (string $value): string {
            $pattern = $this->replaceSpacePattern('/\A[[:all-space:]]|[[:all-space:]]\z/u');

            return preg_replace($pattern, '', $value);
        };
    }
}
