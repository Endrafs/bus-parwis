# 🚌 PHD Trans — Sistem Penyewaan Bus Pariwisata Premium

Aplikasi web untuk manajemen penyewaan bus pariwisata berbasis **Laravel 12** + **Filament 3**.

> **🎨 Desain**: Template Brivon (Photography Studio) — dark theme premium (#0A0A0C) dengan aksen **ungu** (#7C3AED) khas PHD Trans.

## 📋 Fitur Utama

### 🧑‍💼 Untuk Pelanggan (Public Frontend)
- **Landing Page** — Jelajahi armada bus yang tersedia dengan foto, fasilitas, dan harga
- **Detail Bus** — Lihat spesifikasi lengkap & fasilitas setiap bus
- **Register/Login** — Autentikasi pelanggan dengan nomor WhatsApp
- **Booking** — Pilih bus, tanggal, tujuan; auto-hitung total biaya
- **Cek Ketersediaan** — Sistem mencegah double-booking di tanggal yang sama
- **Upload Pembayaran** — Upload bukti transfer (DP/Pelunasan)
- **Riwayat Booking** — Pantau status booking dengan progress bar

### 🔧 Untuk Admin (Filament Panel)
- **Dashboard** — 6 widget real-time (statistik, grafik, kalender booking)
- **Manajemen Bus** — CRUD armada, fasilitas, foto, harga
- **Manajemen Booking** — Konfirmasi, mulai perjalanan, selesaikan, batalkan
- **Verifikasi Pembayaran** — Approve/reject bukti transfer
- **Laporan** — Pendapatan bulanan, statistik armada, utilisasi bus
- **Pengaturan Website** — Nama, logo, deskripsi, kontak, rekening bank

---

## 🏗️ Tech Stack

| Layer | Teknologi |
|-------|-----------|
| Backend | Laravel 12, PHP 8.2+ |
| Admin Panel | Filament 3 |
| Frontend | Blade, Tailwind CSS, Alpine.js |
| Database | MariaDB 10.11 |
| Web Server | Nginx |
| Container | Docker (Docker Compose) |
| Testing | Pest / PHPUnit (47 tests, 103 assertions) |

---

## 🚀 Cara Menjalankan (Development)

### Prasyarat
- Docker & Docker Compose
- Git

### Langkah-langkah

```bash
# 1. Clone repository
git clone <repo-url>
cd bus-parwis

# 2. Jalankan Docker containers
docker compose up -d

# 3. Install dependencies
docker exec bus-parwis_php composer install
docker exec bus-parwis_php npm install

# 4. Build assets
docker exec bus-parwis_php npm run build

# 5. Setup database
docker exec bus-parwis_php php artisan migrate
docker exec bus-parwis_php php artisan db:seed

# 6. Buka browser
# https://bus-parwis.test
```

### Akun Default

| Role | Email | Password |
|------|-------|----------|
| Admin | (dari UserSeeder) | `password` |

---

## 🧪 Testing

```bash
# Jalankan semua test
docker exec bus-parwis_php php artisan test

# Hasil: 47 passed, 0 failed, 103 assertions
```

---

## 📁 Struktur Proyek

```
bus-parwis/
├── docker-compose.yml          # Konfigurasi Docker (PHP, Nginx, MariaDB)
├── php/                        # Custom PHP Dockerfile
├── nginx/                      # Nginx config + SSL
├── db/                         # Database data + config
└── src/                        # Laravel source code
    ├── app/
    │   ├── Http/Controllers/   # BusController, BookingController, PaymentController
    │   ├── Models/             # User, Bus, Booking, Payment, BusFacility, WebsiteSetting
    │   ├── Filament/           # Admin panel (Resources, Pages, Widgets)
    │   └── Providers/          # ViewServiceProvider
    ├── database/
    │   ├── migrations/         # 15 migrations
    │   ├── factories/          # UserFactory, BusFactory
    │   └── seeders/            # Role, User, Bus, BusFacility, WebsiteSetting
    ├── resources/views/
    │   ├── buses/              # Landing page & detail bus
    │   ├── bookings/           # Form booking, list, detail
    │   ├── payments/           # Upload pembayaran
    │   └── auth/               # Login, register (Breeze)
    ├── routes/
    │   ├── web.php             # 20+ public + auth routes
    │   └── auth.php            # Breeze auth routes
    └── tests/
        ├── Unit/BusTest.php    # 10 unit tests
        └── Feature/            # 37 feature tests
```

---

## 🔄 Flow Bisnis

```
Pelanggan Register/Login
    ↓
Pilih Bus → Cek Ketersediaan
    ↓
Isi Form Booking (tanggal, tujuan) → Auto-hitung harga
    ↓
Status: Pending
    ↓
Upload Pembayaran (DP/Pelunasan)
    ↓
Status: Menunggu Verifikasi
    ↓
Admin Verifikasi → Approve / Reject
    ↓
Status: Dikonfirmasi
    ↓
Admin → Mulai Berjalan
    ↓
Status: Berjalan
    ↓
Admin → Selesaikan
    ↓
Status: Selesai
```

---

## 📊 Database Schema

| Tabel | Field Utama |
|-------|-------------|
| `users` | name, email, nomor_whatsapp, password |
| `buses` | nama_bus, kategori_bus, tipe_bus, kapasitas, harga_sewa, foto, status |
| `bus_facilities` | nama_fasilitas, deskripsi, status |
| `bus_bus_facility` | (pivot) bus_id, bus_facility_id |
| `bookings` | user_id, bus_id, kode_booking, tanggal, tujuan, total_harga, status |
| `payments` | booking_id, jenis_pembayaran, nominal, bukti_transfer, status_verifikasi |
| `website_settings` | nama_website, logo, deskripsi, nomor_whatsapp, rekening_bank |

---

## 📝 License

MIT
