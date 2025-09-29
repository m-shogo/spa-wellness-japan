FROM wordpress:php8.3

# 必要な依存関係のインストール
RUN apt-get update && apt-get install -y \
  curl \
  less \
  default-mysql-client \
  && rm -rf /var/lib/apt/lists/*

# wp-cliのインストール
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
  && chmod +x wp-cli.phar \
  && mv wp-cli.phar /usr/local/bin/wp

# wp-cliが正しくインストールされたか確認
RUN wp --info

# ポート80を公開
EXPOSE 80

# WordPressディレクトリの権限を設定
RUN chown -R www-data:www-data /var/www/html && \
  find /var/www/html -type d -exec chmod 755 {} \; && \
  find /var/www/html -type f -exec chmod 644 {} \;
