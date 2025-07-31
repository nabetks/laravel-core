<?php

namespace Aijoh\Core\Supports\Csv;

use Aijoh\Core\Exceptions\FileNotFoundException;
use Aijoh\Core\Exceptions\InvalidFileEncodingException;
use Aijoh\Core\Exceptions\IOException;
use Aijoh\Core\Supports\File\FileEncodingValidator;

class CsvReader {

    public const string DEFAULT_ENCODING = 'UTF-8';

    private ?\SplFileObject $splFileObject;

    /**
     *
     * @param string $filePath ファイルのパス
     * @param string $encoding 文字コード
     * @param string $delimiter 分割文字
     * @param string $enclosure エンクロージャー
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
     * @return void
     * @throws FileNotFoundException 指定したファイルが存在しない場合の例外
     * @throws InvalidFileEncodingException ファイルの文字コードが指定した文字コード以外の場合に出される例外
     * @throws IOException ファイルの読み込みが出来ない場合の例外
     */
    private function validateParameter() {
        if ( ! file_exists($this->filePath) ) {
            throw new FileNotFoundException($this->filePath);
        }

        if( ! is_readable($this->filePath) ) {
            throw new IOException("{$this->filePath} is not readable");
        }

        if ( ! FileEncodingValidator::validate($this->filePath, $this->encoding) ) {
            throw new InvalidFileEncodingException($this->filePath, $this->encoding);
        }
    }


    /**
     * 与えられたファイルパスからSplFileObjectを生成し、必要に応じて文字エンコーディングをUTF-8に変換する
     * @return \SplFileObject ファイルを操作するためのSplFileObjectインスタンス
     */
    private function buildSplFileObject() : \SplFileObject {
        if ( strtoupper($this->encoding) === 'UTF-8' ) {
            return $this->createSplFileObject($this->filePath);
        }
        $resource = $this->convertFileEncoding();
        return $this->createSplFileObject($resource);
    }


    /**
     * 指定されたパスのCSVファイルを読み込むSplFileObjectを作成する
     * @param string $path ファイルのパス
     * @return \SplFileObject 作成されたSplFileObjectインスタンス
     */
    private function createSplFileObject( string $path ) : \SplFileObject {
        $file = new \SplFileObject($path, 'r');
        $file->setFlags(\SplFileObject::READ_CSV);
        $file->setCsvControl($this->delimiter, $this->enclosure);
        return $file;
    }


    /**
     * UTF-8以外の文字コードで記載されているファイルをUTF-8に変換して
     * 一時ファイルに書き込み書き込んだuriを返す。
     * @return string
     */
    private function convertFileEncoding() : string {
        $resource = fopen($this->filePath, 'rb');
        $tmpFile = tmpfile();

        stream_filter_append($resource, "convert.iconv.{$this->encoding}/UTF-8");

        while ( ( $line = fgets($resource) ) !== false ) {
            fwrite($tmpFile, $line);
        }

        return stream_get_meta_data($tmpFile)['uri'];
    }


    /**
     * ファイルの現在の行を取得する。
     * @return string|array|null
     */
    public function current() : string|array|null {
        return $this->splFileObject->current();
    }


    /**
     * SplFileObjectのデータを返す。
     *
     * @return \SplFileObject The SplFileObject instance.
     */
    public function getSplObject() : \SplFileObject {
        return $this->splFileObject;
    }


    /**
     * CSVのデータを1行読み込む
     * @return array|false
     */
    public function getCsv() : array | false {
        return $this->splFileObject->fgetcsv();
    }

    /**
     * 次の行を読み出す
     * @return void
     */
    public function next() : void {
        $this->splFileObject->next();
    }


    /**
     * CSV の区切り、囲み文字、エスケープ文字を取得する
     * @return array
     */
    public function getCsvControl() : array {
        return $this->splFileObject->getCsvControl();
    }



    /**
     * 行番号を取得する。
     * @return int 行番号
     */
    public function getKey() : int {
        return $this->splFileObject->key();
    }


    /**
     * 指定された行番号にシークする。
     * @param int $index シークする行番号
     * @return void
     */
    public function seekLine(int $index) : void {
        $this->splFileObject->seek($index);
    }


    /**
     * ファイルポインタを先頭に巻き戻す
     * @return void
     */
    public function rewind() : void {
        $this->splFileObject->rewind();
    }


    /**
     * デストラクタ。オブジェクトの後処理を行う。
     * @return void
     */
    public function __destruct() {
        if( $this->splFileObject != null ) {
            $this->splFileObject = null;
        }
    }

}
