docker + npm-scriptsについて
環境作りたいフォルダをgit登録
.gitignoreを上げる。（あげないとnode_moduleといういらないファイルもgit下になる）
そのフォルダに

//////////////////////////
.browserslistrc
.prettierrc.json
.stylelintrc.json
bs-config.js
docker-compose.yml
Dockerfile
imagemin.js
package.json
phpフォルダ中に php.ini
webp.mjs
wp-installフォルダ中に wp-install.sh
//////////////////////////

https://ics.media/entry/3290/
Node.jsやdockerがインストール済み

ターミナル　コマンドプロンプト黒い画面で下記のコマンド
そのフォルダに移行
例下記
cd C:\htdocs\miwada

docker-compose up -d
docker compose up -d

WP CLI
https://keikenchi.com/steps-to-build-a-wordpress-theme-plugin-development-environment-with-docker

下記コマンドでコンテナに入り、コンテナ内でコマンド入力。「wordpress」部分が「docker-compose.yml」で指定したコンテナ名。
docker exec -it pcdgc-medic-internationalschool /bin/bash

上記の記事とはコマンド違うけど気にしない。
シェルスクリプトファイルの権限を変更。
chmod +x /tmp/wp-install/wp-install.sh

シェルスクリプトの実行。
/tmp/wp-install/wp-install.sh

下記エラーが出たら、wp-install.shの改行コードがおかしいので、改行コードを「LF」に直してから再実行。
bash: /tmp/wp-install.sh: /bin/bash^M: bad interpreter: No such file or directory


ブラウザでhttp://localhost:8000/にアクセスwpの設定
エラー出たら下記参照：{"Message":"Unhandled exception: Drive has not been shared"}
https://gangannikki.hatenadiary.jp/entry/2020/02/03/200000

advanced-custom-fields-pro.zipのプラグインを入れとく

themesにcodiawp_standard入れる名称変える時は
packege.jsonのcodiawp_standard部分
"css:autoprefix": "postcss wp/wp-content/themes/miwada/css/style.css -u autoprefixer -o wp/wp-content/themes/miwada/css/style.css",
"watch:img": "chokidar \"wp/wp-content/themes/codiawp_standard/images_orignal\" -c \"node imagemin.js\" --initial",
・"css:autoprefix"windowsではtheme名*エラー
・"watch:img"ワイルドカード（*）じゃwatchできなかった

npm install
npm run watch
してhttp://localhost:3000/にアクセスhttp://localhost:8000/の事は忘れる。

scssやphpを触って更新されるかどうか確認。
（エディタのscssコンパイルは切る）

終わり
次回以降
dockerは立ち上げ時起動される。
他のdocker環境やるときは止める必要あり。理由は一番下

停止は
確認
docker ps
停止
docker stop CONTAINER ID
削除
docker-compose down --rmi all

CONTAINER IDはdocker psで見れる。

ディスクトップのdockerアプリからも停止等可能。（そっちのが楽かも）


共有する場合
・node_modulesは環境毎に消してnpm installする。
node_modulesは共有できないぽぃエラーでる。


課題
・編集したscssファイルだけじゃなく全てコンパイルされる。（ちょっとラグ）
・theme名指定なのでそこでしか反応しない。（ワイルドカード？使う？？やってみたが出来なかった）


【大事なのはdb_dataの中身】

gitにdb_dataも上げる場合（どうしようか考え中）
db_dataの中身つまりwordpressだけ触ってもgitに（変更ファイルに）表示されない。
phpやscssの変更があればdb_dataの中身もgitに（変更ファイルに）表示される。
在宅でやる場合は最後phpなどさわってdb_dataの中身も表示してからコミットすべき。

git上げずにdb_dataの中身だけzipでもするのも可
ただwpのuploadsはgit範囲外なので、在宅などで欲しかったらこれもzip
環境でそんなメディアアップロードしないからいいとは思う。


【在宅と会社双方切替】
dockerはパソコン起動すると起動される。
以前docker-compose up -dで実行されていたのが起動されている（停止や削除してなければ）
停止や削除はdockerのアイコンやアプリからいけるはず。（コマンドでも可）
停止や削除したらdb系の変更ファイル削除してプルまたはマージする。
停止や削除しないと削減出来ない延々と生成されるので。
プル又はマージした後
docker-compose up -dで起動
言うなれば毎回停止や削除してからコミットした方がいい。（在宅と会社双方で切り替える時）


【同時に二つ起動はいろいろ大変】
多分
bs-config.js
"proxy": "http://localhost:8000/",

docker-compose.yml
ports:
       - "8000:80"
のポート番号変えるだけでいける？
データベース名も変える必要あるかも。
競合しちゃう。