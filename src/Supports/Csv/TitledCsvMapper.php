<?php

namespace Aijoh\Core\Supports\Csv;

use Aijoh\Core\Exceptions\InvalidFileEncodingException;

readonly class TitledCsvMapper {
    private const int INVALID_INDEX = -1;

    /**
     * タイトルとindexのマップ
     * @var array<string,int>
     */
    private array $titleIndex;

    /**
     * タイトルの要素数
     * @var int
     */
    private int   $maxIndexCount;

    /**
     * CSVのタイトルとインデックスを管理するクラス
     * @param array<int,string> $titles CSVのヘッダー行の配列
     * @throws \InvalidArgumentException タイトルが空の場合
     */
    public function __construct( private array $titles ) {
        if ( empty($titles) || count($titles) === 0 ) {
            throw new \InvalidArgumentException('タイトルは1つ以上必要です。');
        }
        $i = 0;
        foreach ( $titles as $index => $title ) {
            if( $i !== $index){
                var_dump($titles);
                throw new \InvalidArgumentException("添え字は数字である必要があります。添え字:{$index}");
            }
            if( ! is_string($title) ){
                var_dump($titles);
                throw new \InvalidArgumentException("タイトルは文字列である必要があります。タイトル:{$title}");
            }
            ++$i;
        }

        $this->titleIndex = array_flip($this->titles);
        $this->maxIndexCount = count($this->titles);
    }

    /**
     * タイトルまたはインデックスに対応する位置を返す
     * @param string|int $titleOrIndex タイトルまたはインデックス
     * @return int 見つかった位置、または INVALID_INDEX
     */
    public function findIndex( string|int $titleOrIndex ) : int {
        if ( is_string($titleOrIndex) && isset($this->titleIndex[ $titleOrIndex ]) ) {
            return $this->titleIndex[ $titleOrIndex ];
        }
        return $this->validateIndex($titleOrIndex);
    }

    /**
     * インデックスの有効性を確認
     * @param int|string $index 確認するインデックス
     * @return int 有効な場合は同じ値、無効な場合は INVALID_INDEX
     */
    private function validateIndex( int|string $index ) : int {
        if( is_string($index) ){
            if( ! is_numeric($index) ){
                return self::INVALID_INDEX;
            }
            $index = (int)$index;
        }

        return ( $index >= 0 && $index < $this->maxIndexCount )
            ? $index
            : self::INVALID_INDEX;
    }

    /**
     * 指定したタイトル、indexに対応する indexの配列を返す。
     * @param array<int,string|int> $titles
     * @return array<int,int> タイトルに対応する要素の一覧
     */
    public function findIndexAll( array $titles ) : array {
        foreach ($titles as $title) {
            if (!is_string($title) && ! is_int($title) ) {
                throw new \InvalidArgumentException("タイトルは文字列または配列の添え字(数字)である必要があります。指定された値:{$title}");
            }
        }

        return array_map(function(string|int $titleOrIndex){
            return $this->findIndex( $titleOrIndex );
        }, $titles);

    }


    /**
     * @param string $pattern
     * @param callable $matcher
     * @return array<string,int>
     */
    private function findTitlePattern( string $pattern, callable $matcher ) : array {
        return array_filter($this->titleIndex,
            function($title) use ($pattern, $matcher) {
                return $matcher($pattern, $title);
            },
        ARRAY_FILTER_USE_KEY
        );
    }

    /**
     * 指定したタイトルのパターンに一致するタイトルとそのインデックスの配列を返す。
     * マッチパターンはfnmatchの書式に従う。
     * @param string $pattern マッチするパターン
     * @return array<string,int> タイトルのマッチパターンに対応する要素の一覧
     */
    public function glob( string $pattern ) : array {
        return $this->findTitlePattern( $pattern,
            function($pattern,$title){
                return fnmatch($pattern, $title);
            }
        );
    }

    /**
     * 複数のパターンに対してタイトルのマッチングを行い、それぞれのパターンに対応するタイトルとインデックスの配列を返す。
     * マッチパターンはfnmatchの書式に従う。
     *
     * @param array<int,string> $patterns マッチングを行うパターンの配列
     * @return array<int,array<string,int>> パターンをキー、マッチしたタイトルとそのインデックスを値とする配列
     */
    public function globAll( array $patterns ) : array {
        foreach ($patterns as $pattern) {
            if (!is_string($pattern) ) {
                throw new \InvalidArgumentException("パターンは文字列である必要があります。不正なパターン:{$pattern}");
            }
        }

        return array_map(function(string $pattern) {
            return $this->glob( $pattern );
        }, $patterns);
    }

    /**
     * 正規表現パターンに一致するタイトルとそのインデックスの配列を返す。
     * preg_matchを使用して、タイトルが指定されたパターンに一致するかを判定する。
     *
     * @param string $pattern 正規表現パターン（preg_matchの書式に従う）
     * @return array<string,int> タイトルとインデックスのマッピング配列
     */
    public function match( string $pattern ) : array {
        try {
            if (preg_match($pattern, '') === false) {
                throw new \InvalidArgumentException("正規表現のパターンが無効です。正規表現：{$pattern}");
            }
        } catch (\Exception $e) {
            throw new \InvalidArgumentException("正規表現の評価中にエラーが発生しました：{$e->getMessage()}");
        }


        return $this->findTitlePattern( $pattern, function(string $pattern,string $title){
            return (bool)preg_match( $pattern, $title );
        });
    }


    /**
     * 登録されているタイトルの一覧を返す
     * @return array<int,string>
     */
    public function getTitles() : array {
        return $this->titles;
    }
}
