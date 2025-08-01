<?php

namespace Aijoh\Core\Supports\Csv;

readonly class TitledCsvRow
{
    /**
     * @param  TitledCsvMapper  $mapper  タイトルとインデックスのマッピング
     * @param  array<int,string>  $values  CSV行の値配列
     */
    public function __construct(
        private TitledCsvMapper $mapper,
        private array $values
    ) {}

    /**
     * タイトルまたはインデックスに対応する値を取得
     *
     * @param  string|int  $titleOrIndex  タイトル文字列またはインデックス
     * @return ?string 対応する値（存在しない場合はnull）
     */
    public function get(string|int $titleOrIndex): ?string
    {
        $index = $this->mapper->findIndex($titleOrIndex);

        return $this->getValueByIndex($index);
    }

    /**
     * インデックスに対応する値を取得
     *
     * @param  int  $index  取得する値のインデックス
     * @return ?string 対応する値（存在しない場合はnull）
     */
    private function getValueByIndex(int $index): ?string
    {
        return $this->values[$index] ?? null;
    }

    /**
     * 指定されたタイトル配列に対応する全ての値を取得
     *
     * @param  array<string>  $titles  取得対象のタイトル配列
     * @return array<?string> タイトルに対応する値の配列
     */
    public function getAll(array $titles): array
    {
        return array_map(
            fn (string $title) => $this->get($title),
            $titles
        );
    }

    /**
     * タイトルとインデックスのマップから値の配列を生成
     *
     * @param  array<string,int>  $titleIndexMap  タイトルとインデックスのマップ
     * @return array<string,string> タイトルと値のマップ
     */
    private function createValuesFromTitleMap(array $titleIndexMap): array
    {
        return array_map(
            fn (int $index) => $this->getValueByIndex($index),
            $titleIndexMap
        );
    }

    /**
     * グロブパターンに一致するタイトルに対応する値を取得
     *
     * @param  string  $pattern  グロブパターン
     * @return array<string,string> タイトルと値のマップ
     */
    public function glob(string $pattern): array
    {
        $matches = $this->mapper->glob($pattern);

        return $this->createValuesFromTitleMap($matches);
    }

    /**
     * 正規表現パターンに一致するタイトルに対応する値を取得
     *
     * @param  string  $pattern  正規表現パターン
     * @return array<string,string> タイトルと値のマップ
     */
    public function match(string $pattern): array
    {
        $matches = $this->mapper->match($pattern);

        return $this->createValuesFromTitleMap($matches);
    }

    /**
     * CSVのタイトル一覧を取得
     *
     * @return array<int,string> タイトルの配列
     */
    public function getTitles(): array
    {
        return $this->mapper->getTitles();
    }

    /**
     * CSV行の全値を配列として取得
     *
     * @return array<int,string> 値の配列
     */
    public function getValues(): array
    {
        return $this->values;
    }
}
