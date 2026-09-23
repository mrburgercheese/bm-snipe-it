# Dokumentasi Kustomisasi Snipe-IT: Notifikasi Email & Telegram serta Tampilan (Views) & Konfigurasi Web

> **Server**: `bmsnipeit@172.16.152.45` (bmwhm)  
> **Path Aplikasi**: `/home/bmsnipeit/public_html`  
> **PHP**: 8.4.20  
> **Tanggal Pembaruan Dokumen**: 2026-06-11  
> **Status**: Production — Tested & Working  

---

## Daftar Perubahan

| No | Perubahan / Modifikasi | File yang Dimodifikasi | Status |
|----|------------------------|------------------------|--------|
| 1 | Fix notif email — locale null crash | `app/Listeners/CheckoutableListener.php` | Done |
| 2 | Notifikasi Telegram saat Check-Out Aset | `app/Listeners/CheckoutableListener.php` | Done |
| 3 | Notifikasi Telegram saat Check-In Aset | `app/Listeners/CheckoutableListener.php` | Done |
| 4 | Notifikasi Telegram saat Maintenance ditambah | `app/Observers/MaintenanceObserver.php` | Done |
| 5 | Notifikasi Telegram saat Maintenance dihapus | `app/Observers/MaintenanceObserver.php` | Done |
| 6 | Widget Kustom di Halaman Utama (Dashboard) | `resources/views/dashboard.blade.php` | Done |
| 7 | Himbauan Tiket ID & Panduan Kategori Maintenance | `resources/views/maintenances/index.blade.php` | Done |
| 8 | Form Cetak Tanda Terima (Signature Multi-box & Disclaimer) | `resources/views/users/print.blade.php` | Done |
| 9 | Konfigurasi Rewrite URL & PHP 8.4 cPanel | `.htaccess` | Done |
| 10 | Konfigurasi variabel Telegram di `.env` | `.env` | Done |
| 11 | Fix Notifikasi Telegram Maintenance — Mode HTML & Sanitasi Karakter | `app/Observers/MaintenanceObserver.php` | Done |
| 12 | Halaman & Fitur Bulk Checkout CCTV (Lisensi) | `routes/web.php`, `resources/views/custom/bulk_checkout_license.blade.php`, `resources/views/layouts/default.blade.php` | Done |
| 13 | Halaman & Fitur Bulk Checkin CCTV (Lisensi) | `routes/web.php`, `resources/views/custom/bulk_checkin_license.blade.php`, `resources/views/layouts/default.blade.php` | Done |
| 14 | Ikon Kustom Notifikasi Telegram (License, Accessories, Consumables) | `app/Listeners/CheckoutableListener.php` | Done |

---

## Konfigurasi .env

Tambahkan blok berikut di bagian **akhir** file `.env` untuk mengaktifkan notifikasi Telegram:

```env
# --------------------------------------------
# TELEGRAM NOTIFICATION CONFIGURATION
# --------------------------------------------
TELEGRAM_NOTIFICATION_ENABLED=true
TELEGRAM_BOT_TOKEN="ISI_TOKEN_BOT_TELEGRAM"
TELEGRAM_CHAT_ID="ISI_CHAT_ID_TUJUAN"
```

**Bot yang digunakan**: `@bestarimulia_bot`  
**Cara mendapatkan token**: Buat bot baru via @BotFather di Telegram  
**Cara mendapatkan Chat ID**: Tambahkan bot ke grup/channel, lalu akses `https://api.telegram.org/bot{TOKEN}/getUpdates`  

Setelah mengubah `.env`, jalankan:
```bash
cd /home/bmsnipeit/public_html
php artisan config:clear
```

---

## Perubahan File 1: CheckoutableListener.php

**Path**: `app/Listeners/CheckoutableListener.php`

### Fix A: Locale Null Crash pada Email Notifikasi
Email notifikasi gagal dikirim karena `$notifiable->locale` bisa bernilai `null`. Diperbaiki dengan null-safe operator dan fallback ke default locale.
```diff
- $toMail = (clone $mailable)->locale($notifiable->locale);
+ $toMail = (clone $mailable)->locale($notifiable?->locale ?? Setting::getSettings()->locale);
```

### Fix B: Early Return Bypass untuk Telegram
Kondisi early return diperluas agar proses notifikasi Telegram tetap berjalan meski email/webhook dinonaktifkan.
```diff
- if (! $shouldSendEmailToUser && ! $shouldSendEmailToAlertAddress && ! $shouldSendWebhookNotification) {
+ if (! $shouldSendEmailToUser && ! $shouldSendEmailToAlertAddress && ! $shouldSendWebhookNotification && ! env('TELEGRAM_NOTIFICATION_ENABLED', false)) {
```

### Tambahan C: Blok Telegram di onCheckedOut()
Ditambahkan setelah penutup blok `if ($shouldSendWebhookNotification)` di `onCheckedOut()`:
[Lihat `CheckoutableListener.php` untuk source code lengkap]

### Tambahan D: Blok Telegram di onCheckedIn()
Ditambahkan setelah penutup blok `if ($shouldSendWebhookNotification)` di `onCheckedIn()`:
[Lihat `CheckoutableListener.php` untuk source code lengkap]

---

## Perubahan File 2: MaintenanceObserver.php

**Path**: `app/Observers/MaintenanceObserver.php`

File ini diganti sepenuhnya untuk menyematkan trigger notifikasi Telegram saat data maintenance dibuat (created) dan dihapus (deleting) secara background (non-blocking menggunakan `curl` via `exec` async).
[Lihat `MaintenanceObserver.php` untuk source code lengkap]

> [!IMPORTANT]
> **Pembaruan 25 Juni 2026**:
> Format pesan Telegram diubah dari `parse_mode=Markdown` menjadi `parse_mode=HTML` dan semua variabel teks dilewatkan melalui `htmlspecialchars()`. Hal ini dilakukan untuk mengatasi masalah penolakan pesan (Error `400 Bad Request`) oleh Telegram API apabila isi *notes* atau nama aset mengandung karakter Markdown khusus yang tidak tertutup/tidak berpasangan seperti asteris (`*`) atau garis bawah (`_`).

---

## Perubahan File 3: dashboard.blade.php (Widget Dashboard)

**Path**: `resources/views/dashboard.blade.php`

Modifikasi dilakukan untuk menambahkan widget box (`small-box`) kustom guna memantau jumlah aset berdasarkan status tertentu secara real-time di halaman utama Snipe-IT:
- **Aset Perbaikan** (Status ID 7, Background Red)
- **Asset Tool** (Status ID 15, Background Olive)
- **Aset Dipinjamkan** (Status ID 14, Background Aqua)
- **Aset Siap Pasang (IT)** (Status ID 2, Background Green)

Blok HTML ditambahkan sebelum baris `@if ($counts['grand_total'] == 0)`:
[Lihat `dashboard.blade.php` untuk detail layout-nya]

---

## Perubahan File 4: maintenances/index.blade.php (Panduan Maintenance)

**Path**: `resources/views/maintenances/index.blade.php`

Modifikasi untuk memberikan petunjuk kepada staf IT agar menyertakan Ticket ID dan memberikan tabel panduan kategori maintenance (Upgrade, Repair, Software Support, Maintenance, Configuration Change).
Ditambahkan di atas container tabel data maintenance:
[Lihat `maintenances_index.blade.php` untuk detail tabelnya]

---

## Perubahan File 5: users/print.blade.php (Tanda Terima Cetak)

**Path**: `resources/views/users/print.blade.php`

Modifikasi tata letak cetak tanda terima serah terima aset ke pengguna:
1. Menambahkan teks disclaimer hukum:
   > "Asset yang sudah diserahterimakan merupakan tanggung jawab pengguna. Bila terjadi kerusakan akibat kelalaian penggunaan akan dibebankan ke pengguna."
2. Mengganti kotak tanda tangan bawaan menjadi 4 kolom penandatangan:
   - **Diserahkan Oleh** (Staff IT)
   - **Diterima Oleh** (Penerima)
   - **Diketahui Oleh** (Atasan Penerima)
   - **Diketahui Oleh** (Unit Head IT)
[Lihat `users_print.blade.php` untuk detail struktur tabel signature-nya]

---

## Perubahan File 6: .htaccess (Web Routing & PHP cPanel)

**Path**: `.htaccess`

Mengubah rule default Apache untuk:
1. Mengarahkan otomatis semua request root domain ke subfolder `/public/` secara transparan (sehingga url tidak perlu menggunakan `/public/` di browser).
2. Mematikan directory index listing (`Options -Indexes`).
3. Mengatur versi PHP default di cPanel hosting menggunakan handler PHP 8.4 (`ea-php84`).
[Lihat `htaccess` untuk baris lengkapnya]

---

---

## Perubahan File 7: routes/web.php (Custom Routing)

**Path**: `routes/web.php`

Menambahkan rute `GET` dan `POST` untuk fitur bulk checkout dan check-in lisensi CCTV di bagian akhir file di dalam group middleware `auth`:
* `GET /bulkcheckoutlicense` dan `POST /bulkcheckoutlicense`
* `GET /bulkcheckinlicense` dan `POST /bulkcheckinlicense`

Proses check-out dan check-in pada rute ini mengintegrasikan fungsi `$seat->logCheckout()` dan `$seat->logCheckin()` agar aktivitas tercatat resmi pada log audit Snipe-IT.

---

## Perubahan File 8: default.blade.php (Sidebar Menu Navigasi)

**Path**: `resources/views/layouts/default.blade.php`

Menyisipkan dua menu navigasi baru di dalam modul `@can('view', \App\Models\License::class)` tepat di bawah menu utama *Licenses*:
* **Bulk Checkout CCTV** (`/bulkcheckoutlicense` dengan ikon kunci `fa-key`)
* **Bulk Checkin CCTV** (`/bulkcheckinlicense` dengan ikon undo `fa-undo`)

---

## Perubahan File 9: bulk_checkout_license & bulk_checkin_license (Custom Views)

**Path**: `resources/views/custom/`

Membuat direktori baru `custom` di dalam `views` dan menambahkan dua template halaman kustom:
1. **`bulk_checkout_license.blade.php`**: Berisi form pencarian user via Select2 AJAX, input catatan, dan tabel pencarian/saringan cepat (*client-side filtering*) untuk memilih lisensi CCTV yang akan diserahkan.
2. **`bulk_checkin_license.blade.php`**: Berisi list semua lisensi CCTV aktif yang sedang digunakan, info karyawan pemegang akses, tanggal checkout, input catatan, dan tombol check-in massal.

---

## Re-deploy Setelah Update Snipe-IT

Saat ada update sistem Snipe-IT (seperti `git pull`), file-file kustomisasi di atas berpotensi ter-overwrite atau terhapus.

### Langkah Cepat — Menggunakan Script Otomatis
Jalankan script restore yang sudah disiapkan di server:
```bash
cd /home/bmsnipeit/public_html
bash restore_telegram_patch.sh
```
Script ini akan:
1. Membackup file hasil update terbaru ke file `.pre_patch_{timestamp}` (sebagai cadangan).
2. Mendeteksi file backup working versi terakhir.
3. Merestore keenam file kustomisasi ke posisinya masing-masing.
4. Memvalidasi syntax PHP dari masing-masing file agar tidak terjadi error HTTP 500.
5. Melakukan clear cache Laravel (`php artisan optimize:clear`).

---

## Lokasi File Backup di Server

```
/home/bmsnipeit/public_html/
├── app/Listeners/
│   ├── CheckoutableListener.php                      <- AKTIF
│   └── CheckoutableListener.php.working_20260627_*  <- Backup working version
├── app/Observers/
│   ├── MaintenanceObserver.php                      <- AKTIF
│   └── MaintenanceObserver.php.working_20260611_*   <- Backup working version
├── resources/views/
│   ├── dashboard.blade.php                          <- AKTIF
│   └── dashboard.blade.php.working_20260611_*       <- Backup working version
│   ├── layouts/
│   │   ├── default.blade.php                        <- AKTIF
│   │   └── default.blade.php.working_20260627_*     <- Backup working version
│   ├── custom/
│   │   ├── bulk_checkout_license.blade.php          <- AKTIF
│   │   ├── bulk_checkout_license.blade.php.working_20260627_*
│   │   ├── bulk_checkin_license.blade.php           <- AKTIF
│   │   └── bulk_checkin_license.blade.php.working_20260627_*
│   ├── maintenances/
│   │   ├── index.blade.php                          <- AKTIF
│   │   └── index.blade.php.working_20260611_*       <- Backup working version
│   └── users/
│       ├── print.blade.php                          <- AKTIF
│       └── print.blade.php.working_20260611_*       <- Backup working version
├── routes/
│   ├── web.php                                      <- AKTIF
│   └── web.php.working_20260627_*                   <- Backup working version
├── .htaccess                                        <- AKTIF
├── .htaccess.working_20260611_*                    <- Backup working version
└── restore_telegram_patch.sh                        <- Script restore otomatis
```

---

## Daftar File yang Dikumpulkan di Folder `bmsnipeit`

Semua file modifikasi ini telah dikelompokkan di local workspace komputer Anda dalam folder **`bmsnipeit`**:

1. `web.php` (Custom API Routes, Track Cepat, Pinjam/Kembali, Relokasi)
2. `track_cepat.blade.php` (Modul Pencarian Terpadu 5 Seksi v1.9.16)
3. `default.blade.php` (Sidebar Actions, Modal Pinjam/Kembali, Modal Relokasi Cepat)
4. `CheckoutableListener.php` / `CheckoutableListener.original.php`
5. `MaintenanceObserver.php` / `MaintenanceObserver.original.php`
6. `AssetObserver.php` (Sinkronisasi Otomatis Aset CCTV & Lisensi Hik-Connect)
7. `dashboard.blade.php` / `dashboard.original.blade.php`
8. `maintenances_index.blade.php` / `maintenances_index.original.blade.php`
9. `users_print.blade.php` / `users_print.original.blade.php`
10. `htaccess` / `htaccess.original`
11. `bulk_checkout_license.blade.php` (Tampilan Bulk Checkout CCTV)
12. `bulk_checkin_license.blade.php` (Tampilan Bulk Checkin CCTV)
13. `restore_telegram_patch.sh` (Script restore)
14. `SNIPEIT_TELEGRAM_DOCS.md` (Dokumen panduan ini)

---

## Modul Aksi Cepat & Kustomisasi Unggulan

### 1. Modul 'Pinjam & Kembali' (Quick Loan & Return)
Fitur aksi cepat pada sidebar kiri (`🤝 Pinjam & Kembali`) yang menyediakan modal interaktif dual-mode untuk proses peminjaman unit dan pengembalian unit ke stock IT sesuai standar transaksi Snipe-IT:
* **Mode Pinjam (Checkout)**: Scan/input tag aset -> pilih karyawan/lokasi peminjam -> input estimasi pengembalian -> status otomatis berubah menjadi **`🟡 Asset Dipinjamkan` (ID: 14)**.
* **Mode Pengembalian (Return to Stock)**: Scan/input tag aset -> lokasi otomatis default ke **`KRIAN - GEDUNG TIMUR - RUANG OFFICE IT` (ID: 36)** -> status otomatis kembali ke **`🔵 Asset Stock` (ID: 2)** -> melepas penanggung jawab peminjam, membersihkan lisensi/pending acceptances, dan mencatat riwayat resmi di `Actionlog`.

### 2. Modul 'Update Lokasi Cepat' (Smart Relocation & Auto-Sync)
Modul penempatan dan relokasi aset cepat antar cabang / gedung:
* **Smart Auto-Sync**: Mendeteksi PT dan Lokasi kerja staf secara otomatis serta menyinkronkan `location_id`, `rtd_location_id`, dan `company_id` pada aset.
* **Fitur Override & Auto-Update Profil**: Dropdown manual PT & Lokasi kerja staf serta opsi pembaruan profil user di database secara otomatis saat relokasi.
* **Tombol Panduan Menyala Redup (*Vibrant Pulse Glow*)**: Panel panduan interaktif lipat 4 tahap alur kerja relokasi.

### 3. Modul 'Track Cepat Aset IT' (v1.9.16)
Pencarian terpadu 5 Seksi:
1. **Data Snipe-IT**: Data fisik, status barang, foto, lokasi, PT, dan PIC.
2. **Data FAH**: Spesifikasi hardware (CPU, RAM, Disk, OS, IP, MAC, McAfee).
3. **Data BS**: Dokumen Berita Acara Kerusakan terhubung langsung ke portal BMKB.
4. **Data Barang Keluar**: Integrasi Surat Jalan (SJ) dari database logistik.
5. **Histori Log & Audit Trail**: Tabel interaktif native action logs dan maintenance records.
* **Optimasi Query v1.9.16**: Prioritas pencarian Aset Aktif (`deleted_at IS NULL`), exact match, dan penanganan visual informatif untuk arsip re-create atau unit yang terhapus.

---

## Changelog

### [1.9.16] - 2026-09-15 15:20
* **Fixed**: Perbaikan prioritas query pencarian Track Cepat (`/track-cepat/search`) agar selalu mendahulukan Aset Aktif (`deleted_at IS NULL`) sebelum mencari ke arsip soft-deleted.
* **Added**: Banner visual informatif rekaman arsip sistem pada Track Cepat dan badge info riwayat re-create.
* **Updated**: Pembaruan label versi modul Track Cepat ke `v1.9.16`.

### [1.9.15] - 2026-09-15 08:25
* **Added**: Fitur Dual-Mode **`🤝 Pinjam & Kembali`** dengan Tab Switcher interaktif (Mode Pinjam Unit vs Mode Pengembalian Unit).
* **Added**: Alur otomatis pengembalian unit ke **`Ruang Office IT` (ID: 36)** dan status kembali ke **`Asset Stock` (ID: 2)**.
* **Added**: Backend handler `POST /custom/loan-checkin` dengan standar disassociation, license cleanup, dan audit trail `Actionlog`.

### [1.9.14] - 2026-09-15 08:20
* **Added**: Rilis inisial modul Pinjam Cepat (`POST /custom/loan-checkout`) dengan auto-detect PT/Lokasi dan set status otomatis ke **`🟡 Asset Dipinjamkan` (ID: 14)**.

### [1.9.13] - 2026-09-14 14:55
* **Fixed**: Penanganan focus trap Bootstrap modal pada input pencarian Select2 di dalam modal kustom (`enforceFocus` bypass & `z-index` adjustment).

### [1.9.12] - 2026-09-14 14:45
* **Added**: Box kontrol pemilihan manual `🏢 Perusahaan (PT)` & `📍 Lokasi Kerja` serta opsi sinkronisasi otomatis ke profil Karyawan pada modal Update Lokasi Cepat.

### [1.9.11] - 2026-09-14 14:40
* **Added**: Desain tombol panduan berpendar menyala redup (*Vibrant Pulse Glow Button*) dengan animasi `@keyframes pulse-glow-amber`.

### [1.9.10] - 2026-09-14 14:38
* **Added**: Panel panduan diagram alur kerja interaktif lipat pada modal Update Lokasi Cepat.

### [1.9.9] - 2026-09-14 14:32
* **Added**: Smart Auto-Sync Cabang, Lokasi, dan PT pada modul Update Lokasi Cepat.

### [1.9.8] - 2026-09-14 14:02
* **Added**: Menu aksi cepat sidebar **`Update Lokasi Cepat`** (`/custom/relocate-checkout`).

### [2026-06-27 08:30]
* **Added**: Tampilan table widget summary **Stok Komponen IT per Kategori** pada Dashboard utama.

### [2026-06-27 06:30]
* **Added**: Fitur kustom halaman web **Bulk Checkout CCTV** dan **Bulk Checkin CCTV**.

### [2026-06-25 12:30]
* **Fixed**: Notifikasi Telegram Maintenance mode HTML dan sanitasi karakter `htmlspecialchars`.

### [2026-06-11 16:00]
* **Added**: Integrasi awal notifikasi Telegram via bot `@bestarimulia_bot`.
