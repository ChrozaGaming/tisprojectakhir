# 📦 Sistem Integrasi Website Inventori & E-Commerce

Proyek ini merupakan implementasi **Integrasi Sistem** antara dua website:
- 🔧 **Website A**: Sistem Manajemen Inventori (Admin)
- 🛍️ **Website B**: Platform E-Commerce (Pelanggan)
- 🌐 **Middleware REST API**: Laravel Lumen REST API sebagai jembatan komunikasi data

## 🧩 Arsitektur Sistem

```
+-------------+      +---------------------+      +-------------+
|  Website A  | <--> | Laravel/Lumen REST  | <--> |  Website B  |
| (Inventori) |      |        API          |      | (E-Commerce)|
+-------------+      +---------------------+      +-------------+
       ^
       |
+------------------+
|  Database Central |
+------------------+
```

## 🚀 Teknologi yang Digunakan
- **Frontend**: Laravel Blade (SPA untuk Website A & B)
- **Backend**: Laravel Lumen REST API (PHP)
- **Database**: MySQL (Database Central)
- **API Client**: Axios (Frontend Request)
- **Tools**: Composer, Artisan CLI

## 🔗 API Dokumentasi
Dokumentasi lengkap tersedia di `docs/api-doc.md`, meliputi:
- Manajemen Produk (GET, POST, PUT, DELETE)
- Update Stok dan Riwayat Pergerakan
- Endpoint pencarian, paginasi, dan filter

## 👥 Anggota Kelompok

| Nama                          | NIM (opsional) |
|-------------------------------|----------------|
| 👨‍💻 Alfaril Dzaky Praptana      |                |
| 👨‍💻 Azriel Maulani Rahman       |                |
| 👨‍💻 Ega Yurcel Satriaji         |                |
| 👨‍💻 Hilmy Raihan Alkindy       |                |
| 👨‍💻 Pramudhia Ananda Kresna    |                |
| 👩‍💻 Naura Ayumi Qanita         |                |

## 👨‍🏫 Dosen Pengampu

**Buce Trias Hanggara, S.Kom., M.Kom.**

## 📂 Struktur Direktori

```
integration-system/
├── central-api/       # REST API Laravel Lumen
├── website-a/         # Frontend Inventori (Admin)
└── website-b/         # Frontend E-Commerce (User)
```

## ✅ Cara Menjalankan
1. Jalankan database MySQL dan buat database `database_central`
2. Jalankan `central-api`:
   ```bash
   php -S localhost:8000 -t public
   ```
3. Jalankan `website-a`:
   ```bash
   php artisan serve --port=8001
   ```
4. Jalankan `website-b`:
   ```bash
   php artisan serve --port=8002
   ```

---

📘 Proyek ini dibuat untuk memenuhi tugas **Teknologi Integrasi Sistem**.
