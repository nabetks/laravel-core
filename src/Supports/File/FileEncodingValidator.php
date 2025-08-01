<?php

namespace Aijoh\Core\Supports\File;

use Aijoh\Core\Exceptions\EncodingException;
use Aijoh\Core\Exceptions\FileNotFoundException;
use Aijoh\Core\Exceptions\IOException;
use Aijoh\Core\Supports\Encoding\EncodingValidator;

/**
 * ファイルに記載されている文字のエンコーディングのチェックを行うクラス
 */
class FileEncodingValidator {


    public static function check() {
        $list = mb_list_encodings();

    }

    /**
     * ファイルのエンコーディングを検証する
     *
     * @param string $filePath 検証対象のファイルパス
     * @param string $encoding 期待されるエンコーディング
     * @return bool エンコーディングが一致する場合はtrue
     * @throws FileNotFoundException エンコーディングが一致しない場合
     * @throws IOException ファイルの読み込みが出来ない場合の例外
     */
    public static function validate( string $filePath, string $encoding ) : bool {
        if ( ! file_exists($filePath)  ) {
            throw new FileNotFoundException($filePath);
        }

        if ( ! is_readable($filePath) ) {
            throw new IOException($filePath.' is not readable');
        }

        $canonical = EncodingValidator::getCanonicalName($encoding);
        if($canonical === null ){
            return false;
        }

        $content = file_get_contents($filePath);
        return mb_check_encoding($content, $canonical);
    }
}
