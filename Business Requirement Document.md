# Business Requirement Document (BRD)
## Sistem Penyewaan Bus Pariwisata — PHD Trans (formerly Bus Parwis)

---

## 1. Ringkasan Eksekutif

PHD Trans (sebelumnya bernama Bus Parwis) adalah aplikasi web untuk mengelola penyewaan bus pariwisata premium. Sistem ini memungkinkan pelanggan memilih armada bus, melakukan booking, dan mengunggah bukti pembayaran. Admin dapat mengelola armada, memverifikasi pembayaran, mengelola konten website dinamis, dan memantau laporan pendapatan serta statistik armada melalui dashboard berbasis Filament 3.

---

## 2. Latar Belakang

### 2.1 Konteks
Perusahaan penyewaan bus pariwisata PHD Trans (berdiri sejak 2015) membutuhkan sistem digital untuk mengelola operasional, mengurangi kesalahan pencatatan manual, dan memberikan pengalaman booking yang mudah bagi pelanggan dengan tampilan premium.

### 2.2 Permasalahan
- Pencatatan jadwal manual rentan kesalahan dan double-booking
- Pelanggan kesulitan melihat ketersediaan armada
- Proses verifikasi pembayaran tidak terstruktur
- Pemilik usaha sulit memonitor perkembangan bisnis
- Konten website statis dan sulit diperbarui tanpa developer
- Biaya perjalanan tambahan (tol, solar, parkir) tidak terhitung secara sistematis

### 2.3 Solusi (✅ Terselesaikan)
1. ✅ **Sistem booking digital** — pelanggan dapat memesan bus kapan saja dengan auto-kalkulasi harga
2. ✅ **Mengurangi Kesalahan Pencatatan Jadwal** — validasi otomatis ketersediaan (anti double-booking)
3. ✅ **Mempermudah Pengelolaan Armada** — CRUD bus + fasilitas + foto
4. ✅ **Meningkatkan Efisiensi Operasional** — workflow booking otomatis (Pending → Verifikasi → Dikonfirmasi → Berjalan → Selesai)
5. ✅ **Membantu Pemilik Usaha Memonitor Bisnis** — dashboard real-time + laporan pendapatan + statistik armada
6. ✅ **Konten Website Dinamis** — kelola hero, about, services, FAQ, contact via panel admin
7. ✅ **Perhitungan Biaya Transparan** — harga sewa harian + biaya tol, solar, tips crew, parkir, dan biaya tujuan

---

## 3. Tujuan Bisnis (✅ Tercapai)
- Menyediakan platform booking bus online premium untuk pelanggan
- Memudahkan admin mengelola armada, konten website, dan verifikasi pembayaran
- Memberikan laporan pendapatan bulanan dan statistik utilisasi armada kepada pemilik
- Menampilkan citra profesional melalui desain dark theme premium dengan brand PHD Trans

---

## 4. Ruang Lingkup (✅ Tercakup)

### Fitur Pelanggan (Public Frontend)
- ✅ **Landing page** dengan daftar armada, hero section, galeri, CTA
- ✅ **Halaman Tentang (About)** — cerita perusahaan, nilai-nilai, statistik
- ✅ **Halaman Layanan (Services)** — tipe armada, cara sewa, FAQ
- ✅ **Halaman Kontak (Contact)** — form pesan, channel komunikasi, info kontak
- ✅ **Detail Bus** — spesifikasi, fasilitas, harga sewa per hari
- ✅ **Register/Login** — autentikasi dengan nama + email + nomor WhatsApp
- ✅ **Form booking** — pilih bus, tanggal berangkat & kembali, tujuan (auto-kalkulasi total harga sewa + biaya tambahan)
- ✅ **Validasi ketersediaan** — anti double-booking (mengecek overlap tanggal berangkat & kembali)
- ✅ **Upload bukti pembayaran** — DP (50%) atau Pelunasan, maks 2MB (JPG/PNG)
- ✅ **Riwayat & detail booking** — dengan progress status dan invoice (jika lunas)

### Fitur Admin (Filament Panel)
- ✅ **Dashboard** — 6 widget real-time: armada aktif, booking aktif, pembayaran menunggu, total pendapatan, grafik booking, grafik revenue, kalender booking, pending payments, latest bookings, latest access logs
- ✅ **Manajemen Bus (CRUD)** — nama, kategori, tipe, kapasitas, harga sewa, foto, status aktif/nonaktif
- ✅ **Manajemen Booking** — CRUD + workflow: konfirmasi, mulai berjalan, selesaikan, batalkan
- ✅ **Verifikasi Pembayaran** — approve/reject dengan badge status, auto-update status booking
- ✅ **Manajemen Fasilitas Bus (CRUD)** — daftar fasilitas yang dapat dipasangkan ke bus (many-to-many)
- ✅ **Manajemen Harga Tujuan (CRUD)** — daftar destinasi wisata dengan biaya masing-masing
- ✅ **Manajemen Konten Halaman (CRUD)** — hero, about, services, contact sections dengan rich text editor, media (gambar/video/youtube), metadata, sort order, toggle aktif/nonaktif
- ✅ **Manajemen Media Items** — galeri gambar & video per section
- ✅ **Laporan & Statistik** — total pendapatan, total booking, armada aktif, statistik per bus (jumlah booking & total pendapatan), grafik revenue bulanan
- ✅ **Pengaturan Website** — nama website, logo, deskripsi, email, alamat, nomor WhatsApp, info rekening bank, biaya default (tol, solar, tips crew, parkir)
- ✅ **Manajemen User (CRUD)** — daftar pelanggan dengan role
- ✅ **Activity Log** — catatan aktivitas admin
- ✅ **Role & Permission** — Spatie Laravel Permission + Filament Shield
- ✅ **Pengaturan Tema** — dark/light mode toggle

---

## 5. Stakeholder
- **Pemilik Usaha (Super Admin)** — Administrator utama, memonitor bisnis, mengelola pengaturan website & user
- **Admin** — Mengelola armada, booking, verifikasi pembayaran, konten website
- **Pelanggan** — Melakukan booking bus, upload pembayaran, melihat riwayat

---

## 6. Persyaratan Fungsional (✅ Tercapai)
- ✅ Pelanggan memilih unit bus sesuai kebutuhan (kategori, tipe, kapasitas, harga)
- ✅ Pelanggan mengisi form booking dengan tanggal berangkat, tanggal kembali, tujuan, catatan
- ✅ Sistem otomatis menghitung jumlah hari & total harga (harga_sewa × jumlah_hari + biaya_tol + biaya_solar + tips_crew + biaya_parkir + biaya_tujuan)
- ✅ Pencegahan double-booking di rentang tanggal yang sama (mengecek tanggal_berangkat & tanggal_kembali)
- ✅ Pembayaran via transfer bank (DP atau Pelunasan) dengan upload bukti transfer
- ✅ Admin verifikasi bukti pembayaran (approve/reject dengan auto-update status booking)
- ✅ Booking auto-berstatus Dikonfirmasi jika total pembayaran disetujui ≥ total harga
- ✅ Armada yang dipesan tidak dapat digunakan untuk pemesanan lain di rentang yang sama
- ✅ Kode booking otomatis: BUS-YYYYMMDD-NNNN
- ✅ Invoice hanya tersedia untuk booking dengan status lunas
- ✅ Pemilik usaha sebagai administrator utama dengan role super_admin
- ✅ Halaman website dinamis dikelola melalui panel admin (tanpa perlu koding)
- ✅ Kontak form dengan validasi (nama, email/no WA, pesan)

---

## 7. Persyaratan Non-Fungsional (✅ Tercapai)

| Kategori | Teknologi | Status |
|----------|-----------|--------|
| Back-end | Laravel 12 (PHP 8.2+) | ✅ |
| Admin Panel | Filament 3 (SPA Mode) | ✅ |
| Database | MariaDB 10.11 / MySQL | ✅ |
| Front-end | Blade, HTML, Tailwind CSS, Alpine.js | ✅ |
| Template Desain | Brivon — Dark Theme (#0A0A0C), Aksen Ungu (#7C3AED) | ✅ |
| Font | Montserrat | ✅ |
| Web Server | Nginx (with SSL) | ✅ |
| Containerization | Docker & Docker Compose | ✅ |
| Version Control | Git dan GitHub | ✅ |
| Testing | Pest/PHPUnit (47 tests, 103 assertions) | ✅ |
| Development Env | WSL, VS Code | ✅ |
| Role Management | Spatie Laravel Permission + Filament Shield | ✅ |
| Activity Logging | Spatie Laravel Activitylog | ✅ |
| Tema | Hasnayeen Themes (Light/Dark mode toggle) | ✅ |
| Auth UI | Laravel Breeze + AuthUI Enhancer | ✅ |

---

## 8. Arsitektur Database

### Entity Relationship

| Tabel | Field Utama | Relasi |
|-------|-------------|--------|
| `users` | name, email, nomor_whatsapp, password, avatar_url | HasMany → bookings |
| `buses` | nama_bus, kategori_bus, tipe_bus, kapasitas, harga_sewa, foto, status | BelongsToMany → facilities; HasMany → bookings |
| `bus_facilities` | nama_fasilitas, deskripsi, status | BelongsToMany → buses (via bus_bus_facility) |
| `bus_bus_facility` | bus_id, bus_facility_id | Pivot table |
| `bookings` | user_id, bus_id, kode_booking, tanggal_berangkat, tanggal_kembali, tujuan, jumlah_hari, total_harga, harga_sewa_unit, biaya_tol, biaya_solar, tips_crew, biaya_parkir, biaya_tujuan, status, catatan | BelongsTo → user, bus; HasMany → payments |
| `payments` | booking_id, jenis_pembayaran (DP/Pelunasan), nominal, bukti_transfer, status_verifikasi (Menunggu/Disetujui/Ditolak), tanggal_bayar, catatan | BelongsTo → booking |
| `website_settings` | nama_website, logo, deskripsi, nomor_whatsapp, email, alamat, rekening_bank, biaya_tol_default, biaya_solar_default, tips_crew_default, biaya_parkir_default | Singleton |
| `destination_prices` | nama_tujuan, harga | — |
| `page_sections` | page (home/about/services/contact), section_key, title, subtitle, description, media_type, media_path, media_url, metadata (JSON), is_active, sort_order | HasMany → media_items |
| `media_items` | page_section_id, media_type, file_path, youtube_url, caption, sort_order | BelongsTo → page_section |

### Booking Status Flow
```
Pending → (upload payment) → Menunggu Verifikasi → (admin approve) → Dikonfirmasi
                                                                          ↓
                                                               (admin: mulai) → Berjalan
                                                                                   ↓
                                                                          (admin: selesai) → Selesai

Any status (except Selesai/Dibatalkan) → (admin: batalkan) → Dibatalkan
```

---

## 9. Status Proyek

**Status: ~95% Selesai**

| Sprint | Fokus | Status |
|--------|-------|--------|
| Sprint 1 | Auth Publik + Landing Page | ✅ |
| Sprint 2 | Booking Flow (form, validasi, auto-kalkulasi) | ✅ |
| Sprint 3 | Payment Flow (upload, verifikasi, approve/reject) | ✅ |
| Sprint 4 | Dashboard & Laporan (widgets, statistik, grafik) | ✅ |
| Sprint 5 | Website Settings & Konten Dinamis (page sections, media) | ✅ |
| Sprint 6 | Harga Tujuan & Biaya Default (destination prices, cost columns) | ✅ |
| Sprint 7 | Testing & Polish (47 tests, 103 assertions) | ✅ |

---

## 10. Test Coverage
- **47 tests, 103 assertions, 0 failures**

### Unit Tests (src/tests/Unit/BusTest.php)
- ✅ Bus has correct fillable attributes
- ✅ Bus can be created with valid data
- ✅ Bus isAvailable returns true when no bookings exist
- ✅ Bus isAvailable returns false when overlapping booking exists
- ✅ Bus isAvailable ignores cancelled bookings
- ✅ Bus isAvailable returns true when bus is inactive (status check is separate)
- ✅ Bus has facilities relationship
- ✅ Bus has bookings relationship

### Feature Tests (src/tests/Feature/BusParwisTest.php)
- ✅ Landing page loads successfully
- ✅ Bus detail page loads successfully
- ✅ Bus detail page returns 404 for non-existent bus
- ✅ Register page loads
- ✅ Login page loads
- ✅ User can register (with nomor_whatsapp)
- ✅ Authenticated user can access booking form
- ✅ Unauthenticated user cannot access booking form (redirect to login)
- ✅ User can create booking
- ✅ Double booking is prevented (validation error)
- ✅ User can view their bookings
- ✅ User cannot view other user's booking (404)
- ✅ Booking auto-generates kode_booking (BUS-YYYYMMDD-NNNN format)
- ✅ Non-admin user cannot access admin panel (403)
- ✅ Additional auth tests (password reset, email verification, etc.)

---

## 11. Teknologi & Tools

| Komponen | Detail |
|----------|--------|
| **Framework** | Laravel 12 |
| **Admin Panel** | Filament 3 (Single Page Application) |
| **PHP Version** | 8.2+ |
| **Database** | MariaDB 10.11 |
| **Frontend** | Blade Templates, Tailwind CSS, Alpine.js |
| **Design Template** | Brivon 1.0.0 (Photography Studio inspired) |
| **Web Server** | Nginx |
| **Container** | Docker + Docker Compose |
| **Auth Scaffolding** | Laravel Breeze |
| **Roles & Permissions** | Spatie Laravel Permission + Filament Shield |
| **Activity Log** | Spatie Laravel Activitylog |
| **Themes** | Hasnayeen Themes |
| **File Uploads** | Laravel Storage (public disk) |
| **Testing** | Pest PHP / PHPUnit |
| **Version Control** | Git + GitHub |
| **IDE** | VS Code with WSL |

---

## 12. Flow Bisnis

```
Pelanggan Register/Login
    ↓
Jelajahi Armada di Landing Page
    ↓
Pilih Bus → Lihat Detail & Fasilitas
    ↓
Klik "Pesan Sekarang" → Form Booking
    ↓
Pilih Tanggal Berangkat, Tanggal Kembali, Tujuan
    ↓
Sistem Auto-Hitung: (harga_sewa × jumlah_hari) + tol + solar + tips + parkir + biaya_tujuan
    ↓
Submit Booking → Status: Pending
    ↓
Upload Pembayaran (Minimal DP, bisa langsung Pelunasan)
    ↓
Status: Menunggu Verifikasi
    ↓
Admin Cek Bukti Transfer → Approve / Reject
    ↓
  Approve → Jika total dibayar ≥ total_harga → Status: Dikonfirmasi
            → Jika masih kurang → Status: Menunggu Verifikasi (bisa upload lagi)
  Reject  → Status: Kembali ke Pending
    ↓
Admin → Mulai Berjalan → Status: Berjalan
    ↓
Admin → Selesaikan → Status: Selesai
    ↓
Pelanggan dapat download Invoice (jika lunas)
```

---

## 13. Informasi Brand & Desain

- **Nama Platform:** PHD Trans
- **Tagline:** "Satu armada, tak terbatas petualangan."
- **Template:** Brivon 1.0.0 (Photography Studio)
- **Skema Warna:**
  - Latar belakang: #0A0A0C (dark theme)
  - Aksen: #7C3AED (ungu)
  - Font: Montserrat
- **Tahun Berdiri:** 2015
- **Armada:** 50+ unit (Big Bus, Big Bus MHD, Medium Bus, Travel Car)
