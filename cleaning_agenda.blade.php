@extends('layouts/default')

{{-- Page title --}}
@section('title')
Agenda & Laporan Cleaning Perangkat ({{ $year }})
@parent
@stop

{{-- Page content --}}
@section('content')

<style>
.bg-purple-custom {
    background-color: #6f42c1 !important;
    color: #ffffff !important;
}
.btn-toggle-cleaning {
    font-weight: bold;
}
.filter-card {
    background: #ffffff;
    padding: 15px;
    border-radius: 4px;
    margin-bottom: 20px;
    border: 1px solid #e2e8f0;
}
</style>

<div class="row">
    <div class="col-md-12">
        <h2 class="page-header" style="margin-top: 0;">
            <i class="fa fa-broom text-green"></i> Agenda & Laporan Cleaning Perangkat IT
            <small>Pemantauan Realisasi Pembersihan Perangkat Rutin Tahunan & Integrasi HESK ITSM (Tahun {{ $year }})</small>
        </h2>
    </div>
</div>

{{-- Filter Card (Sesuai Filter Plugin Maintenance Monitoring) --}}
<div class="row">
    <div class="col-md-12">
        <div class="filter-card">
            <form method="GET" action="{{ route('hardware.analisa.cleaning_agenda') }}" class="form-inline">
                <div class="form-group" style="margin-right: 10px; margin-bottom: 10px;">
                    <label><i class="fa fa-calendar"></i> Tahun Agenda: &nbsp;</label>
                    <select name="year" class="form-control" onchange="this.form.submit()">
                        <option value="2025" {{ $year == 2025 ? 'selected' : '' }}>Tahun 2025</option>
                        <option value="2026" {{ $year == 2026 ? 'selected' : '' }}>Tahun 2026</option>
                        <option value="2027" {{ $year == 2027 ? 'selected' : '' }}>Tahun 2027</option>
                    </select>
                </div>

                <div class="form-group" style="margin-right: 10px; margin-bottom: 10px;">
                    <label>Perusahaan: &nbsp;</label>
                    <select name="company_id" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Semua Perusahaan --</option>
                        @foreach($companies as $c)
                            <option value="{{ $c->id }}" {{ $companyId == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" style="margin-right: 10px; margin-bottom: 10px;">
                    <label>Kategori: &nbsp;</label>
                    <select name="category_id" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" style="margin-right: 10px; margin-bottom: 10px;">
                    <label>Lokasi: &nbsp;</label>
                    <select name="location_name" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Semua Lokasi --</option>
                        @foreach($locations as $loc)
                            <option value="{{ $loc->name }}" {{ $locationName == $loc->name ? 'selected' : '' }}>{{ $loc->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" style="margin-right: 10px; margin-bottom: 10px;">
                    <label>Status Cleaning: &nbsp;</label>
                    <select name="status" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Semua Status Cleaning --</option>
                        <option value="sudah" {{ $statusFilter == 'sudah' ? 'selected' : '' }}>Sudah Maintenance</option>
                        <option value="belum" {{ $statusFilter == 'belum' ? 'selected' : '' }}>Belum Maintenance</option>
                    </select>
                </div>

                <div class="form-group" style="margin-right: 10px; margin-bottom: 10px;">
                    <label>Status Tiket HESK: &nbsp;</label>
                    <select name="hesk_status" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Semua Status HESK --</option>
                        <option value="open" {{ $heskStatusFilter == 'open' ? 'selected' : '' }}>Tiket Open</option>
                        <option value="resolved" {{ $heskStatusFilter == 'resolved' ? 'selected' : '' }}>Tiket Resolved</option>
                        <option value="none" {{ $heskStatusFilter == 'none' ? 'selected' : '' }}>Belum Ada Tiket</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-default" style="margin-bottom: 10px;">
                    <i class="fa fa-filter"></i> Filter
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Overall Progress Meter --}}
<div class="row">
    <div class="col-md-12">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-tasks"></i> Progress Kemajuan Realisasi Cleaning Tahun {{ $year }}</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-8">
                        <h4>Ketercapaian Cleaning: <strong>{{ $progressPercent }}%</strong></h4>
                        <div class="progress progress-striped active" style="height: 25px; border-radius: 4px;">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{ $progressPercent }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $progressPercent }}%; font-size: 14px; line-height: 25px; font-weight: bold;">
                                {{ $progressPercent }}% Selesai
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center" style="border-left: 1px solid #eee;">
                        <div class="row">
                            <div class="col-xs-6">
                                <h3 class="text-green" style="margin-bottom: 0;" id="stat-done">{{ number_format($totalDone) }}</h3>
                                <small class="text-muted">Sudah Cleaning</small>
                            </div>
                            <div class="col-xs-6">
                                <h3 class="text-red" style="margin-bottom: 0;" id="stat-pending">{{ number_format($totalPending) }}</h3>
                                <small class="text-muted">Belum Cleaning</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Metrics Summary Cards (Include HESK Stats) --}}
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ number_format($totalTarget) }}</h3>
                <p>Total Target Agenda {{ $year }}</p>
            </div>
            <div class="icon"><i class="fa fa-list-alt"></i></div>
            <span class="small-box-footer">Perangkat Terdaftar</span>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ number_format($totalDone) }}</h3>
                <p>Sudah Maintenance</p>
            </div>
            <div class="icon"><i class="fa fa-check-circle"></i></div>
            <span class="small-box-footer">Selesai Dibersihkan</span>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{ number_format($totalHeskOpen) }}</h3>
                <p>Tiket HESK Active (Open)</p>
            </div>
            <div class="icon"><i class="fa fa-ticket"></i></div>
            <span class="small-box-footer">Sedang Berjalan di ITSM</span>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-purple-custom">
            <div class="inner">
                <h3>{{ number_format($totalHeskResolved) }}</h3>
                <p>Tiket HESK Resolved</p>
            </div>
            <div class="icon"><i class="fa fa-check-square"></i></div>
            <span class="small-box-footer">Verified via ITSM HESK</span>
        </div>
    </div>
</div>

{{-- Action Toolbar & Data Table --}}
<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-table"></i> Data Agenda Cleaning Perangkat ({{ count($agenda) }} Unit)</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-sm btn-warning" id="btn-generate-bulk-hesk">
                        <i class="fa fa-ticket"></i> 🎫 Generate Tiket HESK Terpilih
                    </button>
                    <button type="button" class="btn btn-sm btn-default" id="btn-sync-snipeit" style="margin-left: 5px;">
                        <i class="fa fa-refresh text-blue"></i> Sync Snipe-IT & HESK
                    </button>
                    <button type="button" class="btn btn-sm btn-primary" id="btn-generate-agenda" style="margin-left: 5px;">
                        <i class="fa fa-plus-circle"></i> Refresh Agenda {{ $year }}
                    </button>
                    <a href="{{ route('hardware.analisa.print_cleaning_report', ['year' => $year]) }}" target="_blank" class="btn btn-sm btn-success" style="margin-left: 5px;">
                        <i class="fa fa-print"></i> Cetak Laporan (A4)
                    </a>
                </div>
            </div>
            <div class="box-body table-responsive">
                <table id="table" data-toggle="table" data-search="true" data-pagination="true" data-page-size="25" class="table table-striped snipe-table">
                    <thead>
                        <tr>
                            <th style="width: 30px; text-align: center;">
                                <input type="checkbox" id="select-all-agenda">
                            </th>
                            <th style="width: 40px; text-align: center;">#</th>
                            <th data-sortable="true">Asset Tag</th>
                            <th data-sortable="true">Nama Perangkat</th>
                            <th data-sortable="true">Kategori</th>
                            <th data-sortable="true">Pemakai (User)</th>
                            <th data-sortable="true">Perusahaan</th>
                            <th data-sortable="true">Lokasi</th>
                            <th data-sortable="true" style="text-align: center;">Status Cleaning</th>
                            <th data-sortable="true" style="text-align: center;">Tiket HESK ITSM</th>
                            <th data-sortable="true" style="text-align: center;">Tgl Realisasi</th>
                            <th style="text-align: center; width: 130px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($agenda as $idx => $item)
                        <tr id="row-{{ $item['id'] }}">
                            <td style="text-align: center;">
                                @if(empty($item['hesk_trackid']) && ($item['cleaning_status'] ?? '') !== 'sudah_maintenance')
                                    <input type="checkbox" class="chk-agenda" value="{{ $item['id'] }}">
                                @endif
                            </td>
                            <td style="text-align: center;">{{ $idx + 1 }}</td>
                            <td>
                                <a href="{{ route('hardware.show', $item['asset_id']) }}" target="_blank" style="font-weight: bold;">
                                    {{ $item['asset_tag'] }}
                                </a>
                            </td>
                            <td>{{ $item['asset_name'] ?: '-' }}</td>
                            <td><span class="label label-info">{{ $item['category_name'] ?: 'Umum' }}</span></td>
                            <td>
                                @if($item['assigned_user'] && $item['assigned_user'] != 'Belum Ditugaskan')
                                    <i class="fa fa-user text-muted"></i> {{ $item['assigned_user'] }}
                                @else
                                    <span class="label label-default">Belum Ditugaskan</span>
                                @endif
                            </td>
                            <td>{{ $item['company_name'] ?: 'No Company' }}</td>
                            <td>{{ $item['location_name'] ?: '-' }}</td>
                            <td style="text-align: center;" class="status-cell">
                                @if(($item['cleaning_status'] ?? '') === 'sudah_maintenance')
                                    <span class="label label-success"><i class="fa fa-check"></i> Sudah Maintenance</span>
                                @else
                                    <span class="label label-danger"><i class="fa fa-clock-o"></i> Belum Maintenance</span>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                @if(!empty($item['hesk_trackid']))
                                    @if(($item['hesk_ticket_status'] ?? '') === 'resolved')
                                        <a href="https://itsm.royalcorp.co.id/admin/admin_ticket.php?track={{ $item['hesk_trackid'] }}" target="_blank" class="label label-purple" style="background-color: #6f42c1; color: white;">
                                            <i class="fa fa-check-square-o"></i> {{ $item['hesk_trackid'] }} (Resolved)
                                        </a>
                                    @else
                                        <a href="https://itsm.royalcorp.co.id/admin/admin_ticket.php?track={{ $item['hesk_trackid'] }}" target="_blank" class="label label-warning">
                                            <i class="fa fa-ticket"></i> {{ $item['hesk_trackid'] }} (Open)
                                        </a>
                                    @endif
                                @else
                                    <span class="label label-default">Belum ada tiket</span>
                                @endif
                            </td>
                            <td style="text-align: center;" class="date-cell">
                                {{ $item['realization_date'] ? date('d M Y', strtotime($item['realization_date'])) : '-' }}
                            </td>
                            <td style="text-align: center;">
                                @if(($item['cleaning_status'] ?? '') === 'sudah_maintenance')
                                    <button type="button" class="btn btn-xs btn-default btn-toggle-cleaning" data-id="{{ $item['id'] }}">
                                        <i class="fa fa-times text-red"></i> Batal
                                    </button>
                                @else
                                    <button type="button" class="btn btn-xs btn-success btn-toggle-cleaning" data-id="{{ $item['id'] }}">
                                        <i class="fa fa-broom"></i> Tandai Cleaning
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="12" class="text-center text-muted" style="padding: 20px;">
                                Belum ada agenda cleaning untuk tahun {{ $year }}. Klik tombol <strong>Refresh Agenda {{ $year }}</strong> di atas untuk memuat agenda baru!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@stop

@section('moar_scripts')
@include('partials.bootstrap-table')

<script>
$(document).ready(function() {
    // Select All Checkboxes
    $('#select-all-agenda').change(function() {
        $('.chk-agenda').prop('checked', $(this).prop('checked'));
    });

    // Bulk Generate Tiket HESK Terpilih
    $('#btn-generate-bulk-hesk').click(function() {
        var selected = [];
        $('.chk-agenda:checked').each(function() {
            selected.push($(this).val());
        });

        if (selected.length === 0) {
            alert('Silakan centang minimal 1 agenda perangkat yang belum memiliki tiket!');
            return;
        }

        if (!confirm('Apakah Anda yakin ingin memproduksi ' + selected.length + ' Tiket HESK ITSM baru secara massal?')) return;

        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Generating HESK...');

        $.ajax({
            url: "{{ route('hardware.analisa.generate_hesk_tickets') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                year: "{{ $year }}",
                agenda_ids: selected
            },
            success: function(res) {
                if (res.success) {
                    alert(res.message);
                    location.reload();
                } else {
                    alert('Gagal memproduksi tiket HESK: ' + res.message);
                    btn.prop('disabled', false).html('<i class="fa fa-ticket"></i> 🎫 Generate Tiket HESK Terpilih');
                }
            },
            error: function() {
                alert('Terjadi kesalahan koneksi ke server HESK ITSM!');
                btn.prop('disabled', false).html('<i class="fa fa-ticket"></i> 🎫 Generate Tiket HESK Terpilih');
            }
        });
    });

    // Refresh Agenda 1-Click
    $('#btn-generate-agenda').click(function() {
        if (!confirm('Apakah Anda yakin ingin me-refresh agenda cleaning tahun {{ $year }} dari database aset Snipe-IT?')) return;

        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');

        $.ajax({
            url: "{{ route('hardware.analisa.generate_cleaning_agenda') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                year: "{{ $year }}"
            },
            success: function(res) {
                if (res.success) {
                    location.reload();
                } else {
                    alert('Gagal refresh agenda!');
                    btn.prop('disabled', false);
                }
            }
        });
    });

    // Sync Snipe-IT & HESK ITSM
    $('#btn-sync-snipeit').click(function() {
        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Syncing...');

        $.ajax({
            url: "{{ route('hardware.analisa.sync_cleaning_snipeit') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                year: "{{ $year }}"
            },
            success: function(res) {
                if (res.success) {
                    alert(res.message);
                    location.reload();
                } else {
                    alert('Gagal melakukan sinkronisasi!');
                    btn.prop('disabled', false).html('<i class="fa fa-refresh text-blue"></i> Sync Snipe-IT & HESK');
                }
            }
        });
    });

    // Toggle 1-Click Status Cleaning
    $(document).on('click', '.btn-toggle-cleaning', function() {
        var btn = $(this);
        var id = btn.data('id');

        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

        $.ajax({
            url: "{{ route('hardware.analisa.toggle_cleaning_status') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                year: "{{ $year }}",
                id: id
            },
            success: function(res) {
                if (res.success) {
                    location.reload();
                } else {
                    alert('Gagal mengupdate status!');
                    btn.prop('disabled', false);
                }
            }
        });
    });
});
</script>
@stop
