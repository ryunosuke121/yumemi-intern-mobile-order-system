# ベースイメージとして公式のLaravel Sailイメージを使用
FROM laravelsail/php82-composer:latest as builder

# 作業ディレクトリを設定
WORKDIR /var/www/html

RUN apt-get update && apt-get install -y curl \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# アプリケーションの依存関係をインストール
COPY . .

COPY ./deploy/.env.production .env

RUN composer install --optimize-autoloader --no-dev

# フロントエンド依存関係のインストールとビルド（必要な場合）
RUN npm install && npm run build

# プロダクション用のイメージを作成
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql pcntl

# Nginxのインストール
RUN apt-get update && apt-get install -y nginx supervisor \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN adduser --system --no-create-home --disabled-login --disabled-password --group nginx

# 作業ディレクトリを設定
WORKDIR /var/www/html

# ビルダーからLaravelアプリケーションをコピー
COPY --from=builder /var/www/html .

# NginxとPHP-FPMの設定ファイルをコピー
COPY ./deploy/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./deploy/nginx/default.conf /etc/nginx/conf.d/default.conf

# Nginxのエントリポイントを設定
COPY ./deploy/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# ストレージリンクの作成とキャッシュの最適化
RUN php artisan storage:link && php artisan config:cache && php artisan route:cache

# ポートのエクスポート
EXPOSE 80

# Supervisorを使ってNginxとPHP-FPMを同時に起動
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]