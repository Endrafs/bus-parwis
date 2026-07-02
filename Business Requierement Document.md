# Business Requirement Document (BRD)
## Sistem Penyewaan Bus Pariwisata — Bus Parwis

---

## 1. Ringkasan Eksekutif

Bus Parwis adalah aplikasi web untuk mengelola penyewaan bus pariwisata. Sistem ini memungkinkan pelanggan memilih armada bus, melakukan booking, dan mengunggah bukti pembayaran. Admin dapat mengelola armada, memverifikasi pembayaran, dan memantau laporan pendapatan.

---

## 2. Latar Belakang

### 2.1 Konteks
Perusahaan penyewaan bus pariwisata membutuhkan sistem digital untuk mengelola operasional, mengurangi kesalahan pencatatan manual, dan memberikan pengalaman booking yang mudah bagi pelanggan.

### 2.2 Permasalahan
- Pencatatan jadwal manual rentan kesalahan dan double-booking
- Pelanggan kesulitan melihat ketersediaan armada
- Proses verifikasi pembayaran tidak terstruktur
- Pemilik usaha sulit memonitor perkembangan bisnis

### 2.3 Solusi (✅ Terselesaikan)
1. ✅ **Sistem booking digital** — pelanggan dapat memesan bus kapan saja
2. ✅ **Mengurangi Kesalahan Pencatatan Jadwal** — validasi otomatis ketersediaan
3. ✅ **Mempermudah Pengelolaan Armada** — CRUD bus + fasilitas
4. ✅ **Meningkatkan Efisiensi Operasional** — workflow booking otomatis
5. ✅ **Membantu Pemilik Usaha Memonitor Bisnis** — dashboard + laporan

---

## 3. Tujuan Bisnis (✅ Tercapai)
- Menyediakan platform booking bus online untuk pelanggan
- Memudahkan admin mengelola armada dan verifikasi pembayaran
- Memberikan laporan pendapatan dan statistik armada kepada pemilik

---

## 4. Ruang Lingkup (✅ Tercakup)

### Fitur Pelanggan
- ✅ Landing page dengan daftar bus
- ✅ Halaman detail bus dengan fasilitas
- ✅ Register/Login (dengan nomor WhatsApp)
- ✅ Form booking dengan auto-kalkulasi harga
- ✅ Validasi ketersediaan (anti double-booking)
- ✅ Upload bukti pembayaran (DP/Pelunasan)
- ✅ Riwayat & detail booking dengan progress status

### Fitur Admin
- ✅ Dashboard dengan 6 widget (statistik, grafik, kalender)
- ✅ Manajemen Bus (CRUD + fasilitas)
- ✅ Manajemen Booking (konfirmasi, mulai, selesai, batalkan)
- ✅ Verifikasi Pembayaran (approve/reject)
- ✅ Laporan pendapatan bulanan
- ✅ Statistik utilisasi armada
- ✅ Pengaturan website (nama, logo, kontak, rekening)

---

## 5. Stakeholder
- **Pemilik Usaha** — Administrator utama, memonitor bisnis
- **Admin** — Mengelola armada & verifikasi pembayaran
- **Pelanggan** — Melakukan booking bus

---

## 6. Persyaratan Fungsional (✅ Tercapai)
- ✅ Pelanggan memilih unit bus sesuai kebutuhan
- ✅ Pelanggan mengisi form booking dengan tanggal & tujuan
- ✅ Sistem otomatis menghitung jumlah hari & total harga
- ✅ Pencegahan double-booking di rentang tanggal yang sama
- ✅ Pembayaran via transfer bank (DP atau Pelunasan)
- ✅ Admin verifikasi bukti pembayaran
- ✅ Armada yang dipesan tidak dapat digunakan untuk pemesanan lain
- ✅ Pemilik usaha sebagai administrator utama

---

## 7. Persyaratan Non-Fungsional (✅ Tercapai)

| Kategori | Teknologi | Status |
|----------|-----------|--------|
| Back-end | Laravel 12 | ✅ |
| Panel/Admin UI | Filament 3 | ✅ |
| Database | MariaDB / MySQL | ✅ |
| Front-end | Blade, HTML, Tailwind CSS, Alpine.js | ✅ |
| Web Server | Nginx | ✅ |
| Containerization | Docker | ✅ |
| Version Control | Git dan GitHub | ✅ |
| Testing | Pest/PHPUnit (47 tests) | ✅ |
| Development Env | WSL, VS Code | ✅ |

---

## 8. Status Proyek

**Status: ~95% Selesai**

| Sprint | Fokus | Status |
|--------|-------|--------|
| Sprint 1 | Auth Publik + Landing Page | ✅ |
| Sprint 2 | Booking Flow | ✅ |
| Sprint 3 | Payment Flow | ✅ |
| Sprint 4 | Dashboard & Laporan | ✅ |
| Sprint 5 | Website Settings & Konten | ✅ |
| Sprint 6 | Testing & Polish | ✅ |

---

## 9. Test Coverage
- **47 tests, 103 assertions, 0 failures**
- Unit tests: Bus model, isAvailable logic
- Feature tests: Auth, Booking flow, Double-booking, Admin access
