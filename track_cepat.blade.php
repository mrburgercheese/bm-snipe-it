@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Track Cepat Aset IT & Komponen
    @parent
@stop

{{-- Page content --}}
@section('content')

<style nonce="{{ csrf_token() }}">
/* High-Contrast Styling for Header Titles & Card */
.track-card {
    background: #ffffff;
    border: 1px solid #dcdfe6;
    border-radius: 6px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    margin-bottom: 20px;
    overflow: hidden;
}
.track-card-header {
    background-color: #34495e !important;
    color: #ffffff !important;
    padding: 12px 18px !important;
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    border-bottom: 2px solid #1a252f !important;
}
.track-card-header h3,
.track-card-header .track-card-title {
    font-size: 16px !important;
    font-weight: 700 !important;
    margin: 0 !important;
    color: #ffffff !important;
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    text-shadow: 0 1px 2px rgba(0,0,0,0.4) !important;
}
.track-card-header i {
    color: #5d9cec !important;
}
.track-card-header .btn-header-link {
    background-color: #ffffff !important;
    color: #2c3e50 !important;
    font-weight: 700 !important;
    font-size: 12px !important;
    border-radius: 4px !important;
    padding: 4px 10px !important;
    border: none !important;
    box-shadow: 0 1px 3px rgba(0,0,0,0.2) !important;
}
.track-card-header .btn-header-link:hover {
    background-color: #f1f2f6 !important;
    color: #1e3799 !important;
}
.btn-guide-modal {
    background-color: #16a085 !important;
    color: #ffffff !important;
    font-weight: 700 !important;
    font-size: 12px !important;
    border-radius: 4px !important;
    padding: 5px 12px !important;
    border: none !important;
    box-shadow: 0 1px 3px rgba(0,0,0,0.2) !important;
    transition: all 0.2s ease !important;
}
.btn-guide-modal:hover {
    background-color: #1abc9c !important;
    color: #ffffff !important;
}
.track-card-body {
    padding: 0;
    font-size: 13px;
    color: #2c3e50;
}
.track-table {
    width: 100%;
    margin-bottom: 0;
    border-collapse: collapse;
}
.track-table th {
    background-color: #f8f9fa !important;
    color: #2c3e50 !important;
    font-weight: 700 !important;
    border-bottom: 2px solid #dee2e6 !important;
    padding: 10px 12px !important;
    font-size: 13px !important;
}
.track-table td {
    padding: 10px 12px !important;
    vertical-align: middle !important;
    border-top: 1px solid #e9ecef !important;
    color: #2c3e50 !important;
}
.badge-neutral {
    background-color: #6c757d !important;
    color: #ffffff !important;
    font-size: 12px !important;
    padding: 4px 8px !important;
    border-radius: 4px !important;
    font-weight: 600 !important;
    display: inline-block !important;
}
.badge-bs-active {
    background-color: #d9534f !important;
    color: #ffffff !important;
    font-size: 12px !important;
    padding: 4px 8px !important;
    border-radius: 4px !important;
    font-weight: 700 !important;
    text-decoration: none !important;
    display: inline-block !important;
}
.badge-fah-active {
    background-color: #0275d8 !important;
    color: #ffffff !important;
    font-size: 12px !important;
    padding: 4px 8px !important;
    border-radius: 4px !important;
    font-weight: 700 !important;
    text-decoration: none !important;
    display: inline-block !important;
}
.btn-toggle-custom {
    background-color: #4b6584 !important;
    color: #ffffff !important;
    border: none !important;
    padding: 8px 20px !important;
    font-weight: 700 !important;
    font-size: 13px !important;
    border-radius: 4px !important;
    transition: all 0.2s ease !important;
}
.btn-toggle-custom:hover {
    background-color: #3867d6 !important;
    color: #ffffff !important;
}
.notice-empty-red {
    text-align: center !important;
    color: #d9534f !important;
    font-weight: 700 !important;
    font-size: 14px !important;
    padding: 18px 12px !important;
    background-color: #fff5f5 !important;
}
/* Mode Filter Switcher */
.mode-pills-container {
    display: flex;
    gap: 8px;
    margin-bottom: 12px;
    flex-wrap: wrap;
}
.mode-pill-btn {
    background: #edf2f7;
    color: #4a5568;
    border: 1px solid #cbd5e0;
    border-radius: 20px;
    padding: 6px 16px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}
.mode-pill-btn:hover {
    background: #e2e8f0;
    color: #2d3748;
}
.mode-pill-btn.active {
    background: #2c3e50;
    color: #ffffff;
    border-color: #2c3e50;
    box-shadow: 0 2px 4px rgba(44,62,80,0.25);
}
/* Bento KPI Component */
.bento-kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 12px;
    padding: 14px;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
}
.bento-kpi-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    padding: 12px 14px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.03);
}
.bento-kpi-label {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    color: #64748b;
    margin-bottom: 4px;
}
.bento-kpi-val {
    font-size: 18px;
    font-weight: 800;
    color: #0f172a;
}
/* Modal Guidance Styling */
.modal-guide-step {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
    align-items: flex-start;
}
.modal-guide-step-icon {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background-color: #2c3e50;
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: bold;
    flex-shrink: 0;
}
.modal-guide-step-content h5 {
    margin: 0 0 6px 0;
    font-weight: 700;
    color: #2c3e50;
    font-size: 15px;
}
.modal-guide-step-content p {
    margin: 0;
    color: #555;
    font-size: 13px;
    line-height: 1.5;
}
</style>

<div class="row">
    <div class="col-md-12">
        <!-- Search Card -->
        <div class="track-card">
            <div class="track-card-header">
                <h3 class="track-card-title">
                    <i class="fa fa-crosshairs"></i> Track Cepat Aset IT & Komponen <span class="label label-info" style="font-size: 11px; margin-left: 8px; font-weight: normal; background-color: #2980b9 !important;"><i class="fa fa-code-fork"></i> v1.9.17 &bull; Update: 2026-10-02 12:45 WIB</span>
                </h3>
                <button type="button" class="btn btn-guide-modal" data-toggle="modal" data-target="#modal-panduan-track-cepat">
                    <i class="fa fa-book"></i> Panduan & Alur Kerja
                </button>
            </div>
            <div class="box-body" style="padding: 16px; background-color: #fdfdfd;">
                
                <!-- Filter Mode Pills -->
                <div class="mode-pills-container">
                    <span style="font-size: 13px; font-weight: 700; color: #4a5568; align-self: center; margin-right: 4px;">Target Pencarian:</span>
                    <button type="button" class="mode-pill-btn active" data-mode="all"><i class="fa fa-globe"></i> Semua (Auto-Detect)</button>
                    <button type="button" class="mode-pill-btn" data-mode="asset"><i class="fa fa-desktop"></i> Khusus Aset IT</button>
                    <button type="button" class="mode-pill-btn" data-mode="component"><i class="fa fa-puzzle-piece"></i> Khusus Komponen (COM-...)</button>
                </div>

                <p style="margin-bottom: 12px; color: #596275; font-size: 13.5px;">
                    Masukkan <strong>Kode Barang / Tag Aset</strong>, <strong>Kode Komponen</strong> (Contoh: <code>COM-260827001</code> / Serial RAM/SSD), <strong>Kode BS</strong> (Contoh: <code>BS-0814</code>), <strong>No. FAH</strong> (Contoh: <code>10//F-AH</code>), atau <strong>No. SJ</strong>.
                </p>

                <!-- Search Input Form -->
                <form id="form-track-cepat" onsubmit="return false;">
                    <div class="input-group input-group-lg">
                        <input type="text" id="track-input" class="form-control" placeholder="Scan Barcode / Ketik Tag Aset (PBM-...), Kode Komponen (COM-...), No. BS, No. FAH, atau Serial..." autocomplete="off" style="font-size: 15px; height: 46px; border-radius: 4px 0 0 4px; border: 1px solid #ced4da;">
                        <span class="input-group-btn">
                            <button type="button" id="btn-do-track" class="btn btn-primary btn-flat" style="height: 46px; padding: 0 24px; font-size: 15px; font-weight: 600; background-color: #2c3e50; border-color: #2c3e50;">
                                <i class="fa fa-search"></i> Lacak Sekarang
                            </button>
                        </span>
                    </div>
                </form>

                <!-- Quick Examples Chips -->
                <div style="margin-top: 10px; font-size: 12px; color: #64748b;">
                    <i class="fa fa-lightbulb-o text-warning"></i> <strong>Contoh Pencarian Cepat:</strong>
                    <a href="javascript:void(0);" class="quick-chip" data-q="PBM-250416001" style="margin-left: 5px; color: #2980b9; text-decoration: underline;">PBM-250416001</a> &bull;
                    <a href="javascript:void(0);" class="quick-chip" data-q="COM-260921001" style="color: #27ae60; text-decoration: underline; font-weight: bold;">COM-260921001 (Komponen)</a> &bull;
                    <a href="javascript:void(0);" class="quick-chip" data-q="BS-0814" style="color: #d35400; text-decoration: underline;">BS-0814</a> &bull;
                    <a href="javascript:void(0);" class="quick-chip" data-q="10//F-AH" style="color: #8e44ad; text-decoration: underline;">10//F-AH</a>
                </div>
            </div>
        </div>

        <!-- Result Container -->
        <div id="track-result-container" style="display: none;">
            <!-- Content injected dynamically via JS -->
        </div>

        <!-- Default Empty State Placeholder -->
        <div id="track-empty-placeholder" class="track-card" style="text-align: center; padding: 40px 20px;">
            <i class="fa fa-barcode" style="font-size: 54px; margin-bottom: 12px; color: #a5b1c2;"></i>
            <h4 style="color: #4b6584; font-weight: 700; margin-bottom: 6px;">Siap Mengidentifikasi Tag Aset IT & Kode Komponen</h4>
            <p style="color: #778ca3; max-width: 550px; margin: 0 auto; font-size: 13px;">
                Gunakan kolom pencarian di atas atau scan barcode untuk menampilkan data komprehensif Aset IT (FAH, BS, SJ, Histori) atau Kartu Stok Komponen (Unit Penampung & Mutasi).
            </p>
        </div>
    </div>
</div>

<!-- Modal Panduan & Alur Kerja Track Cepat -->
<div class="modal fade" id="modal-panduan-track-cepat" tabindex="-1" role="dialog" aria-labelledby="modalPanduanLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 6px; overflow: hidden;">
            <div class="modal-header" style="background-color: #2c3e50; color: #ffffff; padding: 14px 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff; opacity: 0.9;"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalPanduanLabel" style="font-weight: 700; font-size: 17px;">
                    <i class="fa fa-map-signs text-info"></i> Panduan Penggunaan & Alur Kerja Fitur Track Cepat <span class="label label-primary" style="font-size: 11px; font-weight: normal; margin-left: 5px;"><i class="fa fa-tag"></i> v1.9.17</span>
                </h4>
            </div>
            <div class="modal-body" style="padding: 24px; background-color: #fcfcfc;">
                
                <div style="background-color: #eef2f7; border-left: 4px solid #3498db; padding: 12px 16px; border-radius: 4px; margin-bottom: 24px;">
                    <strong style="color: #2c3e50; font-size: 14px;"><i class="fa fa-lightbulb-o text-warning"></i> Apa itu Modul Track Cepat Terpadu?</strong>
                    <p style="margin-top: 4px; margin-bottom: 0; color: #4a5568; font-size: 13px;">
                        Modul Track Cepat adalah mesin pelacak terpadu 1-pintu di Snipe-IT untuk menelusuri seluruh siklus hidup <strong>Aset Hardware</strong> (Data Fisik, FAH, Komponen Terpasang, Berita Acara BS, Surat Jalan, dan Log Audit) serta <strong>Master Komponen</strong> (Stok Tersedia, Unit PC Penampung, dan Log Mutasi Checkout/Checkin).
                    </p>
                </div>

                <h4 style="font-weight: 700; color: #2c3e50; margin-bottom: 18px; font-size: 15px; border-bottom: 2px solid #edf2f7; padding-bottom: 8px;">
                    <i class="fa fa-tasks text-primary"></i> Alur Kerja & Fleksibilitas Kata Kunci Pencarian:
                </h4>

                <!-- Step 1 -->
                <div class="modal-guide-step">
                    <div class="modal-guide-step-icon" style="background-color: #34495e;">1</div>
                    <div class="modal-guide-step-content">
                        <h5>Omni-Search Engine (Aset IT & Komponen)</h5>
                        <p>
                            Pengguna dapat memasukkan berbagai jenis kata kunci pada 1 kolom pencarian utama:
                            <br>&bull; <strong>Tag Aset / Barcode</strong> (Contoh: <code>PBM-250416001</code> / <code>170714104142</code>)
                            <br>&bull; <strong>Kode Komponen / Serial</strong> (Contoh: <code>COM-260921001</code> / SN Hardisk / RAM / SSD) &rarr; <em>Otomatis membuka Kartu Stok & Daftar PC Penampung!</em>
                            <br>&bull; <strong>Kode BS (Berita Acara Barang Rusak)</strong> (Contoh: <code>BS-0814</code> / <code>BS-0835</code>) &rarr; <em>Reverse Lookup ke aset pemilik BS!</em>
                            <br>&bull; <strong>No. FAH (Form Analisa Hardware)</strong> (Contoh: <code>10//F-AH</code>) &rarr; <em>Reverse Lookup ke aset pemilik FAH!</em>
                            <br>&bull; <strong>No. Surat Jalan (Barang Keluar)</strong> (Contoh: <code>IT-K-2608-00005</code>)
                        </p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="modal-guide-step">
                    <div class="modal-guide-step-icon" style="background-color: #27ae60;">2</div>
                    <div class="modal-guide-step-content">
                        <h5>Pencarian Komponen (Dashboard & Kartu Stok)</h5>
                        <p>
                            Jika query cocok dengan Komponen, sistem menampilkan:
                            <br>&bull; <strong>Bento KPI Stok</strong>: Total Stok, Jumlah Terpasang di PC, Sisa Stok Tersedia (Ready), dan Kategori.
                            <br>&bull; <strong>Tabel Unit Aset Penampung</strong>: Daftar seluruh PC/Laptop yang sedang menggunakan komponen tersebut lengkap dengan PIC dan lokasinya.
                            <br>&bull; <strong>Histori Mutasi</strong>: Catatan kapan komponen di-checkout ke aset atau di-checkin kembali.
                        </p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="modal-guide-step">
                    <div class="modal-guide-step-icon" style="background-color: #2980b9;">3</div>
                    <div class="modal-guide-step-content">
                        <h5>Pencarian Aset IT (5 Seksi Lengkap + Komponen Terpasang)</h5>
                        <p>
                            Jika query adalah Tag Aset, sistem menyajikan:
                            <br>&bull; <strong>Seksi 1: Data di Snipe-IT</strong> (Fisik, Foto, Status, PIC, Lokasi).
                            <br>&bull; <strong>Seksi 2: Data di FAH</strong> (Spesifikasi CPU, RAM, Disk, OS, IP/MAC, McAfee).
                            <br>&bull; <strong>Seksi 2.5: Komponen Tambahan Terpasang</strong> (Daftar RAM/SSD/Hardware yang di-checkout ke unit ini).
                            <br>&bull; <strong>Seksi 3: Data di BS</strong> (Berita Acara Kerusakan dari portal BMKB).
                            <br>&bull; <strong>Seksi 4: Data Barang Keluar</strong> (Surat Jalan pengiriman).
                            <br>&bull; <strong>Seksi 5: Histori Log & Audit Trail Native</strong>.
                        </p>
                    </div>
                </div>

            </div>
            <div class="modal-footer" style="background-color: #f1f2f6; padding: 12px 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                    <span class="text-muted" style="font-size: 12px;"><i class="fa fa-clock-o"></i> <strong>Modul Track Cepat:</strong> Version 1.9.17 &bull; Last Updated: 2026-10-02 12:45 WIB</span>
                    <button type="button" class="btn btn-default font-weight-bold" data-dismiss="modal" style="font-weight: 700;">Tutup Panduan</button>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('moar_scripts')
<script nonce="{{ csrf_token() }}">
$(document).ready(function() {
    var selectedMode = 'all';

    $("#track-input").focus();

    // Mode Switcher Pills
    $(".mode-pill-btn").on("click", function() {
        $(".mode-pill-btn").removeClass("active");
        $(this).addClass("active");
        selectedMode = $(this).data("mode");

        if (selectedMode === 'component') {
            $("#track-input").attr("placeholder", "Scan Barcode / Ketik Kode Komponen (COM-...), Serial Number RAM/SSD, atau Nama Komponen...");
        } else if (selectedMode === 'asset') {
            $("#track-input").attr("placeholder", "Scan Barcode / Ketik Tag Aset (PBM-...), Serial PC/Laptop, No. BS, atau No. FAH...");
        } else {
            $("#track-input").attr("placeholder", "Scan Barcode / Ketik Tag Aset (PBM-...), Kode Komponen (COM-...), No. BS, No. FAH, atau Serial...");
        }
        $("#track-input").focus();
    });

    // Quick Chips click
    $(".quick-chip").on("click", function() {
        var q = $(this).data("q");
        $("#track-input").val(q);
        performTrackSearch(q);
    });

    var urlParams = new URLSearchParams(window.location.search);
    var initialQuery = urlParams.get('q') || urlParams.get('query');
    if (initialQuery) {
        $("#track-input").val(initialQuery);
        performTrackSearch(initialQuery);
    }

    $("#btn-do-track").on("click", function() {
        var q = $("#track-input").val().trim();
        if (!q) {
            alert("Harap masukkan Tag Aset, Kode Komponen, atau Serial Number!");
            return;
        }
        performTrackSearch(q);
    });

    $("#track-input").on("keypress", function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $("#btn-do-track").click();
            return false;
        }
    });

    // Delegated event for toggle Section 5 History Log
    $(document).on("click", "#btn-toggle-section4-history", function() {
        var container = $("#section4-history-container");
        var btn = $(this);
        if (container.is(":visible")) {
            container.slideUp(250);
            btn.html('<i class="fa fa-chevron-down"></i> Tampilkan Detail Histori Maintenance & Action Logs (' + btn.data("maint-count") + ' Record, ' + btn.data("log-count") + ' Log)');
        } else {
            container.slideDown(250);
            btn.html('<i class="fa fa-chevron-up"></i> Sembunyikan Detail Histori Log');
        }
    });

    function performTrackSearch(q) {
        $("#track-empty-placeholder").hide();
        var container = $("#track-result-container");
        container.html('<div class="track-card" style="text-align: center; padding: 40px;"><i class="fa fa-spinner fa-spin fa-2x text-primary"></i><h4 style="margin-top: 12px; color: #4b6584; font-size: 15px;">Memuat data tracking...</h4></div>').show();

        $.ajax({
            url: "{{ route('custom.track_cepat.search') }}",
            type: "GET",
            data: { 
                query: q,
                mode: selectedMode
            },
            success: function(data) {
                if (data.result_type === 'component') {
                    renderComponentResult(data);
                } else {
                    renderAssetResult(data);
                }
            },
            error: function(xhr) {
                var msg = "Terjadi kesalahan saat mencari data.";
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    msg = xhr.responseJSON.error;
                }
                container.html('<div class="alert alert-danger" style="font-size: 14px;"><i class="fa fa-exclamation-triangle"></i> ' + msg + '</div>');
            }
        });
    }

    // =======================================================
    // RENDER COMPONENT RESULT VIEW
    // =======================================================
    function renderComponentResult(data) {
        var comp = data.component;
        var assignedAssets = data.assigned_assets || [];
        var logs = data.logs || [];

        var html = '';

        // Header Banner Info
        html += '<div class="alert alert-info" style="font-size: 13.5px; font-weight: 600; border-left: 5px solid #27ae60; background-color: #f0fdf4; color: #166534; margin-bottom: 16px; border-radius: 6px; padding: 12px 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">' +
                '<div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">' +
                '<div><i class="fa fa-puzzle-piece" style="font-size: 18px; margin-right: 6px; color: #27ae60 !important;"></i>' +
                '<strong>HASIL TRACKING KOMPONEN:</strong> Menampilkan spesifikasi master, alokasi unit penampung, dan riwayat mutasi stok.' +
                '</div>' +
                '<span class="label label-success" style="font-size: 11px; padding: 4px 8px;"><i class="fa fa-check-circle"></i> Tipe: Komponen Hardware</span>' +
                '</div></div>';

        // SECTION 1: MASTER DATA & STOK KOMPONEN
        html += '<div class="track-card">';
        html += '  <div class="track-card-header" style="background-color: #1e3a8a !important; border-bottom: 2px solid #172554 !important;">';
        html += '    <h3 class="track-card-title"><i class="fa fa-cube" style="color: #60a5fa !important;"></i> 1. DATA MASTER & KARTU STOK KOMPONEN</h3>';
        html += '    <a href="' + comp.component_url + '" target="_blank" class="btn btn-header-link"><i class="fa fa-external-link"></i> Buka Detail Komponen</a>';
        html += '  </div>';

        // Bento KPI Bar
        html += '  <div class="bento-kpi-grid">';
        html += '    <div class="bento-kpi-card">';
        html += '      <div class="bento-kpi-label"><i class="fa fa-cubes text-primary"></i> Total Kuantitas</div>';
        html += '      <div class="bento-kpi-val" style="color: #1e3a8a;">' + comp.total_qty + ' <small style="font-size: 12px; font-weight: normal; color: #64748b;">Unit</small></div>';
        html += '    </div>';
        html += '    <div class="bento-kpi-card">';
        html += '      <div class="bento-kpi-label"><i class="fa fa-desktop text-warning"></i> Terpasang di Aset</div>';
        html += '      <div class="bento-kpi-val" style="color: #d97706;">' + comp.assigned_qty + ' <small style="font-size: 12px; font-weight: normal; color: #64748b;">Unit</small></div>';
        html += '    </div>';
        html += '    <div class="bento-kpi-card">';
        html += '      <div class="bento-kpi-label"><i class="fa fa-check-circle text-success"></i> Sisa Stok Tersedia</div>';
        var remColor = comp.remaining_qty > 0 ? '#16a34a' : '#dc2626';
        html += '      <div class="bento-kpi-val" style="color: ' + remColor + ';">' + comp.remaining_qty + ' <small style="font-size: 12px; font-weight: normal; color: #64748b;">Unit</small></div>';
        html += '    </div>';
        html += '    <div class="bento-kpi-card">';
        html += '      <div class="bento-kpi-label"><i class="fa fa-tags text-info"></i> Kategori</div>';
        html += '      <div class="bento-kpi-val" style="font-size: 14px; font-weight: 700; color: #334155; margin-top: 4px;">' + comp.category + '</div>';
        html += '    </div>';
        html += '  </div>';

        html += '  <div class="track-card-body">';
        html += '    <div class="table-responsive">';
        html += '      <table class="track-table table-bordered table-striped">';
        html += '        <thead>';
        html += '          <tr>';
        html += '            <th style="width: 15%;">Kode / Serial Komponen</th>';
        html += '            <th style="width: 25%;">Nama Komponen & Foto</th>';
        html += '            <th style="width: 15%;">Model / Part No.</th>';
        html += '            <th style="width: 15%;">Company & Lokasi Simpan</th>';
        html += '            <th style="width: 15%;">Pembelian & Harga</th>';
        html += '            <th style="width: 15%;">Catatan / Notes</th>';
        html += '          </tr>';
        html += '        </thead>';
        html += '        <tbody>';
        html += '          <tr>';
        html += '            <td><a href="' + comp.component_url + '" target="_blank" class="label label-success" style="font-size: 12px; padding: 4px 8px;" title="Buka Detail Komponen"><i class="fa fa-barcode"></i> ' + comp.serial + ' <i class="fa fa-external-link" style="font-size: 9px;"></i></a></td>';
        html += '            <td>';
        html += '              <div style="display: flex; gap: 10px; align-items: center;">';
        html += '                <img src="' + comp.image_url + '" alt="Foto" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; border: 1px solid #ced4da;">';
        html += '                <strong style="color: #2c3e50; font-size: 14px;">' + comp.name + '</strong>';
        html += '              </div>';
        html += '            </td>';
        html += '            <td>' + comp.model_number + '</td>';
        html += '            <td><strong>' + comp.company + '</strong><br><small class="text-muted"><i class="fa fa-map-marker text-red"></i> ' + comp.location + '</small></td>';
        html += '            <td><i class="fa fa-calendar text-muted"></i> ' + comp.purchase_date + '<br><small class="text-muted">Biaya: ' + comp.purchase_cost + '</small></td>';
        html += '            <td>' + comp.notes + '</td>';
        html += '          </tr>';
        html += '        </tbody>';
        html += '      </table>';
        html += '    </div>';
        html += '  </div>';
        html += '</div>';

        // SECTION 2: DAFTAR UNIT ASET PENAMPUNG (ASSIGNED TO ASSETS)
        html += '<div class="track-card">';
        html += '  <div class="track-card-header">';
        html += '    <h3 class="track-card-title"><i class="fa fa-desktop"></i> 2. DAFTAR UNIT ASET YANG MENGGUNAKAN KOMPONEN INI (' + assignedAssets.length + ' Unit Aset Terpasang)</h3>';
        html += '  </div>';
        html += '  <div class="track-card-body">';
        html += '    <div class="table-responsive">';
        html += '      <table class="track-table table-bordered table-striped">';
        html += '        <thead>';
        html += '          <tr>';
        html += '            <th style="width: 5%;">#</th>';
        html += '            <th style="width: 15%;">Kode Barang / Asset Tag</th>';
        html += '            <th style="width: 22%;">Nama Unit Aset</th>';
        html += '            <th style="width: 12%;">Status Aset</th>';
        html += '            <th style="width: 15%;">Lokasi Penempatan</th>';
        html += '            <th style="width: 15%;">PIC / Pengguna</th>';
        html += '            <th style="width: 8%; text-align: center;">Qty Pasang</th>';
        html += '            <th style="width: 8%;">Tgl Pasang</th>';
        html += '          </tr>';
        html += '        </thead>';
        html += '        <tbody>';

        if (assignedAssets.length > 0) {
            $.each(assignedAssets, function(idx, a) {
                html += '          <tr>';
                html += '            <td>' + (idx + 1) + '</td>';
                html += '            <td><a href="' + a.asset_url + '" target="_blank" class="label label-primary" style="font-size: 12px; padding: 4px 8px;"><i class="fa fa-barcode"></i> ' + a.asset_tag + ' <i class="fa fa-external-link" style="font-size: 9px;"></i></a></td>';
                html += '            <td><strong>' + a.asset_name + '</strong><br><small class="text-muted">' + a.category_name + ' (' + a.model_name + ')</small></td>';
                html += '            <td><span class="label" style="background-color: ' + a.status_color + '; font-size: 11px; padding: 3px 6px;">' + a.status_name + '</span></td>';
                html += '            <td><i class="fa fa-map-marker text-red"></i> ' + a.location_name + '<br><small class="text-muted">' + a.company_name + '</small></td>';
                html += '            <td><i class="fa fa-user text-muted"></i> <strong>' + a.assigned_user + '</strong></td>';
                html += '            <td style="text-align: center;"><span class="badge" style="background-color: #2c3e50; font-size: 12px;">' + a.assigned_qty + '</span></td>';
                html += '            <td><i class="fa fa-clock-o text-muted"></i> ' + a.assigned_date + '</td>';
                html += '          </tr>';
            });
        } else {
            html += '          <tr>';
            html += '            <td colspan="8" style="text-align: center; padding: 24px; color: #64748b; background-color: #f8fafc; font-weight: 600;">';
            html += '              <i class="fa fa-info-circle text-primary" style="font-size: 18px; margin-right: 6px;"></i> Komponen ini saat ini masih berada di stok gudang IT (belum terpasang pada unit aset manapun).';
            html += '            </td>';
            html += '          </tr>';
        }

        html += '        </tbody>';
        html += '      </table>';
        html += '    </div>';
        html += '  </div>';
        html += '</div>';

        // SECTION 3: RIWAYAT MUTASI & LOG AKTIVITAS KOMPONEN
        html += '<div class="track-card">';
        html += '  <div class="track-card-header">';
        html += '    <h3 class="track-card-title"><i class="fa fa-history"></i> 3. RIWAYAT MUTASI & LOG AKTIVITAS KOMPONEN</h3>';
        html += '    <a href="' + comp.history_url + '" target="_blank" class="btn btn-header-link"><i class="fa fa-external-link"></i> Buka Log Komponen</a>';
        html += '  </div>';
        html += '  <div class="track-card-body" style="padding: 14px;">';

        if (logs.length > 0) {
            html += '    <div class="table-responsive">';
            html += '      <table class="track-table table-bordered table-striped">';
            html += '        <thead>';
            html += '          <tr>';
            html += '            <th style="width: 15%;">Waktu Eksekusi</th>';
            html += '            <th style="width: 18%;">Eksekutor (Admin)</th>';
            html += '            <th style="width: 15%;">Tipe Aksi</th>';
            html += '            <th style="width: 25%;">Target Unit / Lokasi</th>';
            html += '            <th style="width: 27%;">Catatan / Keterangan</th>';
            html += '          </tr>';
            html += '        </thead>';
            html += '        <tbody>';
            $.each(logs, function(idx, l) {
                var actionBadge = '<span class="label label-default">' + l.action + '</span>';
                if (l.action === 'checkout') actionBadge = '<span class="label label-success">checkout to asset</span>';
                else if (l.action === 'checkin from' || l.action === 'checkin') actionBadge = '<span class="label label-info">checkin from asset</span>';
                else if (l.action === 'create') actionBadge = '<span class="label label-primary">create</span>';
                else if (l.action === 'update') actionBadge = '<span class="label label-default" style="background-color: #8e44ad;">update</span>';

                html += '          <tr>';
                html += '            <td><i class="fa fa-clock-o text-muted"></i> ' + l.created_at + '</td>';
                html += '            <td><strong style="color: #27ae60;"><i class="fa fa-user"></i> ' + l.admin_name + '</strong></td>';
                html += '            <td>' + actionBadge + '</td>';
                html += '            <td><i class="fa fa-desktop text-primary"></i> <strong>' + l.target_name + '</strong></td>';
                html += '            <td>' + l.note + '</td>';
                html += '          </tr>';
            });
            html += '        </tbody>';
            html += '      </table>';
            html += '    </div>';
        } else {
            html += '    <div style="padding: 16px; text-align: center; color: #64748b; background-color: #fafafa; border: 1px solid #e9ecef; border-radius: 4px;"><i class="fa fa-info-circle"></i> Belum ada rekaman log mutasi untuk komponen ini.</div>';
        }

        html += '  </div>';
        html += '</div>';

        $("#track-result-container").html(html).fadeIn(250);
    }

    // =======================================================
    // RENDER ASSET RESULT VIEW
    // =======================================================
    function renderAssetResult(data) {
        var asset = data.asset;
        var fah = data.fah_specs;
        var installedComps = data.installed_components || [];
        var maints = data.maintenances || [];
        var logs = data.logs || [];

        var html = '';

        // Soft Deleted Alert Banner (Hanya muncul jika aset memang BENAR-BENAR TERHAPUS / DIARSIPKAN)
        if (asset.is_deleted) {
            html += '<div class="alert alert-warning" style="font-size: 13.5px; font-weight: 600; border-left: 5px solid #d35400; background-color: #fef9e7; color: #7d5a00; margin-bottom: 16px; border-radius: 6px; padding: 12px 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">' +
                    '<div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">' +
                    '<div><i class="fa fa-archive text-warning" style="font-size: 16px; margin-right: 6px; color: #d35400 !important;"></i>' +
                    '<strong>REKAMAN ARSIP SISTEM:</strong> Aset ini telah dihapus/diarsipkan pada <strong>' + (asset.deleted_at || '-') + '</strong>.' +
                    '<div style="font-size: 12px; color: #935116; margin-top: 2px;">Menampilkan data spek & histori terakhir unit sebelum dinonaktifkan dari sistem aktif.</div></div>' +
                    '<span class="label label-danger" style="font-size: 11px; padding: 4px 8px;"><i class="fa fa-trash"></i> Status: Diarsipkan / Trash</span>' +
                    '</div></div>';
        }

        // Badge tambahan jika aset aktif memiliki riwayat arsip re-create
        var trashedHistoryNotice = (asset.has_trashed_history && !asset.is_deleted)
            ? '<br><span class="label label-default" style="font-size: 10px; background-color: #64748b !important; margin-top: 4px; display: inline-block; padding: 2px 6px;" title="Aset ini aktif dan memiliki riwayat pembuatan ulang dari data arsip tahun 2023"><i class="fa fa-history"></i> Memiliki arsip re-create 2023</span>'
            : '';

        // ==========================================
        // SECTION 1: DATA DI SNIPE-IT
        // ==========================================
        html += '<div class="track-card">';
        html += '  <div class="track-card-header">';
        html += '    <h3 class="track-card-title"><i class="fa fa-database"></i> 1. DATA DI SNIPE-IT</h3>';
        html += '    <a href="' + asset.asset_url + '" target="_blank" class="btn btn-header-link"><i class="fa fa-external-link"></i> Buka Detail Aset</a>';
        html += '  </div>';
        html += '  <div class="track-card-body">';
        html += '    <div class="table-responsive">';
        html += '      <table class="track-table table-bordered table-striped">';
        html += '        <thead>';
        html += '          <tr>';
        html += '            <th style="width: 15%;">Kode Barang / Asset Tag</th>';
        html += '            <th style="width: 20%;">Nama Barang & Foto</th>';
        html += '            <th style="width: 12%;">Status Barang</th>';
        html += '            <th style="width: 10%;">Kategori</th>';
        html += '            <th style="width: 10%;">Model</th>';
        html += '            <th style="width: 13%;">Company</th>';
        html += '            <th style="width: 10%;">Lokasi Fisik</th>';
        html += '            <th style="width: 10%;">Last Update / Action</th>';
        html += '          </tr>';
        html += '        </thead>';
        html += '        <tbody>';
        html += '          <tr>';
        html += '            <td><a href="' + asset.asset_url + '" target="_blank" class="label label-primary" style="font-size: 12px; padding: 4px 8px;" title="Klik untuk membuka Halaman Aset Snipe-IT"><i class="fa fa-barcode"></i> ' + asset.asset_tag + ' <i class="fa fa-external-link" style="font-size: 9px;"></i></a><br><small class="text-muted">SN: ' + (asset.serial || '-') + '</small>' + trashedHistoryNotice + '</td>';
        html += '            <td>';
        html += '              <div style="display: flex; gap: 10px; align-items: center;">';
        html += '                <img src="' + asset.image_url + '" alt="Foto" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; border: 1px solid #ced4da;">';
        html += '                <strong style="color: #2c3e50;">' + asset.name + '</strong>';
        html += '              </div>';
        html += '            </td>';
        html += '            <td><span class="label" style="background-color: ' + (asset.status_color || '#999') + '; font-size: 12px; padding: 4px 8px;">' + (asset.status_name || '-') + '</span></td>';
        html += '            <td>' + (asset.category || '-') + '</td>';
        html += '            <td>' + (asset.model || '-') + '</td>';
        html += '            <td>' + (asset.company || '-') + '</td>';
        html += '            <td><i class="fa fa-map-marker text-red"></i> ' + (asset.location || '-') + '</td>';
        html += '            <td><i class="fa fa-clock-o text-muted"></i> ' + (asset.last_action_date || '-') + '<br><small class="label label-default">' + (asset.last_action_type || '-') + '</small></td>';
        html += '          </tr>';
        html += '        </tbody>';
        html += '      </table>';
        html += '    </div>';
        html += '  </div>';
        html += '</div>';

        // ==========================================
        // SECTION 2: DATA DI FAH (FORM ANALISA HARDWARE)
        // ==========================================
        var hasFahData = (fah.fah_number !== '-' || (fah.processor !== '-' && fah.processor !== '' && fah.processor !== null));
        var fahLinkUrl = fah.fah_url + '?search=' + encodeURIComponent(asset.asset_tag);

        html += '<div class="track-card">';
        html += '  <div class="track-card-header">';
        html += '    <h3 class="track-card-title"><i class="fa fa-laptop"></i> 2. DATA DI FAH (FORM ANALISA HARDWARE)</h3>';
        html += '    <a href="' + fahLinkUrl + '" target="_blank" class="btn btn-header-link"><i class="fa fa-external-link"></i> Buka Dashboard FAH</a>';
        html += '  </div>';
        html += '  <div class="track-card-body">';
        html += '    <div class="table-responsive">';
        html += '      <table class="track-table table-bordered table-striped">';
        html += '        <thead>';
        html += '          <tr>';
        html += '            <th style="width: 15%;">Kode Barang / Asset Tag</th>';
        html += '            <th style="width: 18%;">Nama Barang</th>';
        html += '            <th style="width: 17%;">No. FAH (Hyperlink)</th>';
        html += '            <th style="width: 12%;">Tanggal Input FAH</th>';
        html += '            <th style="width: 38%;">Rincian Spek Hardware</th>';
        html += '          </tr>';
        html += '        </thead>';
        html += '        <tbody>';

        if (hasFahData) {
            html += '          <tr>';
            html += '            <td><a href="' + asset.asset_url + '" target="_blank" class="label label-primary" style="font-size: 12px; padding: 4px 8px;"><i class="fa fa-barcode"></i> ' + asset.asset_tag + ' <i class="fa fa-external-link" style="font-size: 9px;"></i></a></td>';
            html += '            <td><strong>' + asset.name + '</strong></td>';
            
            var fahNumberBadge = fah.fah_number !== '-' 
                ? '<a href="' + fahLinkUrl + '" target="_blank" class="badge-fah-active" title="Klik untuk membuka Halaman Analisa Hardware FAH"><i class="fa fa-file-text"></i> ' + fah.fah_number + ' <i class="fa fa-external-link" style="font-size: 9px;"></i></a>' 
                : '<span class="badge-neutral">Data Tidak Ada di FAH</span>';
            html += '            <td>' + fahNumberBadge + '</td>';
            html += '            <td><i class="fa fa-calendar text-muted"></i> ' + (fah.fah_date || '-') + '</td>';
            
            var mcafeeBadge = fah.antivirus_mcafee === 'AKTIF' 
                ? '<span class="label label-success" style="font-size: 11px;">McAfee: AKTIF</span>' 
                : (fah.antivirus_mcafee === 'TIDAK AKTIF' ? '<span class="label label-danger" style="font-size: 11px;">McAfee: TIDAK AKTIF</span>' : '');
                
            var spekSummary = '<div><i class="fa fa-microchip text-primary"></i> <strong>CPU:</strong> ' + (fah.processor || '-') + ' | <i class="fa fa-cube text-success"></i> <strong>RAM:</strong> ' + (fah.ram_jenis || '-') + ' (' + (fah.ram_kapasitas || '-') + ')</div>' +
                              '<div><i class="fa fa-hdd-o text-warning"></i> <strong>Disk:</strong> ' + (fah.disk_jenis || '-') + ' (' + (fah.disk_kapasitas || '-') + ') | <i class="fa fa-windows text-info"></i> <strong>OS:</strong> ' + (fah.os || '-') + '</div>' +
                              '<div><i class="fa fa-globe text-purple"></i> <strong>IP:</strong> <code>' + (fah.ip_address || '-') + '</code> | <strong>MAC:</strong> <code>' + (fah.mac_address || '-') + '</code> ' + mcafeeBadge + '</div>';
            html += '            <td>' + spekSummary + '</td>';
            html += '          </tr>';
        } else {
            html += '          <tr>';
            html += '            <td colspan="5" class="notice-empty-red">';
            html += '              <i class="fa fa-exclamation-triangle text-red"></i> BELUM ADA DATA FAH (Form Analisa Hardware)';
            html += '            </td>';
            html += '          </tr>';
        }

        html += '        </tbody>';
        html += '      </table>';
        html += '    </div>';
        html += '  </div>';
        html += '</div>';

        // ==========================================
        // SECTION 2.5: KOMPONEN TAMBAHAN TERPASANG (RAM / SSD / HARDWARE)
        // ==========================================
        html += '<div class="track-card">';
        html += '  <div class="track-card-header" style="background-color: #2e7d32 !important; border-bottom: 2px solid #1b5e20 !important;">';
        html += '    <h3 class="track-card-title"><i class="fa fa-puzzle-piece" style="color: #a5d6a7 !important;"></i> 2.5. KOMPONEN TAMBAHAN TERPASANG (' + installedComps.length + ' Komponen di Unit Ini)</h3>';
        html += '  </div>';
        html += '  <div class="track-card-body">';
        html += '    <div class="table-responsive">';
        html += '      <table class="track-table table-bordered table-striped">';
        html += '        <thead>';
        html += '          <tr>';
        html += '            <th style="width: 5%;">#</th>';
        html += '            <th style="width: 25%;">Nama Komponen</th>';
        html += '            <th style="width: 18%;">Kode / Serial Komponen</th>';
        html += '            <th style="width: 15%;">Kategori</th>';
        html += '            <th style="width: 15%;">Model / Part No.</th>';
        html += '            <th style="width: 8%; text-align: center;">Qty</th>';
        html += '            <th style="width: 14%;">Tanggal Pemasangan</th>';
        html += '          </tr>';
        html += '        </thead>';
        html += '        <tbody>';

        if (installedComps.length > 0) {
            $.each(installedComps, function(idx, c) {
                html += '          <tr>';
                html += '            <td>' + (idx + 1) + '</td>';
                html += '            <td><strong style="color: #2c3e50;"><i class="fa fa-cube text-success"></i> ' + c.component_name + '</strong></td>';
                html += '            <td><a href="' + c.component_url + '" target="_blank" class="label label-success" style="font-size: 11px; padding: 3px 6px;"><i class="fa fa-barcode"></i> ' + c.component_serial + ' <i class="fa fa-external-link" style="font-size: 9px;"></i></a></td>';
                html += '            <td>' + c.category_name + '</td>';
                html += '            <td>' + c.model_number + '</td>';
                html += '            <td style="text-align: center;"><span class="badge" style="background-color: #2e7d32; font-size: 12px;">' + c.assigned_qty + '</span></td>';
                html += '            <td><i class="fa fa-clock-o text-muted"></i> ' + c.installed_date + '</td>';
                html += '          </tr>';
            });
        } else {
            html += '          <tr>';
            html += '            <td colspan="7" style="text-align: center; padding: 18px; color: #64748b; background-color: #f8fafc; font-weight: 600;">';
            html += '              <i class="fa fa-info-circle text-info" style="font-size: 16px; margin-right: 5px;"></i> Tidak ada komponen tambahan (RAM/SSD) yang di-checkout secara manual ke unit aset ini.';
            html += '            </td>';
            html += '          </tr>';
        }

        html += '        </tbody>';
        html += '      </table>';
        html += '    </div>';
        html += '  </div>';
        html += '</div>';

        // ==========================================
        // SECTION 3: DATA DI BS (BERITA ACARA BARANG RUSAK)
        // ==========================================
        var bsList = asset.bs_records || [];
        var hasBsData = (bsList.length > 0 || asset.bs_code !== '-');
        
        if (bsList.length === 0 && asset.bs_code !== '-') {
            bsList = [{ bs_code: asset.bs_code, bs_date: asset.bs_date, notes: asset.notes }];
        }

        var headerBsTitle = '3. DATA DI BS (BERITA ACARA BARANG RUSAK)';
        if (bsList.length > 1) {
            headerBsTitle += ' (' + bsList.length + ' Dokumen BS Terdaftar)';
        }

        var bsBmkbSearchUrl = 'https://bmkb.royalcorp.co.id/?s=' + encodeURIComponent(hasBsData ? (bsList[0] ? bsList[0].bs_code : asset.asset_tag) : asset.asset_tag);

        html += '<div class="track-card">';
        html += '  <div class="track-card-header">';
        html += '    <h3 class="track-card-title"><i class="fa fa-ban"></i> ' + headerBsTitle + '</h3>';
        html += '    <a href="' + bsBmkbSearchUrl + '" target="_blank" class="btn btn-header-link"><i class="fa fa-external-link"></i> Cari Dokumen BS di BMKB</a>';
        html += '  </div>';
        html += '  <div class="track-card-body">';
        html += '    <div class="table-responsive">';
        html += '      <table class="track-table table-bordered table-striped">';
        html += '        <thead>';
        html += '          <tr>';
        html += '            <th style="width: 15%;">Kode Barang / Asset Tag</th>';
        html += '            <th style="width: 20%;">Nama Barang</th>';
        html += '            <th style="width: 15%;">Kode BS (Hyperlink)</th>';
        html += '            <th style="width: 15%;">Tanggal Input BS</th>';
        html += '            <th style="width: 35%;">Catatan Kerusakan / Keluhan Unit</th>';
        html += '          </tr>';
        html += '        </thead>';
        html += '        <tbody>';

        if (hasBsData && bsList.length > 0) {
            $.each(bsList, function(bIdx, bItem) {
                var singleBsUrl = 'https://bmkb.royalcorp.co.id/?s=' + encodeURIComponent(bItem.bs_code);
                var bsBadge = '<a href="' + singleBsUrl + '" target="_blank" class="badge-bs-active" title="Klik untuk membuka/mencari dokumen Berita Acara ' + bItem.bs_code + ' di Portal BMKB"><i class="fa fa-ban"></i> ' + bItem.bs_code + ' <i class="fa fa-external-link" style="font-size: 9px;"></i></a>';
                
                html += '          <tr>';
                html += '            <td><a href="' + asset.asset_url + '" target="_blank" class="label label-primary" style="font-size: 12px; padding: 4px 8px;"><i class="fa fa-barcode"></i> ' + asset.asset_tag + ' <i class="fa fa-external-link" style="font-size: 9px;"></i></a></td>';
                html += '            <td><strong>' + asset.name + '</strong></td>';
                html += '            <td>' + bsBadge + '</td>';
                html += '            <td><i class="fa fa-calendar text-muted"></i> ' + (bItem.bs_date || '-') + '</td>';
                html += '            <td>' + (bItem.notes || '-') + '</td>';
                html += '          </tr>';
            });
        } else {
            html += '          <tr>';
            html += '            <td colspan="5" class="notice-empty-red">';
            html += '              <i class="fa fa-ban text-red"></i> BELUM ADA DATA BS (Berita Acara Barang Rusak)';
            html += '            </td>';
            html += '          </tr>';
        }

        html += '        </tbody>';
        html += '      </table>';
        html += '    </div>';
        html += '  </div>';
        html += '</div>';

        // ==========================================
        // SECTION 4: DATA BARANG KELUAR (PLUGINS BARANG KELUAR)
        // ==========================================
        var bkList = data.barang_keluar || [];
        var headerBkTitle = '4. DATA BARANG KELUAR (PLUGINS BARANG KELUAR)';
        if (bkList.length > 0) {
            headerBkTitle += ' (' + bkList.length + ' Transaksi Keluar)';
        }

        html += '<div class="track-card">';
        html += '  <div class="track-card-header">';
        html += '    <h3 class="track-card-title"><i class="fa fa-truck"></i> ' + headerBkTitle + '</h3>';
        html += '    <a href="' + asset.history_url + '" target="_blank" class="btn btn-header-link"><i class="fa fa-external-link"></i> Riwayat Barang Keluar</a>';
        html += '  </div>';
        html += '  <div class="track-card-body">';
        html += '    <div class="table-responsive">';
        html += '      <table class="track-table table-bordered table-striped">';
        html += '        <thead>';
        html += '          <tr>';
        html += '            <th style="width: 20%;">Kode Barang</th>';
        html += '            <th style="width: 25%;">Nama Barang</th>';
        html += '            <th style="width: 18%;">No. SJ</th>';
        html += '            <th style="width: 22%;">Tujuan</th>';
        html += '            <th style="width: 15%;">Dibuat Tanggal</th>';
        html += '          </tr>';
        html += '        </thead>';
        html += '        <tbody>';

        if (bkList.length > 0) {
            $.each(bkList, function(bIdx, bItem) {
                var sjBadge = bItem.no_sj !== '-' 
                    ? '<span class="label label-primary" style="font-size: 11px;"><i class="fa fa-file-text-o"></i> ' + bItem.no_sj + '</span>' 
                    : '<span class="text-muted">-</span>';

                html += '          <tr>';
                html += '            <td><a href="' + asset.asset_url + '" target="_blank" class="label label-primary" style="font-size: 12px; padding: 4px 8px;"><i class="fa fa-barcode"></i> ' + (bItem.kode_barang || asset.asset_tag) + ' <i class="fa fa-external-link" style="font-size: 9px;"></i></a></td>';
                html += '            <td><strong>' + (bItem.nama_barang || asset.name) + '</strong></td>';
                html += '            <td>' + sjBadge + '</td>';
                html += '            <td><i class="fa fa-map-marker text-red"></i> ' + (bItem.tujuan || '-') + '</td>';
                html += '            <td><i class="fa fa-clock-o text-muted"></i> ' + (bItem.dibuat_tanggal || '-') + '</td>';
                html += '          </tr>';
            });
        } else {
            html += '          <tr>';
            html += '            <td colspan="5" class="notice-empty-red" style="background-color: #fff8f8; color: #8a6d3b; text-align: center; padding: 18px; font-weight: 600;">';
            html += '              <i class="fa fa-info-circle text-warning" style="font-size: 16px; margin-right: 5px;"></i> Tidak ada transaksi Surat Jalan (SJ) keluar untuk aset ini (Plugins Barang Keluar)';
            html += '            </td>';
            html += '          </tr>';
        }

        html += '        </tbody>';
        html += '      </table>';
        html += '    </div>';
        html += '  </div>';
        html += '</div>';

        // ==========================================
        // SECTION 5: HISTORI LOG & AUDIT TRAIL SNIPE-IT (NATIVE VIEW)
        // ==========================================
        html += '<div class="track-card">';
        html += '  <div class="track-card-header">';
        html += '    <h3 class="track-card-title"><i class="fa fa-history"></i> 5. HISTORI LOG & AUDIT TRAIL SNIPE-IT (NATIVE VIEW)</h3>';
        html += '    <a href="' + asset.history_url + '" target="_blank" class="btn btn-header-link"><i class="fa fa-external-link"></i> Buka Audit Log Snipe-IT</a>';
        html += '  </div>';
        html += '  <div class="track-card-body" style="padding: 16px;">';

        // Toggle Button for Section 5
        html += '    <div style="text-align: center;">';
        html += '      <button type="button" id="btn-toggle-section4-history" data-maint-count="' + maints.length + '" data-log-count="' + logs.length + '" class="btn-toggle-custom">';
        html += '        <i class="fa fa-chevron-down"></i> Tampilkan Detail Histori Maintenance & Action Logs (' + maints.length + ' Record, ' + logs.length + ' Log)';
        html += '      </button>';
        html += '    </div>';

        // Collapsible History Details Container (Hidden by default)
        html += '    <div id="section4-history-container" style="display: none; margin-top: 16px; padding-top: 16px; border-top: 1px dashed #dcdfe6;">';

        // Table 1: Maintenances History
        html += '      <h4 style="font-weight: 700; margin-top: 0; margin-bottom: 10px; color: #2c3e50; font-size: 14px;"><i class="fa fa-wrench text-warning"></i> Tabel Histori Perbaikan & Maintenance Unit (' + maints.length + ' Record)</h4>';
        if (maints.length > 0) {
            html += '      <div class="table-responsive">';
            html += '        <table class="track-table table-bordered table-striped" style="margin-bottom: 16px;">';
            html += '          <thead>';
            html += '            <tr>';
            html += '              <th style="width: 5%;">#</th>';
            html += '              <th style="width: 15%;">Tanggal</th>';
            html += '              <th style="width: 25%;">Judul / Nama Perbaikan</th>';
            html += '              <th style="width: 15%;">Tipe Maintenance</th>';
            html += '              <th style="width: 15%;">Supplier / Pemroses</th>';
            html += '              <th style="width: 25%;">Catatan Detail & Perubahan</th>';
            html += '            </tr>';
            html += '          </thead>';
            html += '          <tbody>';
            $.each(maints, function(idx, m) {
                html += '            <tr>';
                html += '              <td>' + (idx + 1) + '</td>';
                html += '              <td><i class="fa fa-calendar text-muted"></i> ' + (m.start_date || '-') + '</td>';
                html += '              <td><strong>' + (m.name || '-') + '</strong></td>';
                html += '              <td><span class="label label-warning">' + (m.asset_maintenance_type || '-') + '</span></td>';
                html += '              <td>' + (m.supplier_name || m.admin_name || '-') + '</td>';
                html += '              <td>' + (m.notes || '-') + '</td>';
                html += '            </tr>';
            });
            html += '          </tbody>';
            html += '        </table>';
            html += '      </div>';
        } else {
            html += '      <div style="padding: 12px; text-align: center; color: #778ca3; background: #fafafa; border: 1px solid #e9ecef; border-radius: 4px; margin-bottom: 16px;"><i class="fa fa-info-circle"></i> Belum ada riwayat perbaikan / maintenance terdaftar untuk aset ini.</div>';
        }

        // Table 2: Action Logs Audit Trail
        html += '      <h4 style="font-weight: 700; margin-top: 16px; margin-bottom: 10px; color: #2c3e50; font-size: 14px;"><i class="fa fa-history text-info"></i> Tabel Action Logs & Audit Trail Terbaru (' + logs.length + ' Log)</h4>';
        if (logs.length > 0) {
            html += '      <div class="table-responsive">';
            html += '        <table class="track-table table-bordered table-striped">';
            html += '          <thead>';
            html += '            <tr>';
            html += '              <th style="width: 12%;">Created At</th>';
            html += '              <th style="width: 14%;">Created By</th>';
            html += '              <th style="width: 10%;">Action</th>';
            html += '              <th style="width: 22%;">Item</th>';
            html += '              <th style="width: 18%;">Target</th>';
            html += '              <th style="width: 14%;">Notes</th>';
            html += '              <th style="width: 10%;">Changed</th>';
            html += '            </tr>';
            html += '          </thead>';
            html += '          <tbody>';
            $.each(logs, function(idx, l) {
                var createdAtVal = l.created_at || l.action_date || '-';
                var createdByVal = l.created_by || l.admin_name || 'Bakhtiyar Sierad';
                var actionVal = l.action || l.action_type || 'update';
                var itemVal = l.item || ((asset.name || 'Asset') + ' #' + asset.asset_tag);
                var targetVal = l.target || l.target_name || '-';
                var notesVal = l.notes || l.note || '-';
                var changedVal = l.changed || '-';

                var actionBadge = '<span class="label label-default">' + actionVal + '</span>';
                if (actionVal === 'checkout') actionBadge = '<span class="label label-success">checkout</span>';
                else if (actionVal === 'checkin from' || actionVal === 'checkin') actionBadge = '<span class="label label-info">checkin</span>';
                else if (actionVal === 'delete') actionBadge = '<span class="label label-danger">delete</span>';
                else if (actionVal === 'audit') actionBadge = '<span class="label label-warning" style="background-color: #f39c12;">audit</span>';
                else if (actionVal === 'update') actionBadge = '<span class="label label-default" style="background-color: #8e44ad;">update</span>';

                var targetContent = '-';
                if (targetVal && targetVal !== '-') {
                    targetContent = '<i class="fa fa-map-marker text-green"></i> <span style="color: #27ae60; font-weight: 600;">' + targetVal + '</span>';
                }

                html += '            <tr>';
                html += '              <td style="white-space: nowrap;"><i class="fa fa-clock-o text-muted"></i> ' + createdAtVal + '</td>';
                html += '              <td><a href="#" onclick="return false;" style="color: #27ae60; font-weight: bold;"><i class="fa fa-user"></i> ' + createdByVal + '</a></td>';
                html += '              <td>' + actionBadge + '</td>';
                html += '              <td><i class="fa fa-cube text-primary"></i> <strong>' + itemVal + '</strong></td>';
                html += '              <td>' + targetContent + '</td>';
                html += '              <td>' + notesVal + '</td>';
                html += '              <td style="font-size: 11px; font-family: monospace;">' + changedVal + '</td>';
                html += '            </tr>';
            });
            html += '          </tbody>';
            html += '        </table>';
            html += '      </div>';
        } else {
            html += '      <div style="padding: 12px; text-align: center; color: #778ca3; background: #fafafa; border: 1px solid #e9ecef; border-radius: 4px;"><i class="fa fa-info-circle"></i> Belum ada log aktivitas untuk aset ini.</div>';
        }

        html += '    </div>'; // End #section4-history-container

        html += '  </div>';
        html += '</div>';

        $("#track-result-container").html(html).fadeIn(250);
    }
});
</script>
@stop
