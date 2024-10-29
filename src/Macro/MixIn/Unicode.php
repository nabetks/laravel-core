<?php

namespace Aijoh\Core\Macro\MixIn;

use Aijoh\Core\Macro\MixIn\Trait\UnicodeSpacePattern;

class Unicode
{
    use UnicodeSpacePattern;

    /**
     * 文章の前後の空白を削除する。
     *
     * @param  string|array  $value  前後の空白を削除する文字列又は配列
     * @return string|array 前後の空白を削除した文字列又は配列
     */
    public function trimSpace(string|array $value): string|array
    {
        if (is_array($value)) {
            return array_map(fn ($v) => $this->trimSpace($v), $value);
        }
        $pattern = $this->replaceSpacePattern('/\A[[:all-space:]]|[[:all-space:]]\z/u');

        return preg_replace($pattern, '', $value);
    }
}
