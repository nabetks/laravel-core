<?php

/**
 * Constructor for the TitleCsvReader class.
 *
 * Initializes an internal CsvReader instance to handle the file reading functionality.
 *
 * @param  string  $filePath  The full path to the CSV file to be processed.
 * @param  string  $encoding  The character encoding used in the CSV file. Defaults to `CsvReader::DEFAULT_ENCODING`.
 * @param  string  $delimiter  The character separating fields in the CSV file. Defaults to ','.
 * @param  string  $enclosure  The character used to wrap fields in the CSV file. Defaults to '"'.
 * @return void
 */

namespace Aijoh\Core\Supports\Csv;

use Aijoh\Core\Exceptions\FileNotFoundException;
use Aijoh\Core\Exceptions\InvalidFileEncodingException;
use Aijoh\Core\Exceptions\IOException;

/**
 * CSVファイルのタイトル行（ヘッダー）とデータを処理するクラス
 *
 * このクラスは、1行目をタイトルとして扱い、2行目以降をデータとして読み込むCSVファイルを
 * 処理するための機能を提供します。
 */
class TitledCsvReader
{
    /**
     * CSVファイルの読み込みを行うリーダー
     */
    private ?CsvReader $csvReader;

    /**
     * CSVのタイトル（ヘッダー）の一覧
     *
     * @var array<int,string>
     */
    private readonly TitledCsvMapper $mapper;

    /**
     * タイトルとその列インデックスのマッピング
     *
     * @var array<string,int>
     */
    private readonly array $titleToIndexMap;

    /**
     * 指定された設定でCsvReaderインスタンスを初期化します。
     *
     * @param  string  $filePath  読み込むCSVファイルのパス
     * @param  string  $encoding  CSVファイルの文字エンコーディング（デフォルト値: CsvReader::DEFAULT_ENCODING）
     * @param  string  $delimiter  CSVファイルのフィールド区切り文字（デフォルト値: ','）
     * @param  string  $enclosure  CSVファイルのフィールド囲み文字（デフォルト値: '"'）
     *
     * @throws FileNotFoundException ファイルが見つからない場合や読み込みが出来ない場合の例外
     * @throws IOException ファイルの読み込みが出来ない場合やタイトル行が読み込みでいない場合の例外
     * @throws InvalidFileEncodingException ファイル内の文字の文字コードが違っている場合の例外
     */
    public function __construct(
        private readonly string $filePath,
        private readonly string $encoding = CsvReader::DEFAULT_ENCODING,
        private readonly string $delimiter = ',',
        private readonly string $enclosure = '"',
    ) {
        $this->csvReader = new CsvReader($this->filePath, $this->encoding, $this->delimiter, $this->enclosure);
        $this->mapper = $this->getTitledCsvMapper();
    }

    /**
     * CSVファイルからタイトル行を読み込みます。
     *
     * @return TitledCsvMapper CSVのタイトルと添え字を管理するクラス
     *
     * @throws IOException タイトル行の読み込みに失敗した場合
     */
    protected function getTitledCsvMapper(): TitledCsvMapper
    {
        $titles = $this->csvReader->getCsv();
        if ($titles === false || empty($titles)) {
            throw new IOException('タイトル行の読み込みに失敗しました。');
        }

        return new TitledCsvMapper($titles);
    }

    /**
     * CSVファイルのタイトル一覧を取得する。
     *
     * @return array<string>
     */
    public function getTitles(): array
    {
        return $this->mapper->getTitles();
    }

    /**
     * 次の行のデータを取得する。
     */
    public function next(): ?TitledCsvRow
    {
        $csv = $this->csvReader->getCsv();
        if ($csv === false) {
            return null;
        }

        return new TitledCsvRow($this->mapper, $csv);
    }

    /**
     * 各行に対して指定されたコールバック関数を実行します。
     *
     * CSVファイルの各行に対して、指定されたコールバック関数を順番に実行します。
     * コールバック関数には、TitledCsvRow オブジェクトが渡されます。
     *
     * @param  callable  $callback  各行に対して実行するコールバック関数
     */
    public function each(callable $callback): void
    {
        while (($row = $this->next()) !== null) {
            $callback($row);
        }
    }

    /**
     * インスタンスが破棄される際にリソースを解放します。
     *
     * CSVReaderインスタンスへの参照を解放し、適切なリソースのクリーンアップを行います。
     */
    public function __destruct()
    {
        $this->csvReader = null;
    }
}
