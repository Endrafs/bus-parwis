# 🚀 Deployment Guide — PHD Trans (busparwis.my.id)

Panduan lengkap untuk mendeploy website **PHD Trans — Sistem Penyewaan Bus Pariwisata Premium** ke **VPS Hostinger** dengan domain **busparwis.my.id** dari **IDwebhost**.

---

## 📋 Prasyarat

| Item | Keterangan |
|------|-----------|
| **Domain** | busparwis.my.id (dari IDwebhost) |
| **VPS** | Hostinger VPS (min. 2GB RAM, 2 core CPU) |
| **OS** | Ubuntu 22.04+ / Debian 12 |
| **GitHub Repo** | https://github.com/Endrafs/bus-parwis.git |

---

## 🔧 Metode 1: Deployment Manual via Script (Termudah)

### Langkah 1: Setup DNS di IDwebhost

1. Login ke **panel IDwebhost**
2. Masuk ke **Domain** → **Kelompok Domain** → klik domain **busparwis.my.id**
3. Pilih **DNS / Nameserver Management**
4. Buat **A Record**:
   - **Name**: `@` (atau kosongkan)
   - **Type**: A
   - **Value**: `<IP_VPS_HOSTINGER>` (contoh: `179.61.241.11`)
   - **TTL**: 3600 (default)
5. Buat **CNAME Record** (opsional):
   - **Name**: `www`
   - **Type**: CNAME
   - **Value**: `busparwis.my.id`
6. **Simpan** — propagasi DNS 1-24 jam (biasanya 5-30 menit)

### Langkah 2: Upload & Jalankan Deployment Script

1. **SSH ke VPS Hostinger**:
   ```bash
   ssh root@<IP_VPS_HOSTINGER>
   ```

2. **Upload script deploy** dari komputer lokal:
   ```bash
   # Dari komputer lokal
   scp /home/endrafs/perkuliahan/bus-parwis/deploy.sh root@<IP_VPS>:/root/
   
   # Atau salin dari repo
   scp /home/endrafs/perkuliahan/bus-parwis/nginx/production.conf root@<IP_VPS>:/root/
   ```

3. **Jalankan script deployment** di VPS:
   ```bash
   chmod +x /root/deploy.sh
   ./root/deploy.sh
   ```

4. **Ikuti interaksi**:
   - Script akan bertanya konfirmasi untuk seed database (jawab `Y` untuk seeding awal)
   - Script akan bertanya apakah domain sudah diarahkan (jawab `Y` jika sudah propagasi)

### Langkah 3: Verifikasi

```bash
# Cek apakah website bisa diakses
curl -I https://busparwis.my.id

# Cek log Nginx
tail -f /var/log/nginx/busparwis-error.log

# Cek log Laravel
tail -f /var/www/busparwis/src/storage/logs/laravel.log
```

Buka browser: **https://busparwis.my.id**
Panel admin: **https://busparwis.my.id/admin**

---

## 🚀 Metode 2: Auto-Deploy via GitHub Actions

### Setup Secrets di GitHub

1. Buka repo GitHub: **https://github.com/Endrafs/bus-parwis**
2. **Settings** → **Secrets and variables** → **Actions** → **New repository secret**
3. Tambahkan secrets berikut:

| Secret Name | Value |
|------------|-------|
| `SSH_HOST` | IP VPS Hostinger (contoh: `179.61.241.11`) |
| `SSH_USERNAME` | `root` |
| `SSH_PRIVATE_KEY` | Private key SSH (bisa dari `~/.ssh/id_rsa`) |
| `DB_PASSWORD` | Password database MariaDB |

### Cara Mendapatkan SSH Private Key

```bash
# Di komputer lokal, generate SSH key (jika belum punya)
ssh-keygen -t ed25519 -C "deploy-busparwis"

# Copy public key ke VPS
ssh-copy-id root@<IP_VPS_HOSTINGER>

# Copy private key content
cat ~/.ssh/id_ed25519
# Copy output-nya dan paste ke GitHub secret SSH_PRIVATE_KEY
```

### Trigger Deploy

- **Push ke branch `main`** → auto-deploy
- Atau **Manual trigger**: GitHub → Actions → Deploy to Hostinger VPS → Run workflow

---

## 📂 Struktur di VPS

```
/var/www/busparwis/
├── src/                      # Laravel source code
│   ├── public/               # Document root (Nginx)
│   ├── .env                 # Environment variables
│   ├── storage/             # Storage (logs, cache, uploads)
│   └── ...
├── deploy.sh                 # Deployment script
└── nginx/
    └── production.conf       # Nginx config template
```

---

## 🔐 Informasi Penting Setelah Deployment

| Info | Lokasi |
|------|--------|
| **Database Password** | `/root/.busparwis_db_credentials` |
| **Laravel Log** | `/var/www/busparwis/src/storage/logs/laravel.log` |
| **Nginx Log** | `/var/log/nginx/busparwis-*.log` |
| **Queue Worker** | `supervisorctl status busparwis-worker:*` |

---

## 🛠️ Perawatan Rutin

### Backup Database
```bash
# Backup
mysqldump -u root -p bus_parwis > /root/backup/busparwis-$(date +%Y%m%d).sql

# Restore
mysql -u root -p bus_parwis < /root/backup/busparwis-20241201.sql
```

### Update Aplikasi
```bash
cd /var/www/busparwis/src
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize
php artisan view:cache
php artisan route:cache
php artisan config:cache
npm ci && npm run build
chown -R www-data:www-data .
chmod -R 775 storage bootstrap/cache
```

### Cek Status Services
```bash
systemctl status nginx
systemctl status php8.3-fpm
systemctl status mariadb
supervisorctl status
```

---

## ⚠️ Troubleshooting

| Masalah | Solusi |
|---------|--------|
| **Website error 502** | Restart PHP: `systemctl restart php8.3-fpm` |
| **Website error 403** | Cek permission: `chmod -R 775 /var/www/busparwis/src/storage` |
| **Cannot connect DB** | Cek MariaDB: `systemctl status mariadb` |
| **SSL not working** | Renew: `certbot renew` |
| **Upload file terlalu besar** | Cek `client_max_body_size` di Nginx config |
| **Queue tidak jalan** | `supervisorctl restart busparwis-worker:*` |

---

## 📱 Info Setelah Deploy

| Akses | URL |
|-------|-----|
| **Website** | https://busparwis.my.id |
| **Admin Panel** | https://busparwis.my.id/admin |
| **Halaman Booking** | https://busparwis.my.id/bookings |
| **Tentang Kami** | https://busparwis.my.id/about |
| **Kontak** | https://busparwis.my.id/contact |

---

## 📞 Butuh Bantuan?

Jika ada kendala, jalankan diagnostic:
```bash
# Cek koneksi
curl -I https://busparwis.my.id

# Cek error log terbaru
tail -50 /var/www/busparwis/src/storage/logs/laravel.log

# Cek disk usage
df -h

# Cek memory usage
free -m
```
