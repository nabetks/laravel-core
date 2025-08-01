<?php

namespace Aijoh\Core\Exceptions;

/**
 * ファイルが見つからない場合に発生する例外
 */
class FileNotFoundException extends FileException
{
    /**
     * コンストラクタ
     *
     * @param  string  $filePath  見つからないファイルのパス
     * @param  int  $code  例外コード
     * @param  \Throwable|null  $previous  前の例外
     */
    public function __construct(string $filePath, int $code = 0, ?\Throwable $previous = null)
    {
        $message = "ファイルが見つかりません: {$filePath}";
        parent::__construct($message, $code, $previous);
    }
}
