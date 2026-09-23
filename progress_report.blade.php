@extends('layouts/default')

{{-- Page title --}}
@section('title')
Laporan Progress Upgrade Hardware
@parent
@stop

{{-- Page content --}}
@section('content')

<style>
.progress-badge {
    font-size: 14px;
    padding: 6px 12px;
    border-radius: 20px;
}
.bg-purple-custom {
    background-color: #6f42c1 !important;
    color: #ffffff !important;
}
.snapshot-card {
    border-left: 4px solid #0071c5;
    margin-bottom: 15px;
    background: #ffffff;
    padding: 15px;
    border-radius: 4px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}
.comp-select-row {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    padding: 8px 12px;
    border-radius: 4px;
    margin-bottom: 6px;
    transition: all 0.2s ease-in-out;
}
.comp-select-row:hover {
    background: #f8fafc;
    border-color: #cbd5e1;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}
</style>

<div class="row">
    <div class="col-md-12">
        <h2 class="page-header" style="margin-top: 0;">
            <i class="fa fa-line-chart text-purple"></i> Laporan Progress Upgrade Hardware
            <small>Pemantauan Kemajuan, Progress Tracking, & Snapshot Penjadwalan Upgrade</small>
        </h2>
    </div>
</div>

{{-- Top Actions & Print Buttons --}}
<div class="row" style="margin-bottom: 20px;">
    <div class="col-md-12">
        <div class="pull-right">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create-snapshot">
                <i class="fa fa-camera"></i> 📸 Ambil Snapshot Progress
            </button>
            <a href="{{ route('hardware.analisa.print_report') }}" target="_blank" class="btn btn-success" style="margin-left: 10px;">
                <i class="fa fa-print"></i> 🖨️ Cetak Laporan Formal (A4 Landscape)
            </a>
        </div>
    </div>
</div>

{{-- Overall Progress Meter --}}
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-tasks"></i> Progress Kemajuan Upgrade Total</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-8">
                        <h4>Persentase Upgrade Selesai: <strong>{{ $progressPercent }}%</strong></h4>
                        <div class="progress progress-striped active" style="height: 25px; border-radius: 4px;">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{ $progressPercent }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $progressPercent }}%; font-size: 14px; line-height: 25px; font-weight: bold;">
                                {{ $progressPercent }}% Selesai
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center" style="border-left: 1px solid #eee; padding-top: 5px;">
                        <div class="row">
                            <div class="col-xs-6">
                                <h1 class="text-green" style="margin: 0; font-size: 36px; font-weight: 800; line-height: 1.1;">{{ $completedCount }}</h1>
                                <small class="text-muted" style="font-weight: bold; font-size: 11px;">Selesai Di-Upgrade</small>
                            </div>
                            <div class="col-xs-6">
                                <h1 class="text-red" style="margin: 0; font-size: 36px; font-weight: 800; line-height: 1.1;">{{ $remainingCount }}</h1>
                                <small class="text-muted" style="font-weight: bold; font-size: 11px;">Sisa PC Non-Core</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Metrics Row --}}
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ number_format($initialTarget) }}</h3>
                <p>Initial Target PC Non-Core</p>
            </div>
            <div class="icon"><i class="fa fa-bullseye"></i></div>
            <span class="small-box-footer">Target Awal Rencana Upgrade</span>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-purple-custom">
            <div class="inner">
                <h3>{{ number_format($totalScheduled) }}</h3>
                <p>Status Terjadwal Upgrade</p>
            </div>
            <div class="icon"><i class="fa fa-calendar-check-o"></i></div>
            <span class="small-box-footer">Siap Di-Upgrade</span>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ number_format($completedCount) }}</h3>
                <p>Perangkat Ter-Upgrade</p>
            </div>
            <div class="icon"><i class="fa fa-check-square-o"></i></div>
            <span class="small-box-footer">Telah Naik Kelas / Diganti</span>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ number_format($remainingCount) }}</h3>
                <p>Sisa Perangkat Belum Upgrade</p>
            </div>
            <div class="icon"><i class="fa fa-clock-o"></i></div>
            <span class="small-box-footer">Menunggu Eksekusi</span>
        </div>
    </div>
</div>

{{-- Scheduled Assets Table Card --}}
<div class="row">
    <div class="col-md-12">
        <div class="box box-purple" style="border-top-color: #6f42c1;">
            <div class="box-header with-border" style="background-color: #6f42c1; color: #ffffff;">
                <h3 class="box-title" style="color: #ffffff !important; font-weight: bold; margin: 0;">
                    <i class="fa fa-calendar" style="color: #ffffff !important;"></i> 
                    <span style="color: #ffffff !important;">Daftar Aset Berstatus "Terjadwal Upgrade" ({{ count($scheduledAssets) }} Unit)</span>
                </h3>
            </div>
            <div class="box-body table-responsive">
                <table id="table" data-toggle="table" data-search="true" data-pagination="true" data-page-size="25" class="table table-striped snipe-table">
                    <thead>
                        <tr>
                            <th style="width: 40px; text-align: center;">#</th>
                            <th data-sortable="true">Asset Tag</th>
                            <th data-sortable="true">Nama Perangkat</th>
                            <th data-sortable="true">Pemakai (User)</th>
                            <th data-sortable="true">Perusahaan</th>
                            <th data-sortable="true">Lokasi</th>
                            <th data-sortable="true">Spesifikasi Processor</th>
                            <th data-sortable="true">RAM</th>
                            <th style="text-align: center; width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($scheduledAssets as $index => $asset)
                        <tr>
                            <td style="text-align: center;">{{ $index + 1 }}</td>
                            <td>
                                <a href="{{ route('hardware.show', $asset->id) }}" target="_blank" style="font-weight: bold;">
                                    {{ $asset->asset_tag }}
                                </a>
                            </td>
                            <td>{{ $asset->asset_name ?: '-' }}</td>
                            <td>
                                @if($asset->assigned_user && trim($asset->assigned_user) != '')
                                    <i class="fa fa-user text-muted"></i> {{ trim($asset->assigned_user) }}
                                @else
                                    <span class="label label-default">Belum Ditugaskan</span>
                                @endif
                            </td>
                            <td>{{ $asset->company_name ?: 'No Company' }}</td>
                            <td>{{ $asset->location_name ?: '-' }}</td>
                            <td>{{ $asset->processor ?: '-' }}</td>
                            <td>{{ $asset->ram ? trim($asset->ram) : '-' }}</td>
                            <td style="text-align: center;">
                                <button type="button" class="btn btn-xs btn-success btn-open-complete-modal" data-toggle="modal" data-target="#modal-complete-upgrade" data-id="{{ $asset->id }}" data-tag="{{ $asset->asset_tag }}" data-name="{{ $asset->asset_name }}" data-cpu="{{ $asset->processor }}" data-ram="{{ $asset->ram }}">
                                    <i class="fa fa-check-circle"></i> Selesai Upgrade
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted" style="padding: 20px;">
                                Belum ada aset yang ditandai status "Terjadwal Upgrade". Silakan tandai di menu Analisa Hardware.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Snapshots History Card --}}
<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-history"></i> Riwayat Snapshot Kemajuan Progress</h3>
            </div>
            <div class="box-body">
                @forelse($snapshots as $snap)
                <div class="snapshot-card" id="snap-{{ $snap['id'] }}">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 style="margin-top: 0; font-weight: bold; color: #0071c5;">
                                <i class="fa fa-camera text-blue"></i> {{ $snap['title'] }}
                            </h4>
                            <p class="text-muted" style="margin-bottom: 5px;">
                                <i class="fa fa-clock-o"></i> {{ date('d M Y H:i', strtotime($snap['date'])) }} | 
                                <i class="fa fa-user"></i> Ditambahkan oleh: {{ $snap['created_by'] }}
                            </p>
                            <p style="margin-bottom: 0;">{{ $snap['notes'] }}</p>
                        </div>
                        <div class="col-md-4 text-right">
                            <h3 class="text-purple" style="margin-top: 0; margin-bottom: 5px;">{{ $snap['progress_percent'] }}% Progress</h3>
                            <p class="text-muted" style="margin-bottom: 10px;">
                                Terjadwal: <strong>{{ $snap['total_scheduled'] }}</strong> | Sisa: <strong>{{ $snap['total_remaining'] }}</strong> Unit
                            </p>
                            <button type="button" class="btn btn-xs btn-danger btn-delete-snap" data-id="{{ $snap['id'] }}">
                                <i class="fa fa-trash"></i> Hapus Snapshot
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted" style="padding: 20px;">
                    <i class="fa fa-camera-retro fa-2x"></i><br>
                    Belum ada snapshot progress yang disimpan. Klik tombol <strong>Ambil Snapshot Progress</strong> di atas untuk menyimpan milestone kemajuan.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Modal Create Snapshot --}}
<div class="modal fade" id="modal-create-snapshot" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0071c5; color: white;">
                <button type="button" class="close" data-dismiss="modal" style="color: white;">&times;</button>
                <h4 class="modal-title" style="color: white;"><i class="fa fa-camera"></i> Ambil Snapshot Progress Baru</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Judul Snapshot:</label>
                    <input type="text" id="snap_title" class="form-control" placeholder="Contoh: Snapshot Gelombang 1 - Agustus 2026" value="Snapshot Progress Upgrade {{ date('d M Y') }}">
                </div>
                <div class="form-group">
                    <label>Catatan Progress / Milestone:</label>
                    <textarea id="snap_notes" class="form-control" rows="3" placeholder="Catatan progress, target pengerjaan, atau prioritas..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btn-save-snapshot">
                    <i class="fa fa-save"></i> Simpan Snapshot
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Form Terpadu: Proses & Selesai Upgrade --}}
<div class="modal fade" id="modal-complete-upgrade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #28a745; color: white;">
                <button type="button" class="close" data-dismiss="modal" style="color: white;">&times;</button>
                <h4 class="modal-title" style="color: white;"><i class="fa fa-check-circle"></i> Form Terpadu: Proses & Selesai Upgrade Hardware</h4>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <input type="hidden" id="modal_asset_id">

                <div class="alert alert-info" style="margin-bottom: 20px;">
                    <i class="fa fa-info-circle"></i> Mengisi form ini akan secara otomatis memetakan ke custom field spesifikasi aset 
                    (<strong>`_snipeit_jenis_processor_12`</strong> & <strong>`_snipeit_jenis_ram_5`</strong>) tanpa mengubah Model Aset eksisting.
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Target Asset Tag:</label>
                            <input type="text" id="modal_asset_tag" class="form-control" readonly style="font-weight: bold; font-family: monospace;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Perangkat / User:</label>
                            <input type="text" id="modal_asset_name" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                <hr style="margin-top: 10px; margin-bottom: 15px;">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fa fa-microchip text-blue"></i> Spesifikasi Processor Baru:</label>
                            <select id="modal_new_processor" class="form-control">
                                <option value="">-- Pilih Spesifikasi Processor Baru --</option>
                                <option value="Intel Core i5-6500 @ 3.20GHz">Intel Core i5-6500 @ 3.20GHz</option>
                                <option value="Intel Core i5-4590 @ 3.30GHz">Intel Core i5-4590 @ 3.30GHz</option>
                                <option value="Intel Core i5-10400 @ 2.90GHz">Intel Core i5-10400 @ 2.90GHz</option>
                                <option value="Intel Core i7-4770 @ 3.40GHz">Intel Core i7-4770 @ 3.40GHz</option>
                                <option value="Intel Core i3-10100 @ 3.60GHz">Intel Core i3-10100 @ 3.60GHz</option>
                                <option value="AMD Ryzen 5 5600G @ 3.90GHz">AMD Ryzen 5 5600G @ 3.90GHz</option>
                                <option value="CUSTOM">-- Ketik Processor Kustom --</option>
                            </select>
                            <input type="text" id="modal_custom_processor" class="form-control" placeholder="Ketik nama processor baru..." style="display: none; margin-top: 5px;">
                            <small class="text-muted">CPU Asal: <span id="modal_old_cpu" class="text-danger" style="font-weight: bold;"></span></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fa fa-dashboard text-purple"></i> Spesifikasi RAM Baru:</label>
                            <select id="modal_new_ram" class="form-control">
                                <option value="">-- Pilih Kapasitas RAM Baru --</option>
                                <option value="DDR3 8GB">DDR3 8GB</option>
                                <option value="DDR3 16GB">DDR3 16GB</option>
                                <option value="DDR4 8GB">DDR4 8GB</option>
                                <option value="DDR4 16GB">DDR4 16GB</option>
                                <option value="DDR5 16GB">DDR5 16GB</option>
                                <option value="CUSTOM">-- Ketik RAM Kustom --</option>
                            </select>
                            <input type="text" id="modal_custom_ram" class="form-control" placeholder="Ketik RAM baru..." style="display: none; margin-top: 5px;">
                            <small class="text-muted">RAM Asal: <span id="modal_old_ram" class="text-danger" style="font-weight: bold;"></span></small>
                        </div>
                    </div>
                </div>

                <hr style="margin-top: 10px; margin-bottom: 15px;">

                {{-- Component Selection with Search & Sleek Layout --}}
                <div class="form-group">
                    <label><i class="fa fa-cubes text-orange"></i> Ambil Komponen dari Stok Snipe-IT (Component Checkout):</label>
                    <div class="input-group" style="margin-bottom: 10px;">
                        <span class="input-group-addon"><i class="fa fa-search"></i></span>
                        <input type="text" id="comp-search-box" class="form-control" placeholder="Cari Kode / Serial (misal: COM-260123002), Kategori, atau Nama Komponen...">
                    </div>

                    <div id="components-list-container" style="max-height: 240px; overflow-y: auto; border: 1px solid #d2d6de; padding: 10px; border-radius: 4px; background: #f8fafc;">
                        <div class="text-center text-muted" style="padding: 15px;"><i class="fa fa-spinner fa-spin"></i> Memuat stok komponen...</div>
                    </div>
                    <small class="text-muted">Menampilkan komponen dengan stok > 0. Anda dapat memilih lebih dari 1 komponen sekaligus.</small>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Biaya Upgrade (Rp):</label>
                            <input type="number" id="modal_cost" class="form-control" placeholder="0" value="0">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Catatan Upgrade / Perubahan Specs:</label>
                            <textarea id="modal_notes" class="form-control" rows="2" placeholder="Catatan pekerjaan upgrade..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" id="btn-submit-complete-upgrade">
                    <i class="fa fa-check"></i> Simpan & Selesaikan Upgrade
                </button>
            </div>
        </div>
    </div>
</div>

@stop

@section('moar_scripts')
@include('partials.bootstrap-table')

<script>
$(document).ready(function() {
    var allComponentsCache = [];

    // Dropdown Custom Processor / RAM
    $('#modal_new_processor').change(function() {
        if ($(this).val() === 'CUSTOM') {
            $('#modal_custom_processor').show().focus();
        } else {
            $('#modal_custom_processor').hide();
        }
    });

    $('#modal_new_ram').change(function() {
        if ($(this).val() === 'CUSTOM') {
            $('#modal_custom_ram').show().focus();
        } else {
            $('#modal_custom_ram').hide();
        }
    });

    // Sleek Render Function for Components List (Single Horizontal Row per Component)
    function renderComponentsList(filterKeyword) {
        if (allComponentsCache.length === 0) {
            $('#components-list-container').html('<div class="text-muted text-center" style="padding: 15px;">Tidak ada stok komponen aktif (Stok > 0) terdaftar di Snipe-IT.</div>');
            return;
        }

        var keyword = (filterKeyword || '').toLowerCase().trim();
        var html = '';
        var matchCount = 0;

        $.each(allComponentsCache, function(i, c) {
            var serialStr = c.serial ? c.serial : '';
            var modelStr = c.model_number ? '(' + c.model_number + ')' : '';
            var categoryStr = c.category_name ? c.category_name : 'KOMPONEN';

            var compText = (categoryStr + ' ' + c.name + ' ' + serialStr + ' ' + modelStr + ' ' + c.id).toLowerCase();
            if (keyword !== '' && compText.indexOf(keyword) === -1) {
                return; // Skip if no match
            }

            matchCount++;

            html += '<div class="comp-select-row" style="display: flex; align-items: center; justify-content: space-between;">';
            html += '  <div style="display: flex; align-items: center; gap: 8px; flex: 1; min-width: 0; padding-right: 10px;">';
            html += '    <input type="checkbox" class="chk-comp" value="' + c.id + '" style="margin: 0; cursor: pointer; transform: scale(1.15); flex-shrink: 0;">';
            html += '    <span class="label label-info" style="font-size: 10px; padding: 3px 6px; text-transform: uppercase; flex-shrink: 0;">' + categoryStr + '</span>';
            if (serialStr) {
                html += '    <strong style="color: #0071c5; font-family: monospace; font-size: 12px; flex-shrink: 0;">' + serialStr + '</strong>';
            }
            html += '    <span style="font-weight: 600; color: #333; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">' + c.name + '</span>';
            if (modelStr) {
                html += '    <small class="text-muted" style="white-space: nowrap; flex-shrink: 0;">' + modelStr + '</small>';
            }
            html += '  </div>';
            html += '  <div style="display: flex; align-items: center; gap: 10px; flex-shrink: 0;">';
            html += '    <span class="label label-success" style="font-size: 11px; padding: 4px 8px;">Stok: ' + c.remaining_qty + ' Pcs</span>';
            html += '    <div style="display: flex; align-items: center; gap: 4px;">';
            html += '      <small class="text-muted" style="font-size: 11px;">Qty:</small>';
            html += '      <input type="number" class="form-control input-sm comp-qty" data-id="' + c.id + '" value="1" min="1" max="' + c.remaining_qty + '" style="width: 52px; height: 26px; padding: 2px 4px; text-align: center; font-weight: bold;">';
            html += '    </div>';
            html += '  </div>';
            html += '</div>';
        });

        if (matchCount === 0) {
            html = '<div class="text-muted text-center" style="padding: 15px;">Tidak ada komponen stok aktif cocok dengan pencarian "<strong>' + filterKeyword + '</strong>".</div>';
        }

        $('#components-list-container').html(html);
    }

    // Live Search Component Box
    $('#comp-search-box').on('keyup input', function() {
        var query = $(this).val();
        renderComponentsList(query);
    });

    // Open Complete Upgrade Modal
    $(document).on('click', '.btn-open-complete-modal', function() {
        var id = $(this).attr('data-id') || $(this).data('id');
        var tag = $(this).attr('data-tag') || $(this).data('tag');
        var name = $(this).attr('data-name') || $(this).data('name');
        var cpu = $(this).attr('data-cpu') || $(this).data('cpu');
        var ram = $(this).attr('data-ram') || $(this).data('ram');

        $('#modal_asset_id').val(id);
        $('#modal_asset_tag').val(tag);
        $('#modal_asset_name').val(name || '-');
        $('#modal_old_cpu').text(cpu || '-');
        $('#modal_old_ram').text(ram || '-');
        $('#modal_new_processor').val('');
        $('#modal_custom_processor').hide().val('');
        $('#modal_new_ram').val('');
        $('#modal_custom_ram').hide().val('');
        $('#modal_cost').val('0');
        $('#modal_notes').val('Ganti processor & penyesuaian hardware');
        $('#comp-search-box').val('');

        // Load Components Stock
        $('#components-list-container').html('<div class="text-center text-muted" style="padding: 15px;"><i class="fa fa-spinner fa-spin"></i> Memuat stok komponen...</div>');

        $.ajax({
            url: "{{ route('hardware.analisa.components_list') }}",
            type: "GET",
            success: function(comps) {
                allComponentsCache = comps;
                renderComponentsList('');
            }
        });
    });

    // Submit Complete Upgrade Form
    $('#btn-submit-complete-upgrade').click(function() {
        var assetId = $('#modal_asset_id').val();
        var cpuVal = $('#modal_new_processor').val();
        if (cpuVal === 'CUSTOM') cpuVal = $('#modal_custom_processor').val();

        var ramVal = $('#modal_new_ram').val();
        if (ramVal === 'CUSTOM') ramVal = $('#modal_custom_ram').val();

        if (!cpuVal) {
            alert('Silakan pilih atau ketik spesifikasi Processor Baru!');
            return;
        }

        var selectedComps = [];
        $('.chk-comp:checked').each(function() {
            var compId = $(this).val();
            var qtyInput = $('.comp-qty[data-id="' + compId + '"]').val() || 1;
            selectedComps.push({ id: compId, qty: parseInt(qtyInput) });
        });

        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Memproses Upgrade...');

        $.ajax({
            url: "{{ route('hardware.analisa.complete_upgrade') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                asset_id: assetId,
                new_processor: cpuVal,
                new_ram: ramVal,
                cost: $('#modal_cost').val(),
                notes: $('#modal_notes').val(),
                components: selectedComps
            },
            success: function(res) {
                if (res.success) {
                    alert(res.message);
                    location.reload();
                } else {
                    alert('Gagal menyelesaikan upgrade: ' + res.message);
                    btn.prop('disabled', false).html('<i class="fa fa-check"></i> Simpan & Selesaikan Upgrade');
                }
            },
            error: function() {
                alert('Terjadi kesalahan koneksi!');
                btn.prop('disabled', false).html('<i class="fa fa-check"></i> Simpan & Selesaikan Upgrade');
            }
        });
    });

    $('#btn-save-snapshot').click(function() {
        var title = $('#snap_title').val();
        var notes = $('#snap_notes').val();

        if (!title) {
            alert('Judul snapshot wajib diisi!');
            return;
        }

        $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

        $.ajax({
            url: "{{ route('hardware.analisa.create_snapshot') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                title: title,
                notes: notes
            },
            success: function(res) {
                if (res.success) {
                    location.reload();
                } else {
                    alert('Gagal membuat snapshot!');
                }
            }
        });
    });

    $(document).on('click', '.btn-delete-snap', function() {
        if (!confirm('Apakah Anda yakin ingin menghapus snapshot me ini?')) return;

        var id = $(this).data('id');
        $.ajax({
            url: "{{ route('hardware.analisa.delete_snapshot') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id
            },
            success: function(res) {
                if (res.success) {
                    $('#snap-' + id).fadeOut(300, function() { $(this).remove(); });
                }
            }
        });
    });
});
</script>
@stop
