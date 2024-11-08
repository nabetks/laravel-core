<?php

namespace Aijoh\Core\ValueObjects\Japan;

use Aijoh\Core\ValueObjects\BaseObject;
use Illuminate\Support\Str;

/**
 * 氏名の読み仮名(ひらがな、カタカナ)を管理するクラスです
 */
class Furigana extends BaseObject
{
    public function beforeValidate($value)
    {
        return Str::normalize($value);
    }
}
