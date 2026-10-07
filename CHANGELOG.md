# Changelog

## [1.9.19] - 2026-10-07 16:30
### Added
- **Integrasi Reverse Lookup Tabel Database Plugin Barang Rusak (BS) & Form Analisa Hardware (FAH) ke Track Cepat**:
  - **Reverse Lookup Langsung ke Database Scrap & FAH**: Mengintegrasikan pencarian instan pada tabel WordPress `bmkb_wp_2tqty.9VlGW_bm_hw_scrap` (Barang Rusak) dan `bmkb_wp_2tqty.9VlGW_bm_hw_fah` (FAH). Memungkinkan pencarian menggunakan Kode BS (seperti `BS-0800`, `BS-0650`, `BS-0900`) maupun Nomor FAH (seperti `06//F-AH/IT-BM/07/2026`) untuk secara otomatis mengidentifikasi dan menampilkan detail aset terkait (`CAM-230613006`).
  - **Dukungan Foto Fisik Barang Rusak (Manual BS Attachment)**: Mengakomodasi kolom gambar baru (`gambar_1`, `gambar_2`) dari tabel scrap BMKB sehingga foto kerusakan barang yang diunggah saat input manual BS tampil sebagai thumbnail interaktif pada Seksi 3 (Data BS).
  - **Status Verifikasi Audit & Lokasi Dus**: Menampilkan label status audit terkini (`Sudah verifikasi audit` / `Belum verifikasi audit`) dan nomor penempatan kardus (`dus_no: DUS 8`) pada kartu rekaman BS.
  - **Visualisasi Hasil Analisa Kerusakan FAH**: Seksi 2 (Data FAH) kini menampilkan rincian indikasi kerusakan, tindakan pemeriksaan, hasil analisa, serta foto fisik dari tabel FAH BMKB.

## [1.9.18] - 2026-10-02 12:55
### Added
- **Dukungan Pencarian Komponen Terhapus / Diarsipkan (Soft-Deleted / Trashed Components & Audit Log)**:
  - **Pencarian Fallback ke Arsip Komponen**: Menambahkan pencarian `Component::onlyTrashed()` dan pencarian referensi log pada `action_logs` ketika kode komponen (seperti `COM-260227009`) tidak ditemukan di tabel komponen aktif.
  - **Banner Arsip Komponen Terhapus (Visual Warning)**: Menampilkan banner peringatan arsip bernuansa peringatan oranye/merah yang mencolok jika komponen yang dicari berstatus terhapus, lengkap dengan tanggal penghapusan (`deleted_at`), peringatan status arsip, dan badge status `[ ARSIP / TRASH ]`.
  - **Riwayat Lengkap Rekaman Komponen Terhapus**: Menampilkan seluruh data master (tipe, kategori, model no, PO, pembuat/penghapus) serta riwayat audit mutasi (waktu pembuatan dan penghapusan oleh admin) secara transparan untuk keperluan investigasi audit.
  - **Dukungan Parameter Fleksibel**: Endpoint `/track-cepat/search` kini mendukung pembacaan parameter `query` maupun `q`.

## [1.9.17] - 2026-10-02 12:48
### Added
- **Modul Smart Unified Track Cepat (Dukungan Pelacakan Komponen & Relasi Dua Arah Aset ↔ Komponen)**:
  - **Omni-Search Engine Cerdas**: Input pencarian kini mendukung Tag Aset (`PBM-...`), Kode Komponen (`COM-...`), Serial Number RAM/SSD/Hardisk, No. BS, No. FAH, maupun No. SJ.
  - **Pencarian Master & Status Stok Komponen (`result_type: component`)**:
    - Bento KPI Bar: Total Kuantitas, Sedang Terpasang di Aset, Sisa Stok Tersedia (Ready to Deploy), dan Kategori Komponen.
    - Tabel Master Komponen: Nama, Serial/Kode COM, Model No, PO/Pembelian, Harga, Lokasi Gudang Penyimpanan, dan Catatan.
    - **Tabel Daftar Unit Aset Penampung**: Menampilkan seluruh PC / Laptop yang sedang menggunakan komponen tersebut lengkap dengan Tag Aset (Hyperlink), Nama PC, Status Aset, Lokasi, PIC Pengguna, Qty Dipasang, dan Tanggal Pemasangan.
    - **Tabel Riwayat Mutasi & Audit Log Komponen**: Rekaman log transaksi checkout to asset, checkin, update, dan nama admin eksekutor.
  - **Relasi Dua Arah pada Detail Aset (`result_type: asset`)**:
    - Menambahkan **Seksi 2.5: 🧩 Komponen Tambahan Terpasang**: Menampilkan daftar seluruh komponen RAM, SSD, HDD, dan part pengganti yang di-checkout ke unit PC/Laptop tersebut dari tabel `components_assets`.
  - **Filter Mode Switcher Pills**: Tombol filter cepat di atas kotak pencarian (`[ 🌐 Semua (Auto-Detect) ]`, `[ 💻 Khusus Aset IT ]`, `[ 🧩 Khusus Komponen ]`).
  - **Contoh Pencarian Cepat (*Quick Chips*)**: Tautan instan barcode contoh untuk mempermudah pengujian staf IT.

## [1.9.16] - 2026-09-15 15:15
### Fixed
- **Perbaikan Prioritas Pencarian Track Cepat (Active Assets vs Soft-Deleted/Arsip)**:
  - Memperbaiki algoritma query pencarian pada endpoint `/track-cepat/search` agar selalu memprioritaskan aset aktif (`deleted_at IS NULL`) sebelum mencari ke arsip aset yang terhapus (*trashed*).
  - Mengurutkan hasil pencarian berdasarkan kecocokan eksak (`asset_tag` / `serial`) dan ID terbaru (`id DESC`), sehingga aset aktif seperti `PBM-230411129` (ID: 226, Status: Asset Stock) tidak tertimpa oleh record lama yang telah dihapus pada tahun 2023 (ID: 182).
  - Tetap mempertahankan fitur pencarian fallback ke arsip terhapus jika memang unit tidak memiliki duplikat aset aktif.

## [1.9.15] - 2026-09-15 08:25
### Added
- **Modul Dual-Mode 'Pinjam & Kembali' (Quick Asset Loan & Return) Standar Snipe-IT**:
  - Penambahan menu sidebar baru **`🤝 Pinjam & Kembali`** dengan Tab Switcher interaktif:
    1. **Mode Pinjam Unit**:
       - Scan/ketik Barcode Tag Aset / Serial dengan preview realtime.
       - Pilihan target peminjam fleksibel: **Karyawan / User** (dengan auto-detect PT & lokasi) vs **Lokasi / Ruangan / Event**.
       - Form rencana tanggal pengembalian (*Expected Return Date*) dan catatan keperluan dinas/event.
       - Status akhir unit otomatis diset ke **`🟡 Asset Dipinjamkan` (Status ID: 14)**.
    2. **Mode Pengembalian Unit (Return to Stock)**:
       - Default lokasi pengembalian otomatis diarahkan ke **`KRIAN - GEDUNG TIMUR - RUANG OFFICE IT` (ID: 36)**.
       - Status akhir unit otomatis dikembalikan menjadi **`🔵 Asset Stock` (Status ID: 2 / Ready to Deploy)** (juga tersedia pilihan status jika unit rusak/butuh perbaikan).
       - Backend handler `POST /custom/loan-checkin` yang mengeksekusi *standard checkin*, disassociates target peminjam, menyelaraskan lokasi fisik & RTD, memicu event `CheckoutableCheckedIn`, dan mencatat riwayat resmi di `Actionlog`.
  - Tombol bantuan panduan bercahaya (*vibrant glowing guide*) dengan visual diagram alur peminjaman dan pengembalian unit.

## [1.9.13] - 2026-09-14 14:55
### Fixed
- **Perbaikan Focus Trap & Select2 Dropdown Search di dalam Modal Update Lokasi Cepat**:
  - Menghapus atribut `tabindex="-1"` pada modal container Bootstrap untuk mencegah `enforceFocus` mencuri dan menutup search box Select2 saat diklik.
  - Mematikan event listener `enforceFocus` Bootstrap modal saat modal ditampilkan (`$(document).off('focusin.modal')`).
  - Menambahkan styling `z-index: 99999999 !important` pada `.select2-container--open`, `.select2-dropdown`, dan `.select2-search__field`.
  - Menginisialisasi ulang Select2 secara otomatis setelah container override `#relocate-user-override-box` selesai di-slide down.

## [1.9.12] - 2026-09-14 14:45
### Added
- **Fitur Pemilihan / Override Fleksibel Perusahaan (PT) & Lokasi Kerja serta Auto-Update Profil Karyawan**:
  - Penambahan box kontrol terpadu di bawah dropdown Karyawan yang menyediakan dropdown eksplisit:
    1. `🏢 Perusahaan (PT) Aset` (seluruh opsi Company terdaftar).
    2. `📍 Lokasi Kerja / Penempatan` (seluruh opsi Location terdaftar).
  - Penanganan kasus profil user kosong/belum lengkap (muncul badge peringatan ramah `⚠️ Profil Karyawan belum memiliki data PT / Lokasi lengkap`).
  - Fitur checkbox pintar: `☑️ Sekaligus perbarui & simpan PT dan Lokasi ini ke profil Karyawan` (memperbarui profil user di tabel `users` database secara otomatis saat submit).
  - Sinkronisasi penuh ke aset (`location_id`, `rtd_location_id`, `company_id`).

## [1.9.11] - 2026-09-14 14:40
### Added
- **Desain Tombol Panduan Menyala Redup (Vibrant Pulse Glow Button)**:
  - Mengubah styling tombol panduan menjadi gradient amber/oranye menyala (`#ff9800` ke `#e65100`) dengan efek animasi napas berpendar (*soft pulsing glow* `@keyframes pulse-glow-amber`).
  - Penambahan ikon bohlam bercahaya (`💡`) dengan drop shadow untuk menarik perhatian pengguna tanpa mengganggu kenyamanan visual.

## [1.9.10] - 2026-09-14 14:38
### Added
- **Panduan & Diagram Alur Kerja Interaktif pada Modal Update Lokasi Cepat**:
  - Penambahan tombol interaktif **`[ 💡 Panduan & Diagram Alur ]`** di bagian atas modal penempatan aset.
  - Panel diagram alur kerja visual lipat (*collapsible cards*) 4 tahap lengkap:
    1. Scan/Ketik Tag Aset (Deteksi status & PT asal).
    2. Pemilihan Target (Lokasi Pabrik vs Karyawan/User).
    3. Smart Auto-Sync Cabang & PT Otomatis.
    4. Eksekusi Checkout 2 Tahap (Auto-checkin & Checkout baru dengan pencatatan History).
  - Penjelasan aturan audit trail dan transparansi relokasi aset antar cabang.

## [1.9.9] - 2026-09-14 14:32
### Added
- **Smart Auto-Sync Cabang, Lokasi, dan PT pada Modul Update Lokasi Cepat**:
  - Penambahan badge info live deteksi otomatis cabang karyawan (`🏢 Perusahaan (PT)` & `📍 Lokasi Kerja`) saat memilih user di dropdown modal.
  - Penambahan badge info otomatis perusahaan penanggung jawab lokasi saat memilih relokasi ke lokasi fisik.
  - Auto-sinkronisasi penuh: saat aset di-relokasi/checkout ke Karyawan atau Lokasi baru, sistem secara otomatis menyinkronkan `location_id` (Lokasi Terpasang), `rtd_location_id` (Default/Home Location), dan `company_id` (Perusahaan/PT) pada data aset di database.
  - Penambahan kolom `PT (Company)` pada kartu *Preview Detail Aset Terdeteksi*.

## [1.9.8] - 2026-09-14 14:02
### Added
- **Modul Update Lokasi Cepat / Relokasi Checkout Cepat (`/custom/relocate-checkout`)**:

  - Menambahkan menu aksi cepat **`Update Lokasi Cepat`** pada Sidebar Kiri (posisi di atas menu *Perbaikan Cepat*).
  - Modal terpadu dengan scan/ketik Barcode & Tag Aset, auto-lookup data realtime (Foto, Nama, Lokasi, Assignee, Status).
  - Pilihan fleksibel target relokasi: **Lokasi / Ruangan Pabrik** (`App\Models\Location`) atau **Karyawan / Personil** (`App\Models\User`).
  - Alur otomatis 2 tahap standar Snipe-IT: Auto-checkin dari target sebelumnya ➔ Auto-checkout ke target lokasi/user baru dengan status `Asset Terpasang` (ID: 4).
  - Sinkronisasi otomatis `location_id` dan `rtd_location_id` serta pencatatan resmi ke `Actionlog` (Audit Trail & History).

### Added
- **Penyempurnaan Modul Track Cepat (Seksi 4 Plugins Barang Keluar)**: Integrasi query langsung ke tabel database `bmkb_wp_2tqty.bm_inv_barang_keluar` dengan hak akses MySQL terverifikasi.
- **Pembersihan Fallback Surat Jalan**: Menghilangkan tampilan fallback checkout internal bersimbol `-` pada Seksi 4 dan menggantinya dengan notifikasi informatif *"Tidak ada transaksi Surat Jalan (SJ) keluar untuk aset ini (Plugins Barang Keluar)"*.
- **Reverse Lookup No. SJ**: Mendukung pencarian instan berdasarkan No. Transaksi Sistem / Surat Jalan (contoh: `IT-K-2608-00005`) untuk menampilkan data aset terkait.
- **Snapshot Backup Kustomisasi Stabil**: Pencadangan penuh seluruh modul kustom Snipe-IT (Track Cepat, Analisa Hardware, Observers, dan Listeners).

## [1.9.6] - 2026-08-27 11:04
### Added
- **Auto Code Generator Komponen (`COM-YYMMDDXXX`)**: Menambahkan generator otomatis kode komponen pada antarmuka penambahan Komponen baru (`/components/create`).
- **Format Kode Otomatis**: Menghasilkan kode unik dengan prefix `COM-` + Tanggal `YYMMDD` + Nomor Urut 3 digit (contoh: `COM-260827001`).
- **Auto Pre-Fill & Interactive Buttons**: Mengisi bidang `Serial` dan `Name` secara otomatis saat halaman dibuka serta menyediakan tombol interaktif *Auto Generate Kode COM*.

## [1.9.5] - 2026-08-24 23:53
### Added
- **Integrasi Direct Table Lookup Plugins Barang Keluar (`bmkb_wp_2tqty.bm_inv_barang_keluar`)**: Seksi 4 kini menarik data transaksi barang keluar secara terpadu langsung dari tabel database plugin Barang Keluar (`bm_inv_barang_keluar`).
- **5 Kolom Tepat Seksi 4**: Menyajikan 5 kolom persis permintaan pengguna (`Kode Barang`, `Nama Barang`, `No. SJ`, `Tujuan`, `Dibuat Tanggal`).
- **Reverse Lookup Pencarian No. SJ**: Fitur pencarian kini mendukung input Nomor Surat Jalan / No Transaksi Sistem (contoh: `IT-K-2608-00005`) untuk melacak aset terkait secara otomatis.

## [1.9.4] - 2026-08-24 23:42
### Added
- **Modul Track Cepat Aset IT (`/track-cepat`) - Seksi 4 DATA BARANG KELUAR**:
  - Menambahkan Seksi 4 baru khusus **DATA BARANG KELUAR (INVENTORY BARANG KELUAR)** setelah Seksi 3 (DATA DI BS).
  - Melakukan lookup terpadu ke tabel transaksi pengeluaran/pinjam/distribusi (`asset_transactions` & `action_logs` checkout/checkin).
  - Menyajikan rincian Tipe Transaksi (Badge), Tanggal Keluar, Dikeluarkan Oleh, Target/Penerima/Lokasi Tujuan, dan Catatan Keperluan.

## [1.9.3] - 2026-08-24 16:59
### Added
- **Modul Track Cepat Aset IT (`/track-cepat`)**:
  - Menambahkan fitur pencarian terbalik (*Reverse Lookup*) berdasarkan Kode BS (e.g. `BS-0814`, `BS-0835`, `BS-0819`) dan No. FAH (e.g. `10//F-AH`).
  - Menambahkan tombol interaktif `📖 Panduan & Alur Kerja` dan Modal Pop-Up Panduan Penggunaan langkah 1 s/d 5.
  - Menambahkan Badge Versi `v1.9.3` dan timestamp pembaruan terakhir `2026-08-24 16:59 WIB` pada Card Header dan Modal Panduan.

Semua perubahan penting pada plugin bmsnipeit akan didokumentasikan di sini.

## [1.9.2] - 2026-08-24 15:56
### Added
- Modul Baru **Track Cepat Aset IT** (`/hardware/track-cepat` & tombol sidebar menu `Track Cepat`).
- Penyajian hasil pencarian terpadu dalam **3 Seksi Utama Terstruktur**:
  1. **Data di Snipe-IT**: Detail utama aset, foto visual, status real-time (aktif/perbaikan/rusak/kanibal/deleted), serta hyperlink ke detail aset & peminjam.
  2. **Data di FAH (Form Analisa Hardware)**: Detail spesifikasi processor, RAM, disk 1 & 2, OS, IP & MAC address, status Antivirus McAfee, serta hyperlink ke dashboard FAH.
  3. **Data di BS (Berita Acara Barang Rusak & Histori)**: Deteksi otomatis Kode BS (`BS-0819`, `BS-0814`, `BS-0826`), tabel histori perbaikan/maintenance, serta tabel action logs audit trail.

## [1.9.1] - 2026-08-04 08:58
### Removed
- Mengosongkan widget banner atas *Status Foto Fisik Aset* dan merapikan layout dashboard agar berfokus penuh pada widget rincian per perusahaan di kolom kanan di atas tabel *Locations*.


### Added
- Widget Dashboard **Dokumentasi Foto Fisik Aset (Laporan OKR)**: Menampilkan kelengkapan foto aset (88.3% berfoto, 164 unit belum berfoto).
- Widget Dashboard **Kurang Foto Fisik Aset Per Perusahaan (OKR)** di atas tabel *Locations*: Menampilkan rincian kekurangan foto per perusahaan (PT BM Bali 70 unit, Kediri 28 unit, Bestari Mulia 22 unit, Samarinda 13 unit, Makasar 12 unit, dll.) lengkap dengan mini progress bar dan tombol filter cepat.

### Changed
- Penyelarasan Alur Backend **Perbaikan Cepat** (`checkin_to_repair.process`):
  1. Otomatis Melakukan **Check-in** (melepas assignment dari User / lokasi asal & menyimpan `last_checkin`).
  2. Otomatis Mengubah Lokasi Fisik Perangkat ke **`KRIAN - GEDUNG TIMUR - RUANG OFFICE IT`** (Location ID 36).
  3. Otomatis Set Status Label Aset ke **`Asset Dalam Perbaikan`** (Status ID 7).
  4. Memicu Event `CheckoutableCheckedIn` untuk Pencatatan Activity Log & Kirim Notifikasi Telegram.

## [1.8.0] - 2026-08-03 10:09
### Added
- Form Terpadu **"Proses & Selesai Upgrade"** pada tabel Analisa Hardware & Laporan Progress Upgrade.
- Tombol **`[✅ Selesai Upgrade]`** yang membuka modal dialog 4-in-1:
  1. Auto-update spesifikasi Processor Baru & RAM Baru di Snipe-IT DB.
  2. Integrasi **Component Checkout** otomatis dari stok Komponen Snipe-IT (`components` & `components_assets`).
  3. Pencatatan otomatis **Log Record Maintenance** resmi (*Hardware Upgrade*) per aturan Double-Update Rule 18.
  4. Pengubahan status aset otomatis dari `Terjadwal Upgrade` ➔ `Asset Terpasang` (ID 4) & memperbarui progress bar real-time.


### Added
- Fitur **Filter Lengkap Agenda Cleaning** (Tahun, Perusahaan, Kategori Aset, Lokasi/Cabang, Status Cleaning, dan Status Tiket HESK) persis sejalan dengan plugin `maintenance-monitoring`.
- Fitur **Generate Tiket HESK ITSM Terpilih (Bulk Action)**: Dapat mencentang daftar agenda dan memproduksi tiket HESK massal secara aman.
- Fitur **Sinkronisasi Dua Arah HESK ITSM & Snipe-IT**: Ketika tiket HESK berstatus `Resolved` (status 3), status agenda cleaning otomatis berubah menjadi `Sudah Maintenance` dan memperbarui tanggal realisasinya.
- Jaminan Keamanan Database: Seluruh data relasi tiket HESK tersimpan independen tanpa mengubah skema tabel core Snipe-IT.


### Added
- Modul & sub-menu baru **Analisa Hardware -> Agenda & Laporan Cleaning** (perancangan pemeliharaan rutin 1 tahun kalender).
- Fitur **Generate Agenda Cleaning (1-Click)** untuk menarik seluruh aset hardware aktif (PC, Laptop, CCTV, Printer, AP, Server) ke dalam agenda tahunan.
- Fitur **Auto-Sync dari Log Maintenance Snipe-IT** berbasis kata kunci (`Cleaning`, `Pembersihan`, `Preventive`) untuk memperbarui status realisasi secara otomatis.
- Fitur **Cetak Laporan Formal (A4 Landscape)** dengan ringkasan ketercapaian (%), tabel rincian agenda per lokasi & perusahaan, serta footer resmi *"Generated Report by bmsnipeit"*.


### Added
- Widget baru **Agenda Upgrade Hardware PC Non-Core** pada Dashboard Utama Snipe-IT.
- Bilah kemajuan (*Progress Bar*) persentase upgrade selesai vs sisa PC non-Core secara real-time.
- Tombol akses cepat dari Dashboard ke halaman *Kelola Terjadwal* dan *Laporan Progress*.


### Added
- Sub-menu baru **Analisa Hardware -> Laporan Progress Upgrade** untuk pemantauan persentase kemajuan upgrade hardware.
- Fitur **Ambil Snapshot Progress (`createSnapshot`)** untuk menyimpan milestone kemajuan sisa unit yang perlu di-upgrade.
- Fitur **Cetak Laporan Formal (A4 Landscape)** dengan tata letak resmi PT Bestari Mulia, grafik summary, tabel rincian aset terjadwal upgrade, serta kolom tanda tangan verifikasi IT & Manajemen.


### Added
- Penambahan menu sidebar baru **Analisa Hardware -> CPU Intel (Non-Core)** untuk analisis & pemetaan penjadwalan upgrade perangkat PC/Laptop.
- Pengelompokan data spesifikasi CPU Intel non-Core (Pentium, Celeron, Atom, Dual Core) dengan informasi Pemakai, Perusahaan, RAM, Kategori, serta Status Asset.
- Fitur filter berdasarkan Perusahaan, Status Asset, dan Pencarian teks cepat beserta fitur Export data ke format CSV / Excel.


### Added
- Penambahan penampil aset 3 hari menjelang batas pengembalian (H-3) pada widget Dashboard Snipe-IT (`widget-overdue-loans`).

### Changed
- Mengubah judul widget menjadi "Aset Dipinjam Melewati / Mendekati Batas Kembali" dan memperbarui indikator status visual (Red untuk Terlambat, Yellow untuk Jatuh Tempo Hari Ini, Blue untuk H-1 s.d H-3).

## [1.1.0] - 2026-06-27 12:17
### Added
- Integrasi observer sinkronisasi lisensi CCTV (Kategori 16 ke Kategori 63).
- Widget stok komponen per kategori yang collapsible dan terurut berdasarkan sisa stok.
- Fitur live search pada widget stok komponen per kategori dengan pencarian dinamis (auto-expand & filter kategori/komponen).
- Widget riwayat mutasi masuk/keluar komponen baru (widget-component-mutations) pada kolom kiri dengan fitur live search.

### Changed
- Dashboard widget menjadi drag-and-drop sortable menggunakan jQuery UI.
- Menyusun ulang default urutan dashboard widget: Recent Activity & Stok Komponen di sebelah kiri, grafik status Pie Chart dipindah ke bagian akhir sebelah kanan.
- Mengubah key localStorage layout dashboard ke `_v3` untuk mereset posisi visual widget bagi pengguna lama agar mengikuti tata letak default yang baru.
- Memperbaiki kontras warna teks, link, dan baris tabel detail pada Dark Mode menggunakan CSS RGBA transparan.
- Memperkecil padding pembungkus kolom pencarian (6px) dan mengubah latar belakangnya menjadi transparan agar lebih ringkas dan menyatu dengan widget.
