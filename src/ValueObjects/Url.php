<?php

namespace Aijoh\Core\ValueObjects;

class Url extends BaseObject
{
    /**
     * バリデーションルールの取得
     */
    public function getRules(): array|string|null
    {
        return 'string|url';
    }

    /**
     * バリデーションメッセージの取得
     */
    public function getMessages(): ?array
    {
        return [
            'url' => 'URL形式で入力してください',
        ];
    }

    public function getAttribute(): string
    {
        return 'URL';
    }

    /**
     * HTTPSかどうかの判別
     */
    public function isHttps(): bool
    {
        return $this->getProtocol() === 'https';
    }

    /**
     * プロトコルの取得
     */
    public function getProtocol(): string
    {
        return parse_url($this->value, PHP_URL_SCHEME);
    }

    /**
     * ホストの取得
     */
    public function getHost(): string
    {
        return parse_url($this->value, PHP_URL_HOST);
    }

    /**
     * パスの取得
     */
    public function getPath(): string
    {
        return parse_url($this->value, PHP_URL_PATH);
    }

    /**
     * クエリの取得
     */
    public function getQuery(): string
    {
        return parse_url($this->value, PHP_URL_QUERY);
    }

    /**
     * フラグメントの取得
     */
    public function getFragment(): string
    {
        return parse_url($this->value, PHP_URL_FRAGMENT);
    }
}
