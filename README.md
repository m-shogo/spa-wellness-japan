# デモサイト（フロント構築用PHP8ver・ブロックエディタ対応版）

## 概要

このプロジェクトは社内案件用の共通ベーステーマです。  
WordPress・Docker・npm を利用してローカル開発が可能です。

---

## 環境

- PHP: 8.2（Docker内）
- WordPress: 最新
- Node.js: v18 以上
- npm: v9 以上
- Docker / Docker Compose

---

## ディレクトリ構成（概要）

### プロジェクトルート

```
bs-config.js        # Browsersync設定
docker-compose.yml  # Dockerコンテナ構成
Dockerfile          # PHP + Apache環境設定
imagemin.mjs        # 画像圧縮スクリプト
webp.mjs            # webp変換スクリプト
php/php.ini         # PHP設定
wp/                 # WordPress本体
wp-install/         # WordPress初期インストール用スクリプト
```

### テーマディレクトリ（`wp/wp-content/themes/codiawp_block`）

```
acf/blocks/         # ACFブロックテンプレート
css/                # SCSS・CSS
js/                 # JavaScript（jQuery, Swiper 等）
inc/                # 機能別PHPモジュール（functions.phpで読み込み）
template-parts/     # パーツテンプレート（ヘッダー・フッター・メニュー等の共通項目）
images/             # 画像（圧縮・変換後）
images_orignal/     # 元画像（本番環境にはアップしません）
```

---

## 初期セットアップ

1. **Docker 起動・WordPress インストール**

```bash
docker compose up -d
```

2. **WordPressの初期設定**

```bash
docker exec -it 【WordPressのコンテナ名】 /bin/bash # コンテナに入る
```

```bash
chmod +x /tmp/wp-install/wp-install.sh # 実行権限を付与
```

```bash
/tmp/wp-install/wp-install.sh # WP-CLIを実行
```

これで[http://localhost:8000/](http://localhost:8000/)にアクセスすると、
WordPressがセットアップされた状態で立ち上がっているはずなので確認してください。
※ID：wordpress、PW：wordpressでログインできます。

3. **npm パッケージインストール**

```bash
npm install
```

4. **開発サーバー起動（SCSS コンパイル & Browsersync）**

```bash
npm run watch
```

## 主なコマンド一覧

| コマンド                    | 説明                                                                          |
| --------------------------- | ----------------------------------------------------------------------------- |
| `npm run css:sass`          | SCSSをコンパイルしてCSSを生成（圧縮形式）                                     |
| `npm run css:autoprefix`    | CSSにベンダープレフィックスを付与                                             |
| `npm run css:min`           | CSSを圧縮                                                                     |
| `npm run css`               | SCSSコンパイル → autoprefix → BrowserSyncリロード                             |
| `npm run watch:css`         | SCSS ファイル変更を監視して自動コンパイル                                     |
| `npm run watch:img`         | `images_orignal` 内の画像変更を監視して自動圧縮                               |
| `npm run watch:webp`        | `images_orignal` 内の画像変更を監視して自動WebP変換                           |
| `npm run watch:server`      | BrowserSync サーバーを起動                                                    |
| `npm run watch`             | SCSS / 画像圧縮 / WebP変換 / BrowserSync を並列で実行（開発時の通常コマンド） |
| `npm run browserSyncReload` | BrowserSyncを手動でリロード                                                   |
| `npm run lint:scss`         | SCSSの構文チェック（Stylelint）                                               |
| `npm run format:scss`       | SCSSの自動整形（Stylelint + Prettier）                                        |
| `npm run format`            | フォーマット関連のコマンドをまとめて実行                                      |

---

## WordPressインストール後の初期設定

1. [ACF Pro版](https://drive.google.com/drive/folders/1zLGKMkJFZVmblvwwk-B6JWf1sFOAOMoV 'ACF Pro版')を手動でインストールする（プラグインが古い場合は最新版に更新すること）
2. デモサイトからACFのjsonをエクスポートし、ローカル環境にインポートする（※JSON同期に移行予定です）
3. ダッシュボード - 更新 > 翻訳を更新
4. 設定 > パーマリンク - カスタム投稿タイプのパーマリンク設定「カスタマイズされたカスタムタクソノミーのパーマリンクを使用する。」にチェックを入れる ※必要に応じて

---

## 注意事項

- `functions.php` に直接大きな処理は書かず、`inc/` に分割してください。
- ACFblockは `acf/blocks/` に作成してください。
- 画像は必ず `images_orignal` に登録し、 `images` に出力された変換済みの画像を使用してください。
- 社内向けテーマのため、外部公開は禁止です
- ACFのフィールドデータは **JSON同期** に移行予定です（`acf-json/`）

---

## ライセンス

Codia Inc.
社内専用 / 無断利用禁止
