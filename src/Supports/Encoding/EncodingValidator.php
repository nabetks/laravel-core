<?php

namespace Aijoh\Core\Supports\Encoding;

class EncodingValidator {
    /**
     * エンコーディング名のキャッシュ
     * @var array<string>|null
     */
    private static ?array $validEncodingsCache = null;

    /**
     * エンコーディングのエイリアスのキャッシュ
     * @var array<string, array<string>>|null
     */
    private static ?array $encodingAliasesCache = null;

    /**
     * 指定された文字エンコーディングが有効かどうかを検証する
     *
     * @param string $encoding 検証するエンコーディング名
     * @return bool 有効な場合はtrue、無効な場合はfalse
     */
    public static function isValid( string $encoding ) : bool {
        // エンコーディング名を正規化
        $normalizedEncoding = strtoupper(trim($encoding));

        // サポートされているエンコーディング一覧を取得
        $validEncodings = self::getValidEncodings();

        // 直接マッチするか確認
        if ( in_array($normalizedEncoding, $validEncodings, true) ) {
            return true;
        }

        // エイリアスをチェック
        return self::isValidAlias($normalizedEncoding);
    }

    /**
     * 有効なエンコーディング一覧を取得する
     *
     * @return array<string> エンコーディング名の配列
     */
    private static function getValidEncodings() : array {
        if ( self::$validEncodingsCache === null ) {
            self::$validEncodingsCache = array_map('strtoupper', mb_list_encodings());
        }

        return self::$validEncodingsCache;
    }

    /**
     * エンコーディング名がエイリアスとして有効かどうかを確認する
     *
     * @param string $encoding 検証するエンコーディング名
     * @return bool エイリアスとして有効な場合はtrue
     */
    private static function isValidAlias( string $encoding ) : bool {
        if ( self::$encodingAliasesCache === null ) {
            self::$encodingAliasesCache = [];
            foreach ( self::getValidEncodings() as $validEncoding ) {
                $aliases = array_map('strtoupper', mb_encoding_aliases($validEncoding));
                self::$encodingAliasesCache[ $validEncoding ] = $aliases;
            }
        }

        foreach ( self::$encodingAliasesCache as $aliases ) {
            if ( in_array($encoding, $aliases, true) ) {
                return true;
            }
        }

        return false;
    }

    /**
     * 指定されたエンコーディングの正規名を取得する
     *
     * @param string $encoding エンコーディング名
     * @return string|null 正規のエンコーディング名。無効な場合はnull
     */
    public static function getCanonicalName( string $encoding ) : ?string {
        $normalizedEncoding = strtoupper(trim($encoding));

        // 直接マッチする場合
        if ( in_array($normalizedEncoding, self::getValidEncodings(), true) ) {
            return $normalizedEncoding;
        }

        // エイリアスの場合、正規名を探す
        if ( self::$encodingAliasesCache === null ) {
            self::isValidAlias($normalizedEncoding); // キャッシュを初期化
        }

        foreach ( self::$encodingAliasesCache as $canonical => $aliases ) {
            if ( in_array($normalizedEncoding, $aliases, true) ) {
                return $canonical;
            }
        }

        return null;
    }
}
