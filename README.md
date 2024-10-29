# このパッケージはcoreです

[![Latest Version on Packagist](https://img.shields.io/packagist/v/aijoh/core.svg?style=flat-square)](https://packagist.org/packages/aijoh/core)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/aijoh/core/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/aijoh/core/actions?query=workflow%3Arun-tests+branch%3Amain)
 [![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/aijoh/core/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/aijoh/core/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/aijoh/core.svg?style=flat-square)](https://packagist.org/packages/aijoh/core)

パッケージをスケルトンから自動生成後に、ここにパッケージの概要を書きましょう。1〜2パラグラフ程度の内容に留め、簡単な例を記載しましょう

## Spatieをサポートしてね

Spatieでは多くの労力を注力して[最高レベルのオープンソースパッケージ](https://spatie.be/open-source)を作ってるので、サポートしてくれるなら[有償版の製品を何個か買ってくれると助かります](https://spatie.be/open-source/support-us).

それと、あなたの住んでる地元のポストカード使って、僕らの作ったパッケージの中から、あなたのお気に入りを書いて送ってくれると嬉しいです。住所は[ここに書いてあるよ](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## インストール

composerを使ってインストールしてください:

```bash
composer require aijoh/core
```

下記のコマンドで必要なマイグレーションファイルの出力とマイグレーションを実行します:

```bash
php artisan vendor:publish --tag="core-migrations"
php artisan migrate
```

Configファイルは下記のコマンドで出力可能です:

```bash
php artisan vendor:publish --tag="core-config"
```

出力されたConfigファイルの中身は次のような感じです:

```php
return [
];
```

オプションとして次のコマンドを実行すとでViewファイルも出力可能です:

```bash
php artisan vendor:publish --tag="core-views"
```

## 使い方

```php
$core = new Aijoh\Core();
echo $core->echoPhrase('Hello, Aijoh!');
```

## テスト方法

```bash
composer test
```

## 変更履歴

最近の変更履歴については[CHANGELOG](CHANGELOG.md)を参照してください

## 貢献について

このパッケージに貢献したい人は[CONTRIBUTING](CONTRIBUTING.md)を参考にしてください

## セキュリティや脆弱性について

[セキュリティポリシー](../../security/policy)を見て、必要な情報を送ってくれると助かります

## 貢献者

- [Watanabe Takashi](https://github.com/)
- [All Contributors](../../contributors)

## ライセンス

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
