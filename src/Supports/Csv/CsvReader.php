<?php

namespace Aijoh\Core\Supports\Csv;

use Aijoh\Core\Exceptions\FileNotFoundException;
use Aijoh\Core\Exceptions\InvalidFileEncodingException;
use Aijoh\Core\Exceptions\IOException;
use Aijoh\Core\Supports\File\FileEncodingValidator;
use SplFileObject;

/**
 * CSVファイルを取り扱うためのクラス。このクラスはファイルのエンコーディング検証、SplFileObjectを使った
 * CSVファイルの読込処理、文字コード変換処理などを提供する。
 */
class CsvReader
{
    public const string DEFAULT_ENCODING = 'UTF-8';

    private ?\SplFileObject $splFileObject;

    private static array $emptyLine = [null];

    /**
     * @param  string  $filePath  ファイルのパス
     * @param  string  $encoding  文字コード
     * @param  string  $delimiter  分割文字
     * @param  string  $enclosure  エンクロージャー
     *
     * @throws FileNotFoundException ファイルが見つからない場合や読み込みが出来ない場合の例外
     * @throws InvalidFileEncodingException ファイル内の文字の文字コードが違っている場合の例外
     * @throws IOException ファイルの読み込みが出来ない場合の例外
     */
    public function __construct(
        private readonly string $filePath,
        private readonly string $encoding = self::DEFAULT_ENCODING,
        private readonly string $delimiter = ',',
        private readonly string $enclosure = '"',
    ) {
        $this->validateParameter();
        $this->splFileObject = $this->buildSplFileObject();
    }

    /**
     * パラメータのバリデーションを行う。
     *
     * @throws FileNotFoundException 指定したファイルが存在しない場合の例外
     * @throws IOException ファイルの読み込みが出来ない場合の例外
     * @throws InvalidFileEncodingException ファイルの文字コードが指定した文字コード以外の場合に出される例外
     */
    private function validateParameter(): void
    {
        if (! file_exists($this->filePath)) {
            throw new FileNotFoundException($this->filePath);
        }

        if (! FileEncodingValidator::validate($this->filePath, $this->encoding)) {
            throw new InvalidFileEncodingException($this->filePath, $this->encoding);
        }
    }

    /**
     * 与えられたファイルパスからSplFileObjectを生成し、必要に応じて文字エンコーディングをUTF-8に変換する
     *
     * @return \SplFileObject ファイルを操作するためのSplFileObjectインスタンス
     */
    private function buildSplFileObject(): \SplFileObject
    {
        if (strtoupper($this->encoding) === 'UTF-8') {
            return $this->setSplFileObjectOption(new \SplFileObject($this->filePath, 'r'));
        }
        $object = $this->getEncodingSplFileObject();

        return $this->setSplFileObjectOption($object);
    }

    /**
     * 指定されたパスのCSVファイルを読み込むSplFileObjectを作成する
     *
     * @return \SplFileObject 作成されたSplFileObjectインスタンス
     */
    private function setSplFileObjectOption(\SplFileObject $object): \SplFileObject
    {
        $object->setFlags(\SplFileObject::READ_CSV);
        $object->setCsvControl($this->delimiter, $this->enclosure);

        return $object;
    }

    /**
     * UTF-8以外の文字コードで記載されているファイルをUTF-8に変換して
     * 一時ファイルに書き込み書き込んだuriを返す。
     */
    private function getEncodingSplFileObject(): \SplFileObject
    {
        $resource = fopen($this->filePath, 'rb');
        stream_filter_append($resource, "convert.iconv.{$this->encoding}/UTF-8");

        $object = new \SplTempFileObject;
        $object->fwrite(stream_get_contents($resource));
        $object->rewind();

        return $object;
    }

    /**
     * ファイルの現在の行を取得する。
     */
    public function current(): string|array|null
    {
        return $this->splFileObject->current();
    }

    /**
     * SplFileObjectのデータを返す。
     *
     * @return \SplFileObject The SplFileObject instance.
     */
    public function getSplObject(): \SplFileObject
    {
        return $this->splFileObject;
    }

    /**
     * CSVのデータを1行読み込む
     */
    public function getCsv(): array|false
    {
        $results = $this->splFileObject->fgetcsv();
        if ($results === self::$emptyLine) {
            return false;
        }

        return $results;
    }

    /**
     * 次の行を読み出す
     */
    public function next(): void
    {
        $this->splFileObject->next();
    }

    /**
     * CSV の区切り、囲み文字、エスケープ文字を取得する
     */
    public function getCsvControl(): array
    {
        return $this->splFileObject->getCsvControl();
    }

    /**
     * 行番号を取得する。
     *
     * @return int 行番号
     */
    public function getKey(): int
    {
        return $this->splFileObject->key();
    }

    /**
     * 指定された行番号にシークする。
     *
     * @param  int  $index  シークする行番号
     */
    public function seekLine(int $index): void
    {
        $this->splFileObject->seek($index);
    }

    /**
     * ファイルポインタを先頭に巻き戻す
     */
    public function rewind(): void
    {
        $this->splFileObject->rewind();
    }

    /**
     * デストラクタ。オブジェクトの後処理を行う。
     *
     * @return void
     */
    public function __destruct()
    {
        if ($this->splFileObject != null) {
            $this->splFileObject = null;
        }
    }
}
