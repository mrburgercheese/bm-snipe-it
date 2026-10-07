# Kustomisasi & Modul Ekstensi Snipe-IT — PT Bestari Mulia

Repository ini berisi kumpulan modul kustom, ekstensi backend (observers, listeners, controllers), modul aksi cepat (*Quick Actions*), modul pencarian terpadu (*Track Cepat*), modul analisa hardware, widget dashboard, serta integrasi notifikasi Telegram untuk sistem IT Asset Management **Snipe-IT** pada server BMKB / Bestari Mulia.

---

## 📌 Ikhtisar Modul & Fitur Unggulan

### 1. 🤝 Modul 'Pinjam & Kembali' (Quick Loan & Return)
* **Mode Pinjam Unit**:
  - Scan / input Barcode Tag Aset atau Serial.
  - Penyerahan fleksibel ke **Karyawan / User** (dengan deteksi otomatis PT & Lokasi) atau **Lokasi / Ruangan**.
  - Form estimasi tanggal pengembalian (*Expected Return Date*) dan catatan keperluan dinas/event.
  - Status akhir aset otomatis diset ke **`🟡 Asset Dipinjamkan` (Status ID: 14)**.
* **Mode Pengembalian Unit (Return to Stock)**:
  - Lokasi pengembalian otomatis default ke **`KRIAN - GEDUNG TIMUR - RUANG OFFICE IT` (ID: 36)**.
  - Status akhir unit otomatis dikembalikan ke **`🔵 Asset Stock` (Status ID: 2 / Ready to Deploy)**.
  - Backend handler `POST /custom/loan-checkin` yang melepas penanggung jawab peminjam, membersihkan lisensi terkait, memicu event standard checkin, dan mencatat riwayat ke `Actionlog`.

### 2. 📍 Modul 'Update Lokasi Cepat' (Smart Relocation & Auto-Sync)
* **Pencegahan Human-Error Relokasi**:
  - Scan/input Barcode Tag Aset dengan deteksi instan status, PT asal, dan penanggung jawab saat ini.
  - Pilihan target relokasi fleksibel: **Lokasi / Ruangan Pabrik** (`App\Models\Location`) atau **Karyawan / Personil** (`App\Models\User`).
  - **Smart Auto-Sync**: Sinkronisasi otomatis `location_id`, `rtd_location_id`, dan `company_id`.
  - **Override & Auto-Update Profil**: Kotak kontrol manual pemilihan PT & Lokasi dengan opsi perbarui profil karyawan di database secara otomatis saat submit.
  - **Tombol Panduan Menyala Redup (*Vibrant Pulse Glow*)**: Panel diagram alur kerja visual lipat (*collapsible*) 4 tahap.

### 3. 🔍 Modul Terpadu 'Track Cepat Aset IT & Komponen' (v1.9.19)
Pencarian instan terpadu yang mengonsolidasikan data Aset Hardware, Master Komponen, Form Analisa Hardware (FAH), dan Berita Acara Kerusakan (BS) dalam 1 antarmuka cerdas (*Omni-Search*):
1. **Mode Aset IT (5 Seksi + Komponen Terpasang)**:
   - **Data Snipe-IT**: Detail utama aset, foto visual fisik, status operasional real-time, lokasi, PT, dan PIC.
   - **Data FAH (Form Analisa Hardware)**: Direct table query ke `bmkb_wp_2tqty.9VlGW_bm_hw_fah`, menampilkan indikasi kerusakan, tindakan pemeriksaan, hasil analisa, dan foto fisik unit FAH.
   - **Seksi 2.5: 🧩 Komponen Tambahan Terpasang**: Daftar seluruh komponen RAM, SSD, HDD, dan part pengganti yang di-checkout ke unit PC/Laptop tersebut dari tabel `components_assets`.
   - **Data BS (Berita Acara Kerusakan)**: Direct table query ke `bmkb_wp_2tqty.9VlGW_bm_hw_scrap`, menampilkan kode BS, tanggal cek/input, status verifikasi audit, nomor dus penyimpanan, catatan kerusakan, dan foto fisik kerusakan barang (*attachment gambar*).
   - **Data Barang Keluar (Logistik)**: Riwayat transaksi Surat Jalan (SJ) dari database logistik.
   - **Histori Log & Audit Trail**: Tabel interaktif native action logs dan maintenance records.
2. **Reverse Lookup Dua Arah**:
   - Mendukung pencarian menggunakan **Kode BS** (misal: `BS-0800`, `BS-0650`, `BS-0900`) atau **Nomor FAH** (misal: `06//F-AH/IT-BM/07/2026`) untuk secara otomatis menampilkan profil unit aset terkait (`CAM-230613006`).
3. **Mode Komponen Hardware (`COM-...` / Serial RAM / SSD)**:
   - **Bento KPI Bar**: Total Stok, Sedang Terpasang di PC, Sisa Stok Tersedia (Ready), dan Kategori Komponen.
   - **Tabel Master Komponen**: Nama, Serial / Kode COM, Model Number, Order/PO, Pembelian, Harga, Lokasi Gudang Simpan, Catatan, dan Tombol Link ke detail Snipe-IT.
   - **Dukungan Komponen Terhapus / Diarsipkan (*Soft-Deleted / Trashed*)**: Pencarian otomatis mendeteksi komponen yang telah dihapus, menampilkan banner arsip visual berwarna oranye/merah mencolok, tanggal penghapusan, serta seluruh rekaman audit mutasi.
   - **Tabel Unit Aset Penampung**: Menampilkan seluruh PC / Laptop yang sedang menggunakan komponen tersebut.
* **Filter Mode Switcher**: Tombol filter cepat di atas kotak pencarian (`[ 🌐 Semua (Auto-Detect) ]`, `[ 💻 Khusus Aset IT ]`, `[ 🧩 Khusus Komponen ]`).

### 4. 🔔 Notifikasi Telegram Real-Time (`@bestarimulia_bot`)
* **Transaksi Aset**: Mengirim pesan real-time saat Aset di-*checkout* (diserahkan) atau di-*checkin* (dikembalikan).
* **Transaksi Pemeliharaan**: Notifikasi otomatis saat tiket pemeliharaan (Maintenance) dibuat atau dihapus.
* **Lisensi CCTV & Akses**: Notifikasi penyerahan lisensi kamera CCTV.
* **Keamanan Pesan**: Mode HTML dengan sanitasi `htmlspecialchars` untuk mencegah penolakan format pesan (anti Error 400 Bad Request).

### 5. 🎥 Otomasi Siklus Hidup Aset & Lisensi CCTV Hik-Connect
* **Auto Provisioning Lisensi (`AssetObserver.php`)**: Pembuatan Aset Kamera CCTV baru (Kategori 16) otomatis membuat Lisensi Hak Akses Hik-Connect (Kategori 63) dengan 10 kursi (*seats*) dan nomor seri disamakan dengan *Asset Tag*.
* **Auto Rename & Delete**: Otomatis memperbarui nama lisensi saat nama aset kamera diubah, dan menghapus lisensi saat unit CCTV dihapus.
* **Bulk Action License**: Fitur kustom halaman web **Bulk Checkout CCTV** dan **Bulk Checkin CCTV** untuk pengelolaan massal hak akses CCTV karyawan.

### 6. 📊 Modul Analisa Hardware & Pemeliharaan Komputer (`/analisa/...`)
* **Analisa CPU Intel Non-Core (`/analisa/cpu-intel-noncore`)**: Pemetaan inventaris PC dengan prosesor Celeron, Pentium, dan Atom untuk sasaran upgrade.
* **Laporan Progress Upgrade (`/analisa/progress-report`)**: Pelacakan kemajuan upgrade hardware, alokasi komponen RAM/SSD, integrasi *Component Checkout*, dan form cetak resmi (`print_report.blade.php`).
* **Agenda Pembersihan Fisik PC (`/analisa/cleaning-agenda`)**: Kalender maintenance fisik 1 tahun, sinkronisasi dua arah tiket HESK ITSM, dan form cetak agenda (`print_cleaning_report.blade.php`).

### 7. 🎨 Kustomisasi Tampilan (Views) & Dashboard
* **Dashboard Widgets**: Widget box pemantauan aset real-time (Aset Perbaikan, Asset Tool, Aset Dipinjamkan, Aset Siap Pasang, Stok Komponen per Kategori, dan Laporan OKR Kelengkapan Foto).
* **Panduan Maintenance**: Himbauan wajib Ticket ID & 5 kategori pemeliharaan di atas tabel data maintenance.
* **Tanda Terima Cetak (`users_print.blade.php`)**: Disclaimer tanggung jawab pemakaian aset dan 4 kolom tanda tangan (Staf IT, Penerima, Atasan, Unit Head IT).

---

## 🗂️ Pemetaan File ke Struktur Snipe-IT

| File Repository | Lokasi Target di Server Snipe-IT | Keterangan |
| :--- | :--- | :--- |
| `app/Listeners/CheckoutableListener.php` | `app/Listeners/CheckoutableListener.php` | Listener event checkout/checkin & Telegram notif |
| `app/Observers/MaintenanceObserver.php` | `app/Observers/MaintenanceObserver.php` | Observer maintenance create/delete & Telegram notif |
| `app/Observers/AssetObserver.php` | `app/Observers/AssetObserver.php` | Observer auto-sync aset CCTV ke lisensi Hik-Connect |
| `app/Observers/ComponentObserver.php` | `app/Observers/ComponentObserver.php` | Observer mutasi stok komponen |
| `app/Http/Controllers/HardwareAnalisaController.php` | `app/Http/Controllers/HardwareAnalisaController.php` | Controller Analisa Hardware, Cleaning & Upgrade |
| `routes/web.php` | `routes/web.php` | Rute kustom Track Cepat, Pinjam/Kembali, Relokasi, dll |
| `resources/views/dashboard.blade.php` | `resources/views/dashboard.blade.php` | Custom dashboard widgets & sortable panels |
| `resources/views/layouts/default.blade.php` | `resources/views/layouts/default.blade.php` | Sidebar menu navigasi & modal trigger aksi cepat |
| `resources/views/custom/track_cepat.blade.php` | `resources/views/custom/track_cepat.blade.php` | Modul pencarian terpadu 5 Seksi |
| `resources/views/custom/bulk_checkout_license.blade.php` | `resources/views/custom/bulk_checkout_license.blade.php` | Tampilan bulk checkout lisensi CCTV |
| `resources/views/custom/bulk_checkin_license.blade.php` | `resources/views/custom/bulk_checkin_license.blade.php` | Tampilan bulk checkin lisensi CCTV |
| `resources/views/analisa/cpu_intel_noncore.blade.php` | `resources/views/analisa/cpu_intel_noncore.blade.php` | Tampilan analisa PC Intel Non-Core |
| `resources/views/analisa/progress_report.blade.php` | `resources/views/analisa/progress_report.blade.php` | Tampilan progress bar & milestone upgrade |
| `resources/views/analisa/cleaning_agenda.blade.php` | `resources/views/analisa/cleaning_agenda.blade.php` | Tampilan agenda tahunan pembersihan PC |
| `resources/views/maintenances/index.blade.php` | `resources/views/maintenances/index.blade.php` | Panduan 5 kategori maintenance |
| `resources/views/users/print.blade.php` | `resources/views/users/print.blade.php` | Tanda terima cetak serah terima 4 signature |
| `.htaccess` | `.htaccess` | Rewrite transparan root ke /public/ & PHP 8.4 |
| `restore_telegram_patch.sh` | `restore_telegram_patch.sh` | Script auto-restore patch setelah update Snipe-IT |

---

## 🚀 Konfigurasi & Variabel Environment (`.env`)

Tambahkan variabel berikut ke berkas `.env` Snipe-IT untuk mengaktifkan integrasi bot Telegram:

```env
# --------------------------------------------
# TELEGRAM NOTIFICATION CONFIGURATION
# --------------------------------------------
TELEGRAM_NOTIFICATION_ENABLED=true
TELEGRAM_BOT_TOKEN="YOUR_TELEGRAM_BOT_TOKEN"
TELEGRAM_CHAT_ID="YOUR_TELEGRAM_CHAT_ID"
```

Setelah memperbarui `.env`, bersihkan cache konfigurasi Laravel:
```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## 🏷️ Riwayat Rilis & Tag Versi

Detail riwayat rilis dan catatan perubahan lengkap dapat dilihat pada berkas [CHANGELOG.md](CHANGELOG.md).
Setiap tag rilis pada repository ini merepresentasikan milestone fungsionalitas:

* **`v1.9.19`**: Integrasi Reverse Lookup langsung ke tabel database Plugin Scrap/BS (`9VlGW_bm_hw_scrap`) dan FAH (`9VlGW_bm_hw_fah`) di Track Cepat, serta dukungan foto fisik kerusakan barang.
* **`v1.9.18`**: Dukungan Pelacakan Komponen Terhapus / Diarsipkan (Soft-Deleted / Trashed Components), banner visual arsip, dan audit mutasi lengkap.
* **`v1.9.17`**: Modul Smart Unified Track Cepat (Dukungan Pelacakan Komponen, Bento KPI Stok, Unit Penampung, dan Relasi Dua Arah Komponen ↔ Aset).
* **`v1.9.16`**: Optimasi query pencarian Track Cepat (prioritas Aset Aktif vs Soft-Deleted) & badge arsip re-create.
* **`v1.9.15`**: Modul Dual-Mode *Pinjam & Kembali* (Quick Loan & Return) dengan auto-return ke Ruang Office IT.
* **`v1.9.13`**: Perbaikan focus trap modal Bootstrap dan Select2 dropdown search.
* **`v1.9.12`**: Fitur override fleksibel PT & Lokasi serta auto-update profil karyawan di database.
* **`v1.9.11`**: Desain tombol panduan berpendar menyala (*Vibrant Pulse Glow*).
* **`v1.9.10`**: Diagram alur kerja interaktif 4 tahap pada modal relokasi.
* **`v1.9.9`**: Smart auto-sync cabang, lokasi, dan PT pada Update Lokasi Cepat.
* **`v1.9.8`**: Modul Update Lokasi Cepat / Relokasi Checkout Cepat (`/custom/relocate-checkout`).
* **`v1.9.6`**: Auto code generator kode komponen `COM-YYMMDDXXX`.
* **`v1.9.5`**: Integrasi direct table lookup database plugin Barang Keluar (`bm_inv_barang_keluar`).
* **`v1.9.4`**: Penambahan Seksi 4 Data Barang Keluar pada Track Cepat.
* **`v1.9.3`**: Reverse lookup Kode BS & FAH pada Track Cepat serta pop-up modal panduan.
* **`v1.9.2`**: Rilis awal modul Track Cepat Aset IT 3 Seksi.
* **`v1.9.1`**: Widget dashboard OKR kelengkapan foto fisik & penyelarasan checkin perbaikan cepat.
* **`v1.8.0`**: Modul Analisa Hardware PC Non-Core, Laporan Progress Upgrade, Agenda Cleaning, & integrasi tiket HESK.
* **`v1.1.0`**: Observer sinkronisasi otomatis lisensi CCTV (Kategori 16 ke 63) & widget stok komponen interaktif.
* **`v1.0.0`**: Rilis inisial kustomisasi notifikasi Telegram Snipe-IT.

---

## 👨‍💻 Kontributor & Lisensi
Dikembangkan dan dipelihara oleh **Tim IT PT Bestari Mulia** bersama **Lexa AI Assistant**.
Repository ini ditujukan untuk internal Bestari Mulia Asset Management System.
