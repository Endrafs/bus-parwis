#!/bin/bash
# ======================================================
# 🚀 Deployment Script — PHD Trans (busparwis.my.id)
# ======================================================
# Cara pakai:
#   1. SSH ke VPS Hostinger: ssh root@<IP_VPS>
#   2. Upload script ini ke VPS
#   3. Jalankan: chmod +x deploy.sh && ./deploy.sh
# ======================================================

set -e

# ============ Konfigurasi ============
DOMAIN="busparwis.my.id"
PROJECT_DIR="/var/www/busparwis"
REPO_URL="https://github.com/Endrafs/bus-parwis.git"
PHP_VERSION="8.3"
DB_NAME="bus_parwis"
DB_USER="busparwis_user"
DB_PASSWORD=$(openssl rand -base64 16)

GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

echo -e "${GREEN}"
echo "╔══════════════════════════════════════════════╗"
echo "║   🚀 PHD Trans — Deployment Script          ║"
echo "║   Domain: $DOMAIN            ║"
echo "╚══════════════════════════════════════════════╝"
echo -e "${NC}"

# Cek root
if [[ $EUID -ne 0 ]]; then
   echo -e "${RED}❌ Script ini harus dijalankan sebagai root${NC}"
   exit 1
fi

# ============ Stage 1: System Update & Dependencies ============
echo -e "\n${YELLOW}[1/10] 📦 Mengupdate sistem dan menginstall dependencies...${NC}"

apt update && apt upgrade -y

# Install Nginx
if ! command -v nginx &> /dev/null; then
    apt install nginx -y
    systemctl enable nginx
fi

# Install PHP + extensions
if ! command -v php$PHP_VERSION &> /dev/null; then
    if [ -f /etc/debian_version ]; then
        apt install -y lsb-release ca-certificates apt-transport-https software-properties-common
        curl -fsSL https://packages.sury.org/php/apt.gpg | gpg --dearmor -o /usr/share/keyrings/sury-php.gpg
        echo "deb [signed-by=/usr/share/keyrings/sury-php.gpg] https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/sury-php.list
        apt update
    fi
    apt install -y php$PHP_VERSION-fpm php$PHP_VERSION-cli php$PHP_VERSION-mysql \
        php$PHP_VERSION-xml php$PHP_VERSION-mbstring php$PHP_VERSION-curl \
        php$PHP_VERSION-zip php$PHP_VERSION-bcmath php$PHP_VERSION-gd \
        php$PHP_VERSION-intl php$PHP_VERSION-soap php$PHP_VERSION-redis
    systemctl enable php$PHP_VERSION-fpm
fi

# Install MariaDB
if ! command -v mariadb &> /dev/null; then
    apt install mariadb-server mariadb-client -y
    systemctl enable mariadb
    systemctl start mariadb
fi

# Install Composer
if ! command -v composer &> /dev/null; then
    curl -sS https://getcomposer.org/installer | php
    mv composer.phar /usr/local/bin/composer
fi

# Install Node.js
if ! command -v node &> /dev/null; then
    apt install nodejs npm -y
fi

# Install Certbot
if ! command -v certbot &> /dev/null; then
    apt install certbot python3-certbot-nginx -y
fi

# Install Supervisor
if ! command -v supervisorctl &> /dev/null; then
    apt install supervisor -y
fi

echo -e "${GREEN}✅ Semua dependencies terinstall${NC}"



# ============ Stage 2: Database Setup ============
echo -e "\n${YELLOW}[2/10] 🗃️  Setup database...${NC}"

systemctl start mariadb 2>/dev/null || true

mysql -e "CREATE DATABASE IF NOT EXISTS $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -e "CREATE USER IF NOT EXISTS '$DB_USER'@'localhost' IDENTIFIED BY '$DB_PASSWORD';"
mysql -e "GRANT ALL PRIVILEGES ON $DB_NAME.* TO '$DB_USER'@'localhost'; FLUSH PRIVILEGES;"

cat > /root/.busparwis_db_credentials << EOF
Database: $DB_NAME
User: $DB_USER
Password: $DB_PASSWORD
EOF
chmod 600 /root/.busparwis_db_credentials

echo -e "${GREEN}✅ Database '$DB_NAME' dan user '$DB_USER' berhasil dibuat${NC}"

# ============ Stage 3: Clone Aplikasi ============
echo -e "\n${YELLOW}[3/10] 📥 Clone aplikasi...${NC}"

if [ -d "$PROJECT_DIR" ]; then
    echo "📂 Direktori sudah ada, melakukan backup..."
    tar -czf "/root/busparwis-backup-$(date +%Y%m%d-%H%M%S).tar.gz" -C "$PROJECT_DIR" .
    cd "$PROJECT_DIR"
    git pull origin main 2>/dev/null || echo "⚠️  Git pull gagal, lanjut..."
else
    mkdir -p "$PROJECT_DIR"
    git clone "$REPO_URL" "$PROJECT_DIR"
    cd "$PROJECT_DIR"
fi

# Masuk ke direktori src (karena source di dalam folder src)
if [ -d "$PROJECT_DIR/src" ]; then
    cd "$PROJECT_DIR/src"
    PROJECT_SRC="$PROJECT_DIR/src"
else
    cd "$PROJECT_DIR"
    PROJECT_SRC="$PROJECT_DIR"
fi

echo -e "${GREEN}✅ Aplikasi siap di $PROJECT_SRC${NC}"


# ============ Stage 4: Setup .env ============
echo -e "\n${YELLOW}[4/10] ⚙️  Setup .env file...${NC}"

if [ -f .env ]; then
    cp .env ".env.backup-$(date +%Y%m%d-%H%M%S)"
fi

cat > .env << EOF
APP_NAME="PHD Trans --- Bus Pariwisata Premium"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_TIMEZONE='Asia/Jakarta'
APP_URL="https://$DOMAIN"
ASSET_URL="https://$DOMAIN"
DEBUGBAR_ENABLED=false
ASSET_PREFIX=

APP_LOCALE=id
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US
APP_MAINTENANCE_DRIVER=file
PHP_CLI_SERVER_WORKERS=4
BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE="$DB_NAME"
DB_USERNAME="$DB_USER"
DB_PASSWORD="$DB_PASSWORD"

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=true
SESSION_PATH=/
SESSION_DOMAIN=.busparwis.my.id

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database
CACHE_STORE=database

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="noreply@$DOMAIN"
MAIL_FROM_NAME="PHD Trans"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="PHD Trans"
EOF

# ============ Stage 5: Install PHP Dependencies ============
echo -e "\n${YELLOW}[5/10] 📦 Install composer dependencies...${NC}"

rm -rf vendor/
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

echo -e "${GREEN}✅ Composer dependencies installed${NC}"

# ============ Stage 6: Generate APP_KEY ============
echo -e "\n${YELLOW}[6/10] 🔑 Generate APP_KEY...${NC}"

php artisan key:generate --force

echo -e "${GREEN}✅ APP_KEY generated${NC}"


echo -e "${GREEN}✅ .env berhasil dibuat${NC}"


# ============ Stage 7: Setup Storage & Permissions ============
echo -e "\n${YELLOW}[7/10] 🔧 Fix storage permissions...${NC}"

mkdir -p storage/app/public
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

php artisan storage:link --force || true

chown -R www-data:www-data .
chmod -R 775 storage bootstrap/cache

echo -e "${GREEN}✅ Storage permissions fixed${NC}"

# ============ Stage 8: Database Migration & Seed ============
echo -e "\n${YELLOW}[8/10] 🗃️  Migrate database...${NC}"

php artisan migrate --force

read -p "❓ Apakah ingin menjalankan database seed? (y/N): " SEED_CONFIRM
if [ "$SEED_CONFIRM" = "y" ] || [ "$SEED_CONFIRM" = "Y" ]; then
    php artisan db:seed --force
    echo -e "${GREEN}✅ Database seeded${NC}"
fi

echo -e "${GREEN}✅ Database migrated${NC}"


# ============ Stage 9: Laravel Optimization ============
echo -e "\n${YELLOW}[9/10] ⚡ Optimasi Laravel...${NC}"

php artisan optimize
php artisan view:cache
php artisan route:cache
php artisan config:cache

if [ -f package.json ]; then
    if [ -d node_modules ]; then
        npm run build
    else
        npm install --production
        npm run build
    fi
fi

echo -e "${GREEN}✅ Laravel optimized${NC}"

# ============ Stage 10: Setup Nginx & SSL ============
echo -e "\n${YELLOW}[10/10] 🌐 Setup Nginx & SSL...${NC}"

if [ -f "$PROJECT_DIR/nginx/production.conf" ]; then
    cp "$PROJECT_DIR/nginx/production.conf" /etc/nginx/sites-available/$DOMAIN
else
    cat > /etc/nginx/sites-available/$DOMAIN << 'NGINXEOF'
server {
    listen 80;
    listen [::]:80;
    server_name DOMAIN_PLACEHOLDER www.DOMAIN_PLACEHOLDER;
    return 301 https://$server_name$request_uri;
}
server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_tokens off;
    server_name DOMAIN_PLACEHOLDER www.DOMAIN_PLACEHOLDER;
    root /var/www/busparwis/src/public;
    index index.php index.html;
    client_max_body_size 20M;
    ssl_certificate /etc/letsencrypt/live/DOMAIN_PLACEHOLDER/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/DOMAIN_PLACEHOLDER/privkey.pem;
    location / { try_files $uri $uri/ /index.php?$query_string; }
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
    location ~ /\.ht { deny all; }
    location ~ /\.env { deny all; }
    location ~ /\.git { deny all; }
}
NGINXEOF
    sed -i "s/DOMAIN_PLACEHOLDER/$DOMAIN/g" /etc/nginx/sites-available/$DOMAIN
fi

sed -i "s|/var/www/busparwis|$PROJECT_DIR|g" /etc/nginx/sites-available/$DOMAIN

ln -sf /etc/nginx/sites-available/$DOMAIN /etc/nginx/sites-enabled/
rm -f /etc/nginx/sites-enabled/default

nginx -t

echo -e "\n${YELLOW}🔐 Setup SSL Certificate...${NC}"
echo -e "${YELLOW}Pastikan domain $DOMAIN sudah mengarah ke IP VPS ini!${NC}"
read -p "❓ Apakah domain sudah diarahkan? (y/N): " DNS_CONFIRM

if [ "$DNS_CONFIRM" = "y" ] || [ "$DNS_CONFIRM" = "Y" ]; then
    systemctl restart nginx
    certbot --nginx -d "$DOMAIN" -d "www.$DOMAIN" --non-interactive --agree-tos --email admin@"$DOMAIN"
    echo -e "${GREEN}✅ SSL Certificate installed!${NC}"
else
    echo -e "${YELLOW}⚡ Setup Nginx tanpa SSL dulu${NC}"
    echo "Jalankan nanti: certbot --nginx -d $DOMAIN -d www.$DOMAIN"
fi

# ============ Setup Scheduler (Cron) ============
echo -e "\n${YELLOW}⏰ Setup Laravel Scheduler...${NC}"

crontab -u www-data -l 2>/dev/null | grep -v "artisan schedule" | crontab -u www-data - || true
(crontab -u www-data -l 2>/dev/null; echo "* * * * * /usr/bin/php $PROJECT_SRC/artisan schedule:run >> /dev/null 2>&1") | crontab -u www-data -

echo -e "${GREEN}✅ Laravel Scheduler configured${NC}"

# ============ Setup Queue Worker ============
echo -e "\n${YELLOW}⚙️  Setup Queue Worker...${NC}"

cat > /etc/supervisor/conf.d/busparwis-worker.conf << EOF
[program:busparwis-worker]
process_name=%(program_name)s_%(process_num)02d
command=/usr/bin/php $PROJECT_SRC/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=$PROJECT_SRC/storage/logs/queue-worker.log
stopwaitsecs=3600
EOF

supervisorctl reread
supervisorctl update
supervisorctl start busparwis-worker:* || true

echo -e "${GREEN}✅ Queue Worker configured${NC}"

# ============ Firewall ============
echo -e "\n${YELLOW}🛡️  Setup Firewall...${NC}"

apt install ufw -y
ufw --force disable
ufw default deny incoming
ufw default allow outgoing
ufw allow 22/tcp comment 'SSH'
ufw allow 80/tcp comment 'HTTP'
ufw allow 443/tcp comment 'HTTPS'
ufw --force enable

echo -e "${GREEN}✅ Firewall configured${NC}"

# ============ Selesai! ============
echo -e "\n${GREEN}"
echo "╔══════════════════════════════════════════════╗"
echo "║   ✅ DEPLOYMENT SELESAI!                     ║"
echo "╚══════════════════════════════════════════════╝"
echo -e "${NC}"
echo ""
echo "🌐 Website: https://$DOMAIN"
echo "🔐 Admin:   https://$DOMAIN/admin"
echo ""
echo "📋 Database Credentials: /root/.busparwis_db_credentials"
echo ""
echo "⚠️  Jangan lupa:"
if [ "$DNS_CONFIRM" != "y" ]; then
    echo "  1. Arahkan domain $DOMAIN ke IP VPS ini di panel IDwebhost"
    echo "  2. Jalankan: certbot --nginx -d $DOMAIN -d www.$DOMAIN"
fi
echo "  3. Cek website: curl -I https://$DOMAIN"
echo ""
echo -e "${YELLOW}📌 DB Password: $DB_PASSWORD${NC}"
echo ""


systemctl restart nginx
systemctl enable nginx
echo -e "${GREEN}✅ Nginx configured${NC}"
