<?php

namespace Aijoh\Core\Exceptions;

/**
 * ファイルのエンコーディングが指定されたエンコーディングと一致しない場合にスローされる例外
 */
class InvalidFileEncodingException extends FileException
{
    /**
     * @var string ファイルパス
     */
    private string $filePath;

    /**
     * @var string 期待されるエンコーディング
     */
    private string $expectedEncoding;

    /**
     * コンストラクタ
     *
     * @param  string  $filePath  ファイルパス
     * @param  string  $encoding  期待されるエンコーディング
     */
    public function __construct(string $filePath, string $encoding)
    {
        $this->filePath = $filePath;
        $this->expectedEncoding = $encoding;

        $message = "ファイル '{$filePath}' のエンコーディングが '{$encoding}' ではありません。";
        parent::__construct($message);
    }

    /**
     * ファイルパスを取得
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }

    /**
     * 期待されるエンコーディングを取得
     */
    public function getExpectedEncoding(): string
    {
        return $this->expectedEncoding;
    }
}
