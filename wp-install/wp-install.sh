#!/bin/bash

set -Ceu

# WordPressセットアップ admin_user,admin_passwordは管理画面のログインID,PW
wp core install \
--url='http://localhost:9000' \
--title='portofolio' \
--admin_user='shogo' \
--admin_password='0409' \
--admin_email='m-shogo@m-shogo.co.jp' \
--allow-root

# 日本語化
wp core language install ja --activate --allow-root

# タイムゾーンと日時表記
wp option update timezone_string 'Asia/Tokyo' --allow-root
wp option update date_format 'Y-m-d' --allow-root
wp option update time_format 'H:i' --allow-root

# サイトアドレス(URL)を変更
wp option update siteurl 'http://localhost:9000/wp' --allow-root

# キャッチフレーズの設定 (空にする)
wp option update blogdescription '' --allow-root

# 管理画面のカラースキームを変更
wp user meta update 1 admin_color sunrise --allow-root

# デフォルトの不要記事削除
wp post delete 1 2 3 --force --allow-root

# 日本語のコアアップデート
wp core update --locale=ja --force --allow-root

# 新しい投稿へのコメントを許可をしない
wp option update default_pingback_flag 0 --allow-root
wp option update default_comment_status closed --allow-root
wp option update default_ping_status closed --allow-root

# 検索エンジンがサイトをインデックスしないようにする
wp option update blog_public 0 --allow-root

# プラグインの削除 (不要な初期プラグインを削除)
wp plugin delete hello.php --allow-root
wp plugin delete akismet --allow-root

# プラグインのインストール
wp plugin install addquicktag --version=2.5.3 --activate --allow-root #インポートの不具合のため古いバージョンを指定
wp plugin install tinymce-advanced --activate --allow-root
wp plugin install autoptimize --activate --allow-root
wp plugin install classic-editor --activate --allow-root
wp plugin install custom-post-type-permalinks --activate --allow-root
wp plugin install ewww-image-optimizer --activate --allow-root
wp plugin install wp-multibyte-patch --activate --allow-root
wp plugin install duplicate-post --activate --allow-root
wp plugin install /tmp/wp-install/advanced-custom-fields-pro-5.12.3.zip --activate --allow-root

# プラグインの翻訳のアップデート
wp language plugin update --all --allow-root

# 翻訳の更新
wp core language update --allow-root

# テーマの削除
# wp theme delete twentytwentytwo --allow-root
wp theme delete --all --allow-root

# パーマリンク更新
wp option update permalink_structure /news/%post_id%/ --allow-root
