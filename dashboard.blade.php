@extends('layouts/default')
{{-- Page title --}}
@section('title')
{{ trans('general.dashboard') }}
@parent
@stop


{{-- Page content --}}
@section('content')

@if ($snipeSettings->dashboard_message!='')
<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        {!!  Helper::parseEscapedMarkedown($snipeSettings->dashboard_message)  !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="row">

    <!-- panel -->
    <div class="col-lg-2 col-xs-6">
        <a href="{{ route('hardware.index') }}">
            <!-- small hardware box -->
            <div class="dashboard small-box bg-teal">
                <div class="inner">
                    <h3>{{ number_format(\App\Models\Asset::AssetsForShow()->count()) }}</h3>
                    <p>{{ trans('general.assets') }}</p>
                </div>
                <div class="icon" aria-hidden="true">
                    <x-icon type="assets" />
                </div>
                <span class="small-box-footer">
                    {{ trans('general.view_all') }}
                    <x-icon type="arrow-circle-right" />
                </span>
            </div>
        </a>
    </div><!-- ./col -->

    <div class="col-lg-2 col-xs-6">
        <a href="{{ route('licenses.index') }}" aria-hidden="true">
            <!-- small license box -->
            <div class="dashboard small-box bg-maroon">
                <div class="inner">
                    <h3>{{ number_format($counts['license']) }}</h3>
                    <p>{{ trans('general.licenses') }}</p>
                </div>
                <div class="icon" aria-hidden="true">
                    <x-icon type="licenses" />
                </div>
                <span class="small-box-footer">
                    {{ trans('general.view_all') }}
                    <x-icon type="arrow-circle-right" />
                </span>
            </div>
        </a>
    </div><!-- ./col -->


    <div class="col-lg-2 col-xs-6">
    <!-- small accessories box -->
        <a href="{{ route('accessories.index') }}">
            <div class="dashboard small-box bg-orange">
                <div class="inner">
                    <h3> {{ number_format($counts['accessory']) }}</h3>
                    <p>{{ trans('general.accessories') }}</p>
                </div>
                <div class="icon" aria-hidden="true">
                    <x-icon type="accessories" />
                </div>
                <span class="small-box-footer">
                    {{ trans('general.view_all') }}
                <x-icon type="arrow-circle-right" />
                </span>
            </div>
        </a>
    </div><!-- ./col -->

    <div class="col-lg-2 col-xs-6">
    <!-- small consumables box -->
        <a href="{{ route('consumables.index') }}">
            <div class="dashboard small-box bg-purple">
                <div class="inner">
                    <h3> {{ number_format($counts['consumable']) }}</h3>
                    <p>{{ trans('general.consumables') }}</p>
                </div>
                <div class="icon" aria-hidden="true">
                    <x-icon type="consumables" />
                </div>
                <span class="small-box-footer">
                    {{ trans('general.view_all') }}
                    <x-icon type="arrow-circle-right" />
                </span>
            </div>
        </a>
    </div><!-- ./col -->

    <div class="col-lg-2 col-xs-6">
        <!-- small components box -->
        <a href="{{ route('components.index') }}">
            <div class="dashboard small-box bg-yellow">
                <div class="inner">
                    <h3>{{ number_format($counts['component']) }}</h3>
                    <p>{{ trans('general.components') }}</p>
                </div>
                <div class="icon" aria-hidden="true">
                    <x-icon type="components" />
                </div>
                <span class="small-box-footer">
                    {{ trans('general.view_all') }}
                    <x-icon type="arrow-circle-right" />
                </span>
            </div>
        </a>
    </div><!-- ./col -->

    <div class="col-lg-2 col-xs-6">
        <!-- small users box -->
        <a href="{{ route('users.index') }}">
            <div class="dashboard small-box bg-light-blue">
                <div class="inner">
                    <h3>{{ number_format($counts['user']) }}</h3>
                    <p>{{ trans('general.people') }}</p>
                </div>
                <div class="icon" aria-hidden="true">
                    <x-icon type="users" />
                </div>
                <span class="small-box-footer">
                    {{ trans('general.view_all') }}
                    <x-icon type="arrow-circle-right" />
                </span>
            </div>
        </a>
    </div><!-- ./col -->

</div>
</div>

<!--MOD tambahan -->
<div class="row">
<div class="col-lg-2 col-xs-6">
        <a href="{{ route('hardware.index', ['status_id' => 7]) }}">
            <div class="dashboard small-box bg-red">
                <div class="inner">
                    <h3 id="counter-asset-repair">{{ number_format(\App\Models\Asset::AssetsForShow()->where('status_id', 7)->count()) }}</h3>
                    <p>Aset Perbaikan</p>
                </div>
                <div class="icon" aria-hidden="true">
                    <x-icon type="assets" />
                </div>
                <span class="small-box-footer">
                    {{ trans('general.view_all') }}
                    <x-icon type="arrow-circle-right" />
                </span>
            </div>
        </a>
    </div><!-- ./col -->

    <div class="col-lg-2 col-xs-6">
        <a href="{{ route('hardware.index', ['status_id' => 15]) }}">
            <div class="dashboard small-box bg-olive">
                <div class="inner">
                    <h3>{{ number_format(\App\Models\Asset::AssetsForShow()->where('status_id', 15)->count()) }}</h3>
                    <p>Asset Tool</p>
                </div>
                <div class="icon" aria-hidden="true">
                    <x-icon type="assets" />
                </div>
                <span class="small-box-footer">
                    {{ trans('general.view_all') }}
                    <x-icon type="arrow-circle-right" />
                </span>
            </div>
        </a>
    </div><!-- ./col -->

    <div class="col-lg-2 col-xs-6">
        <a href="{{ route('hardware.index', ['status_id' => 14]) }}">
            <div class="dashboard small-box bg-aqua">
                <div class="inner">
                    <h3 id="counter-asset-borrowed">{{ number_format(\App\Models\Asset::AssetsForShow()->where('status_id', 14)->count()) }}</h3>
                    <p>Aset Dipinjamkan</p>
                </div>
                <div class="icon" aria-hidden="true">
                    <x-icon type="assets" />
                </div>
                <span class="small-box-footer">
                    {{ trans('general.view_all') }}
                    <x-icon type="arrow-circle-right" />
                </span>
            </div>
        </a>
    </div><!-- ./col -->
	
	<div class="col-lg-2 col-xs-6">
        <a href="{{ route('hardware.index', ['status_id' => 2]) }}">
            <div class="dashboard small-box bg-green">
                <div class="inner">
                    <h3>{{ number_format(\App\Models\Asset::AssetsForShow()->where('status_id', 2)->count()) }}</h3>
                    <p>Aset Siap Pasang (IT)</p>
                </div>
                <div class="icon" aria-hidden="true">
                    <x-icon type="assets" />
                </div>
                <span class="small-box-footer">
                    {{ trans('general.view_all') }}
                    <x-icon type="arrow-circle-right" />
                </span>
            </div>
        </a>
    </div><!-- ./col -->

</div>

<!-- Widget Agenda Upgrade Hardware (Added by Lexa) -->
@php
    $dashBaseQuery = \DB::table('assets')
        ->leftJoin('models', 'assets.model_id', '=', 'models.id')
        ->leftJoin('categories', 'models.category_id', '=', 'categories.id')
        ->whereNull('assets.deleted_at')
        ->where(function($q) {
            $q->where('_snipeit_jenis_processor_12', 'LIKE', '%Intel%')
              ->orWhere('_snipeit_jenis_processor_12', 'LIKE', '%intel%')
              ->orWhere('_snipeit_jenis_processor_12', 'LIKE', '%Pentium%')
              ->orWhere('_snipeit_jenis_processor_12', 'LIKE', '%Celeron%')
              ->orWhere('_snipeit_jenis_processor_12', 'LIKE', '%Atom%');
        })
        ->where(function($q) {
            $q->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%Core%')
              ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%core%')
              ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%i3%')
              ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%i5%')
              ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%i7%')
              ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%i9%')
              ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%Xeon%')
              ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%xeon%');
        })
        ->where(function($q) {
            $q->where('categories.name', 'NOT LIKE', '%LAPTOP%')
              ->where('categories.name', 'NOT LIKE', '%laptop%')
              ->orWhereNull('categories.name');
        });

    $dashNonCoreTotal = (clone $dashBaseQuery)->count();
    $dashScheduledTotal = (clone $dashBaseQuery)->where('assets.status_id', 17)->count();
    $dashInitialTarget = 57;
    $dashCompletedTotal = max(0, $dashInitialTarget - $dashNonCoreTotal);
    $dashProgressPercent = $dashInitialTarget > 0 ? round(($dashCompletedTotal / $dashInitialTarget) * 100, 1) : 0;
@endphp

<div class="row" style="margin-bottom: 10px;">
    <div class="col-md-12">
        <div class="box box-purple" style="border-top-color: #6f42c1;">
            <div class="box-header with-border" style="background-color: rgba(111, 66, 193, 0.05);">
                <h3 class="box-title" style="font-weight: bold; color: #6f42c1;">
                    <i class="fa fa-line-chart"></i> Agenda Upgrade Hardware PC Non-Core
                </h3>
                <div class="box-tools pull-right">
                    <a href="{{ route('hardware.analisa.cpu_intel_noncore') }}" class="btn btn-xs btn-primary">
                        <i class="fa fa-list"></i> Kelola Terjadwal
                    </a>
                    <a href="{{ route('hardware.analisa.progress_report') }}" class="btn btn-xs" style="background-color: #6f42c1; color: white;">
                        <i class="fa fa-print"></i> Laporan Progress
                    </a>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body" style="padding: 15px 20px;">
                <div class="row" style="display: flex; align-items: center; flex-wrap: wrap;">
                    <div class="col-md-8 col-sm-12" style="margin-bottom: 10px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                            <span style="font-weight: bold; font-size: 11pt;">
                                Progress Upgrade: <span class="text-green">{{ $dashProgressPercent }}%</span>
                            </span>
                            <span style="font-size: 10pt; color: #666;">
                                <strong>{{ $dashCompletedTotal }}</strong> Selesai dari <strong>{{ $dashInitialTarget }}</strong> Target Unit (Sisa <strong>{{ $dashNonCoreTotal }}</strong> PC)
                            </span>
                        </div>
                        <div class="progress" style="height: 22px; margin-bottom: 0; border-radius: 11px; background-color: #e9ecef; box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{ $dashProgressPercent }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $dashProgressPercent }}%; line-height: 22px; font-weight: bold; border-radius: 11px;">
                                {{ $dashProgressPercent }}% Selesai
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 text-center" style="border-left: 1px dashed #ccc;">
                        <div class="row">
                            <div class="col-xs-6">
                                <h3 style="margin: 0; font-weight: bold; color: #6f42c1;">{{ $dashScheduledTotal }}</h3>
                                <small class="text-muted" style="font-weight: bold;">Terjadwal Upgrade</small>
                            </div>
                            <div class="col-xs-6">
                                <h3 style="margin: 0; font-weight: bold;" class="text-red">{{ $dashNonCoreTotal }}</h3>
                                <small class="text-muted" style="font-weight: bold;">Sisa PC Non-Core</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


div>

@if ($counts['grand_total'] == 0)

    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h2 class="box-title">{{ trans('general.dashboard_info') }}</h2>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="progress">
                                <div class="progress-bar progress-bar-yellow" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                    <span class="sr-only">{{ trans('general.60_percent_warning') }}</span>
                                </div>
                            </div>


                            <p><strong>{{ trans('general.dashboard_empty') }}</strong></p>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            @can('create', \App\Models\Asset::class)
                            <a class="btn bg-teal" style="width: 100%" href="{{ route('hardware.create') }}">{{ trans('general.new_asset') }}</a>
                            @endcan
                        </div>
                        <div class="col-md-2">
                            @can('create', \App\Models\License::class)
                                <a class="btn bg-maroon" style="width: 100%" href="{{ route('licenses.create') }}">{{ trans('general.new_license') }}</a>
                            @endcan
                        </div>
                        <div class="col-md-2">
                            @can('create', \App\Models\Accessory::class)
                                <a class="btn bg-orange" style="width: 100%" href="{{ route('accessories.create') }}">{{ trans('general.new_accessory') }}</a>
                            @endcan
                        </div>
                        <div class="col-md-2">
                            @can('create', \App\Models\Consumable::class)
                                <a class="btn bg-purple" style="width: 100%" href="{{ route('consumables.create') }}">{{ trans('general.new_consumable') }}</a>
                            @endcan
                        </div>
                        <div class="col-md-2">
                            @can('create', \App\Models\Component::class)
                                <a class="btn bg-yellow" style="width: 100%" href="{{ route('components.create') }}">{{ trans('general.new_component') }}</a>
                            @endcan
                        </div>
                        <div class="col-md-2">
                            @can('create', \App\Models\User::class)
                                <a class="btn bg-light-blue" style="width: 100%" href="{{ route('users.create') }}">{{ trans('general.new_user') }}</a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@else

<style>
    /* Styling khusus agar kompatibel dengan Dark Mode Snipe-IT */
    #widget-component-stock .table-hover > tbody > tr:hover {
        background-color: rgba(0, 0, 0, 0.05) !important;
    }
    [class*="skin-"][class*="-dark"] #widget-component-stock .table-hover > tbody > tr:hover {
        background-color: rgba(255, 255, 255, 0.1) !important;
    }
    #widget-component-stock .nested-row {
        background-color: rgba(0, 0, 0, 0.02) !important;
    }
    [class*="skin-"][class*="-dark"] #widget-component-stock .nested-row {
        background-color: rgba(255, 255, 255, 0.02) !important;
    }
    #widget-component-stock .nested-table {
        background-color: transparent !important;
        margin: 0;
        border-left: 3px solid rgba(0, 0, 0, 0.15) !important;
    }
    [class*="skin-"][class*="-dark"] #widget-component-stock .nested-table {
        border-left: 3px solid rgba(255, 255, 255, 0.25) !important;
    }
    #widget-component-stock .nested-header {
        background-color: rgba(0, 0, 0, 0.04) !important;
    }
    [class*="skin-"][class*="-dark"] #widget-component-stock .nested-header {
        background-color: rgba(255, 255, 255, 0.05) !important;
    }
    /* Memastikan link nama komponen tetap terbaca di dark mode */
    [class*="skin-"][class*="-dark"] #widget-component-stock a {
        color: #8ab4f8 !important;
    }
</style>


<!-- Draggable connected columns wrapper -->
<div class="row">
    <!-- Left Draggable Column -->
    <div class="col-md-6 connectedSortable" id="dashboard-col-left" style="min-height: 200px; padding-bottom: 50px;">
        
        <!-- Overdue & Due Soon Loans Widget -->
        @can('view', \App\Models\Asset::class)
        <div class="box box-default" id="widget-overdue-loans">
            <div class="box-header with-border">
                <h2 class="box-title">
                    <i class="fa fa-clock text-red" style="margin-right: 5px;"></i> 
                    Aset Dipinjam Melewati / Mendekati Batas Kembali
                </h2>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" aria-hidden="true">
                        <x-icon type="minus" />
                        <span class="sr-only">{{ trans('general.collapse') }}</span>
                    </button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body" style="padding: 0; max-height: 400px; overflow-y: auto;">
                @php
                    $today = \Carbon\Carbon::today();
                    $threeDaysLaterStr = \Carbon\Carbon::today()->addDays(3)->toDateString();
                    $overdueAssets = \App\Models\Asset::whereNotNull('assigned_to')
                        ->whereNotNull('expected_checkin')
                        ->where('expected_checkin', '<=', $threeDaysLaterStr)
                        ->where('status_id', 14)
                        ->orderBy('expected_checkin', 'asc')
                        ->take(20)
                        ->get();
                @endphp

                @if ($overdueAssets->count() > 0)
                    <table class="table table-hover table-striped" style="margin-bottom: 0;">
                        <thead>
                            <tr style="background-color: rgba(0, 0, 0, 0.03);">
                                <th style="padding: 12px 10px 12px 20px;">Nama Aset / Tag</th>
                                <th style="padding: 12px 10px;">Peminjam</th>
                                <th class="text-center" style="padding: 12px 10px;">Tanggal Kembali</th>
                                <th class="text-center" style="padding: 12px 20px 12px 10px;">Status / Keterlambatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($overdueAssets as $asset)
                                @php
                                    $expCheckin = \Carbon\Carbon::parse($asset->expected_checkin)->startOfDay();
                                    $today = \Carbon\Carbon::today();
                                    
                                    if ($expCheckin->lt($today)) {
                                        $days = $expCheckin->diffInDays($today);
                                        $badgeClass = 'label-danger';
                                        $statusText = 'Terlambat ' . $days . ' hari';
                                    } elseif ($expCheckin->eq($today)) {
                                        $badgeClass = 'label-warning';
                                        $statusText = 'Jatuh Tempo Hari Ini';
                                    } else {
                                        $days = $today->diffInDays($expCheckin);
                                        $badgeClass = 'label-info';
                                        $statusText = 'Sisa ' . $days . ' hari (H-' . $days . ')';
                                    }

                                    $assignee = $asset->assignedTo;
                                    if ($assignee) {
                                        if ($asset->assigned_type == 'App\Models\User') {
                                            $assigneeName = $assignee->first_name . ' ' . $assignee->last_name;
                                            $assigneeLink = route('users.show', $assignee->id);
                                            $assigneeIcon = 'fa-user';
                                        } elseif ($asset->assigned_type == 'App\Models\Location') {
                                            $assigneeName = $assignee->name;
                                            $assigneeLink = route('locations.show', $assignee->id);
                                            $assigneeIcon = 'fa-map-marker';
                                        } else {
                                            $assigneeName = $assignee->name;
                                            $assigneeLink = route('hardware.show', $assignee->id);
                                            $assigneeIcon = 'fa-barcode';
                                        }
                                    } else {
                                        $assigneeName = '-';
                                        $assigneeLink = null;
                                        $assigneeIcon = '';
                                    }
                                @endphp
                                <tr>
                                    <td style="padding: 12px 10px 12px 20px; vertical-align: middle;">
                                        @can('view', $asset)
                                            <a href="{{ route('hardware.show', $asset->id) }}">
                                                <strong>{{ $asset->name ?: 'Aset' }}</strong>
                                            </a>
                                        @else
                                            <strong>{{ $asset->name ?: 'Aset' }}</strong>
                                        @endcan
                                        <br>
                                        <small class="text-muted">{{ $asset->asset_tag }}</small>
                                    </td>
                                    <td style="padding: 12px 10px; vertical-align: middle;">
                                        @if($assigneeLink)
                                            <i class="fa {{ $assigneeIcon }} text-muted"></i> 
                                            <a href="{{ $assigneeLink }}">{{ $assigneeName }}</a>
                                        @else
                                            {{ $assigneeName }}
                                        @endif
                                    </td>
                                    <td class="text-center" style="padding: 12px 10px; vertical-align: middle;">
                                        {{ date('d-m-Y', strtotime($asset->expected_checkin)) }}
                                    </td>
                                    <td class="text-center" style="padding: 12px 20px 12px 10px; vertical-align: middle;">
                                        <span class="label {{ $badgeClass }}" style="font-size: 90%;">{{ $statusText }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div style="padding: 20px; text-align: center;" class="text-muted">
                        <i class="fa fa-check-circle text-green" style="font-size: 36px; margin-bottom: 10px; display: block;"></i>
                        <span>Semua aman! Tidak ada peminjaman aset yang melewati atau mendekati batas pengembalian (H-3).</span>
                    </div>
                @endif
            </div>
            <div class="box-footer text-center" style="padding: 8px;">
                <small class="text-muted">
                    <i class="fa fa-info-circle"></i> Menampilkan aset yang dipinjamkan dan melebihi batas atau mendekati estimasi pengembalian (hingga 3 hari ke depan).
                </small>
            </div>
        </div>
        @endcan

        <!-- Recent Activity Widget -->
        <div class="box box-default" id="widget-recent-activity">
            <div class="box-header with-border">
                <h2 class="box-title">{{ trans('general.recent_activity') }}</h2>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" aria-hidden="true">
                        <x-icon type="minus" />
                        <span class="sr-only">{{ trans('general.collapse') }}</span>
                    </button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <table
                            data-cookie-id-table="dashActivityReport"
                            data-height="500"
                            data-pagination="false"
                            data-side-pagination="server"
                            data-id-table="dashActivityReport"
                            data-sort-order="desc"
                            data-show-columns="false"
                            data-fixed-number="false"
                            data-fixed-right-number="false"
                            data-sort-name="created_at"
                            id="dashActivityReport"
                            class="table table-striped snipe-table"
                            data-url="{{ route('api.activity.index', ['limit' => 25]) }}">
                            <thead>
                            <tr>
                                <th data-field="icon" data-visible="true" style="width: 40px;" class="hidden-xs" data-formatter="iconFormatter"><span  class="sr-only">{{ trans('admin/hardware/table.icon') }}</span></th>
                                <th class="col-sm-3" data-visible="true" data-field="created_at" data-formatter="dateDisplayFormatter">{{ trans('general.date') }}</th>
                                <th class="col-sm-2" data-visible="true" data-field="admin" data-formatter="usersLinkObjFormatter">{{ trans('general.created_by') }}</th>
                                <th class="col-sm-2" data-visible="true" data-field="action_type">{{ trans('general.action') }}</th>
                                <th class="col-sm-3" data-visible="true" data-field="item" data-formatter="polymorphicItemFormatter">{{ trans('general.item') }}</th>
                                <th class="col-sm-2" data-visible="true" data-field="target" data-formatter="polymorphicItemFormatter">{{ trans('general.target') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div><!-- /.col -->
                    <div class="text-center col-md-12" style="padding-top: 10px;">
                        <a href="{{ route('reports.activity') }}" class="btn btn-theme btn-sm" style="width: 100%">{{ trans('general.viewall') }}</a>
                    </div>
                </div><!-- /.row -->
            </div><!-- ./box-body -->
        </div><!-- /.box -->

        <!-- Component Stock Widget -->
        <div class="box box-default" id="widget-component-stock">
            <div class="box-header with-border">
                <h2 class="box-title">Stok Komponen per Kategori</h2>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" aria-hidden="true">
                        <x-icon type="minus" />
                        <span class="sr-only">{{ trans('general.collapse') }}</span>
                    </button>
                </div>
            </div><!-- /.box-header -->
            <!-- Sticky Search Bar -->
            <div style="padding: 6px 10px; border-bottom: 1px solid rgba(0, 0, 0, 0.05); background-color: transparent;">
                <div class="has-feedback">
                    <input type="text" id="component-stock-search" class="form-control input-sm" placeholder="Cari kategori atau nama komponen...">
                    <span class="fa fa-search form-control-feedback text-muted" style="line-height: 30px;"></span>
                </div>
            </div>
            <div class="box-body" style="max-height: 400px; overflow-y: auto; padding: 0;">
                @php
                    $allComponentCategories = \App\Models\Category::where('category_type', 'component')
                        ->with('components')
                        ->get()
                        ->filter(function($cat) {
                            return $cat->components->count() > 0;
                        });

                    $hasStockCategories = $allComponentCategories->filter(function($cat) {
                        return $cat->components->sum(function($c) { return $c->numRemaining(); }) > 0;
                    })->sortBy('name');

                    $noStockCategories = $allComponentCategories->filter(function($cat) {
                        return $cat->components->sum(function($c) { return $c->numRemaining(); }) == 0;
                    })->sortBy('name');

                    $dashboardCategories = $hasStockCategories->merge($noStockCategories);
                @endphp
                <table class="table table-hover" style="margin-bottom: 0;">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Terpakai</th>
                            <th class="text-center">Sisa Stok</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dashboardCategories as $cat)
                            @php
                                $totalQty = $cat->components->sum('qty');
                                $totalRemaining = $cat->components->sum(function($c) { return $c->numRemaining(); });
                                $totalUsed = $totalQty - $totalRemaining;
                                
                                // Determine category-level status (if remaining is 0, then Habis, else Ready)
                                if ($totalRemaining == 0) {
                                    $statusBadge = '<span class="label label-danger">Habis</span>';
                                } else {
                                    $statusBadge = '<span class="label label-success">Ready</span>';
                                }
                            @endphp
                            <tr class="category-trigger" style="cursor: pointer;" onclick="toggleCategoryComponents('components-cat-{{ $cat->id }}')">
                                <td>
                                    <i class="fa fa-caret-right text-muted" id="caret-cat-{{ $cat->id }}" style="width: 10px; margin-right: 5px;"></i>
                                    <strong>{{ $cat->name }}</strong>
                                </td>
                                <td class="text-center">{{ number_format($totalQty) }}</td>
                                <td class="text-center">{{ number_format($totalUsed) }}</td>
                                <td class="text-center"><strong>{{ number_format($totalRemaining) }}</strong></td>
                                <td class="text-center">{!! $statusBadge !!}</td>
                            </tr>
                            <tr id="components-cat-{{ $cat->id }}" class="nested-row" style="display: none;">
                                <td colspan="5" style="padding: 0 0 0 15px;">
                                    <table class="table table-condensed table-striped nested-table">
                                        <thead>
                                            <tr class="nested-header">
                                                <th>Nama Komponen</th>
                                                <th class="text-center">Total</th>
                                                <th class="text-center">Terpakai</th>
                                                <th class="text-center">Sisa</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $catHasStockComponents = $cat->components->filter(function($c) { return $c->numRemaining() > 0; })->sortBy('name');
                                                $catNoStockComponents = $cat->components->filter(function($c) { return $c->numRemaining() == 0; })->sortBy('name');
                                                $sortedComponents = $catHasStockComponents->merge($catNoStockComponents);
                                            @endphp
                                            @foreach ($sortedComponents as $component)
                                                @php
                                                    $cRemaining = $component->numRemaining();
                                                    $cUsed = $component->qty - $cRemaining;
                                                    
                                                    // Determine status
                                                    if ($cRemaining == 0) {
                                                        $cStatusBadge = '<span class="label label-danger">Habis</span>';
                                                    } else {
                                                        $cStatusBadge = '<span class="label label-success">Ready</span>';
                                                    }
                                                @endphp
                                                <tr>
                                                    <td>
                                                        @can('view', $component)
                                                            <a href="{{ route('components.show', $component->id) }}">
                                                                {{ $component->name }}
                                                            </a>
                                                        @else
                                                            {{ $component->name }}
                                                        @endcan
                                                        @if($component->model_number || $component->serial)
                                                            <br>
                                                            <small class="text-muted">
                                                                {{ $component->model_number ?: '' }} 
                                                                @if($component->serial) (S/N: {{ $component->serial }}) @endif
                                                            </small>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">{{ number_format($component->qty) }}</td>
                                                    <td class="text-center">{{ number_format($cUsed) }}</td>
                                                    <td class="text-center"><strong>{{ number_format($cRemaining) }}</strong></td>
                                                    <td class="text-center">{!! $cStatusBadge !!}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

        <!-- Component Mutations Widget (Mutasi In Out) -->
        <div class="box box-default" id="widget-component-mutations">
            <div class="box-header with-border">
                <h2 class="box-title">Mutasi Masuk/Keluar Komponen</h2>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" aria-hidden="true">
                        <x-icon type="minus" />
                        <span class="sr-only">{{ trans('general.collapse') }}</span>
                    </button>
                </div>
            </div><!-- /.box-header -->
            <!-- Sticky Search Bar -->
            <div style="padding: 6px 10px; border-bottom: 1px solid rgba(0, 0, 0, 0.05); background-color: transparent;">
                <div class="has-feedback">
                    <input type="text" id="component-mutations-search" class="form-control input-sm" placeholder="Cari tanggal, nama komponen, target, atau admin...">
                    <span class="fa fa-search form-control-feedback text-muted" style="line-height: 30px;"></span>
                </div>
            </div>
            <div class="box-body" style="max-height: 400px; overflow-y: auto; padding: 0;">
                @php
                    $recentComponentMutations = \App\Models\Actionlog::where('item_type', 'App\Models\Component')
                        ->whereIn('action_type', ['checkout', 'checkin from'])
                        ->orderBy('id', 'desc')
                        ->take(20)
                        ->get();
                @endphp
                <table class="table table-hover table-striped" style="margin-bottom: 0;">
                    <thead>
                        <tr style="background-color: rgba(0, 0, 0, 0.03);">
                            <th style="padding: 8px 10px;">Tanggal</th>
                            <th>Komponen</th>
                            <th class="text-center">Tipe</th>
                            <th class="text-center">Qty</th>
                            <th>Target / Lokasi</th>
                            <th>Oleh</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($recentComponentMutations->count() > 0)
                            @foreach ($recentComponentMutations as $log)
                                @php
                                    $logItem = $log->item;
                                    $logTarget = $log->target;
                                    $logAdmin = \App\Models\User::find($log->created_by);
                                    
                                    $badge = ($log->action_type == 'checkout') 
                                        ? '<span class="label label-danger">OUT (Keluar)</span>' 
                                        : '<span class="label label-success">IN (Masuk)</span>';
                                @endphp
                                <tr>
                                    <td style="padding: 8px 10px; white-space: nowrap;">{{ date('d-m-Y H:i', strtotime($log->created_at)) }}</td>
                                    <td>
                                        @if ($logItem)
                                            <a href="{{ route('components.show', $log->item_id) }}">
                                                <strong>{{ $logItem->name }}</strong>
                                            </a>
                                            @if($logItem->model_number || $logItem->serial)
                                                <br>
                                                <small class="text-muted">
                                                    {{ $logItem->model_number ?: '' }} 
                                                    @if($logItem->serial) (S/N: {{ $logItem->serial }}) @endif
                                                </small>
                                            @endif
                                        @else
                                            <span class="text-muted">(Komponen dihapus)</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{!! $badge !!}</td>
                                    <td class="text-center"><strong>{{ number_format($log->quantity) }}</strong></td>
                                    <td>
                                        @if ($logTarget)
                                            @if ($log->target_type == 'App\Models\Asset')
                                                <i class="fa fa-barcode text-muted"></i> 
                                                <a href="{{ route('hardware.show', $log->target_id) }}">
                                                    {{ $logTarget->name }} <small class="text-muted">({{ $logTarget->asset_tag }})</small>
                                                </a>
                                            @elseif ($log->target_type == 'App\Models\User')
                                                <i class="fa fa-user text-muted"></i>
                                                <a href="{{ route('users.show', $log->target_id) }}">
                                                    {{ ($logTarget->display_name ?: $logTarget->first_name . ' ' . $logTarget->last_name) }}
                                                </a>
                                            @else
                                                {{ $logTarget->name }}
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($logAdmin)
                                            <a href="{{ route('users.show', $logAdmin->id) }}">
                                                {{ $logAdmin->first_name }}
                                            </a>
                                        @else
                                            <span class="text-muted">System</span>
                                        @endif
                                    </td>
                                    <td><small class="text-muted">{{ $log->note }}</small></td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center text-muted" style="padding: 15px;">Belum ada riwayat mutasi komponen.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

    </div>

    <!-- Right Draggable Column -->
    <div class="col-md-6 connectedSortable" id="dashboard-col-right" style="min-height: 200px; padding-bottom: 50px;">

    <!-- Widget Status Foto Aset & Breakdown Per Company (Added by Lexa) -->
    @php
        $dashTotalActiveAssets = \DB::table('assets')->whereNull('deleted_at')->count();
        $dashNoImageAssets = \DB::table('assets')
            ->whereNull('deleted_at')
            ->where(function($q) {
                $q->whereNull('image')->orWhere('image', '');
            })->count();
        $dashHasImageAssets = max(0, $dashTotalActiveAssets - $dashNoImageAssets);
        $dashPhotoPercent = $dashTotalActiveAssets > 0 ? round(($dashHasImageAssets / $dashTotalActiveAssets) * 100, 1) : 0;

        $dashCompanyPhotoStats = \DB::table('companies')
            ->select('companies.id', 'companies.name')
            ->orderBy('companies.name', 'ASC')
            ->get();

        $dashCompList = [];
        foreach ($dashCompanyPhotoStats as $comp) {
            $total = \DB::table('assets')->whereNull('deleted_at')->where('company_id', $comp->id)->count();
            if ($total == 0) continue;
            
            $noImg = \DB::table('assets')
                ->whereNull('deleted_at')
                ->where('company_id', $comp->id)
                ->where(function($q) {
                    $q->whereNull('image')->orWhere('image', '');
                })->count();

            $hasImg = max(0, $total - $noImg);
            $percent = $total > 0 ? round(($hasImg / $total) * 100, 1) : 0;

            if ($noImg > 0) {
                $dashCompList[] = [
                    'id' => $comp->id,
                    'name' => $comp->name,
                    'total' => $total,
                    'has_img' => $hasImg,
                    'no_img' => $noImg,
                    'percent' => $percent
                ];
            }
        }

        usort($dashCompList, function($a, $b) {
            return $b['no_img'] <=> $a['no_img'];
        });
    @endphp

    <div class="box box-warning" id="widget-photo-okr-company" style="border-top-color: #f39c12; margin-bottom: 20px;">
        <div class="box-header with-border" style="background-color: rgba(243, 156, 18, 0.05);">
            <h3 class="box-title" style="font-weight: bold; color: #d35400; font-size: 11pt;">
                <i class="fa fa-camera text-orange" style="margin-right: 5px;"></i> Status Foto Fisik Aset Per Perusahaan (OKR)
            </h3>
            <div class="box-tools pull-right">
                <a href="{{ route('hardware.index') }}?search=no_image" class="btn btn-xs btn-warning" style="background-color: #f39c12; color: white; border-color: #e08e0b;">
                    <i class="fa fa-search"></i> {{ number_format($dashNoImageAssets) }} Kurang Foto
                </a>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        
        <div class="box-body" style="padding: 12px 15px; border-bottom: 1px solid #f4f4f4; background: #fffcf8;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                <span style="font-weight: bold; font-size: 10.5pt; color: #333;">
                    Kelengkapan Total: <span class="text-orange">{{ $dashPhotoPercent }}%</span>
                </span>
                <small style="color: #666;">
                    <strong>{{ number_format($dashHasImageAssets) }}</strong> / <strong>{{ number_format($dashTotalActiveAssets) }}</strong> Aset Berfoto
                </small>
            </div>
            <div class="progress" style="height: 14px; margin-bottom: 0; border-radius: 7px; background-color: #e9ecef;">
                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="{{ $dashPhotoPercent }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $dashPhotoPercent }}%; line-height: 14px; font-weight: bold; font-size: 9px; background-color: #f39c12; border-radius: 7px;">
                    {{ $dashPhotoPercent }}%
                </div>
            </div>
        </div>

        <div class="box-body table-responsive" style="padding: 0; max-height: 280px; overflow-y: auto;">
            <table class="table table-striped table-condensed text-sm" style="margin-bottom: 0;">
                <thead>
                    <tr style="background: #fcfcfc;">
                        <th>Perusahaan</th>
                        <th style="width: 120px;">Kelengkapan</th>
                        <th style="text-align: center; width: 90px;">Kurang (Unit)</th>
                        <th style="text-align: center; width: 45px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dashCompList as $c)
                    <tr>
                        <td style="font-weight: 600; vertical-align: middle;">
                            {{ $c['name'] }}
                        </td>
                        <td style="vertical-align: middle;">
                            <div style="display: flex; align-items: center; gap: 4px;">
                                <div class="progress" style="height: 9px; margin-bottom: 0; flex-grow: 1; border-radius: 5px; background-color: #e9ecef;">
                                    <div class="progress-bar {{ $c['percent'] < 50 ? 'progress-bar-danger' : ($c['percent'] < 85 ? 'progress-bar-warning' : 'progress-bar-success') }}" role="progressbar" style="width: {{ $c['percent'] }}%; border-radius: 5px;"></div>
                                </div>
                                <small style="font-weight: bold; width: 36px; text-align: right; font-size: 8pt;">{{ $c['percent'] }}%</small>
                            </div>
                        </td>
                        <td style="text-align: center; vertical-align: middle;">
                            <span class="label {{ $c['no_img'] > 20 ? 'label-danger' : 'label-warning' }}" style="font-size: 8.5pt; font-weight: bold;">
                                {{ $c['no_img'] }} Unit
                            </span>
                        </td>
                        <td style="text-align: center; vertical-align: middle;">
                            <a href="{{ route('hardware.index') }}?company_id={{ $c['id'] }}" class="btn btn-xs btn-default" title="Filter Aset {{ $c['name'] }}">
                                <i class="fa fa-filter text-orange"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

        
        <!-- Expiring Licenses Widget -->
        @can('view', \App\Models\License::class)
        <div class="box box-default" id="widget-expiring-licenses">
            <div class="box-header with-border">
                <h2 class="box-title">
                    <i class="fa fa-exclamation-triangle text-yellow" style="margin-right: 5px;"></i> 
                    Lisensi & Domain Kadaluarsa
                </h2>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" aria-hidden="true">
                        <x-icon type="minus" />
                        <span class="sr-only">{{ trans('general.collapse') }}</span>
                    </button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body" style="padding: 0;">
                @php
                    $today = \Carbon\Carbon::today();
                    $thirtyDaysAgo = \Carbon\Carbon::today()->subDays(30);
                    $ninetyDaysFromNow = \Carbon\Carbon::today()->addDays(90);
                    
                    $expiringLicenses = \App\Models\License::whereNotNull('expiration_date')
                        ->where('expiration_date', '>=', $thirtyDaysAgo->toDateString())
                        ->where('expiration_date', '<=', $ninetyDaysFromNow->toDateString())
                        ->orderBy('expiration_date', 'asc')
                        ->get();
                @endphp

                @if ($expiringLicenses->count() > 0)
                    <table class="table table-hover table-striped" style="margin-bottom: 0;">
                        <thead>
                            <tr style="background-color: rgba(0, 0, 0, 0.03);">
                                <th style="padding: 10px;">Nama Lisensi / Domain</th>
                                <th class="text-center">Tanggal Kadaluarsa</th>
                                <th class="text-center">Status / Sisa Hari</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($expiringLicenses as $license)
                                @php
                                    $expDate = \Carbon\Carbon::parse($license->expiration_date);
                                    $daysRemaining = $today->diffInDays($expDate, false);
                                    
                                    if ($daysRemaining < 0) {
                                        $badgeClass = 'label-danger';
                                        $badgeText = 'Expired (' . abs($daysRemaining) . ' hari lalu)';
                                    } elseif ($daysRemaining == 0) {
                                        $badgeClass = 'label-danger';
                                        $badgeText = 'Hari ini';
                                    } elseif ($daysRemaining == 1) {
                                        $badgeClass = 'label-danger';
                                        $badgeText = '1 hari lagi';
                                    } elseif ($daysRemaining <= 7) {
                                        $badgeClass = 'label-danger';
                                        $badgeText = $daysRemaining . ' hari lagi';
                                    } elseif ($daysRemaining <= 30) {
                                        $badgeClass = 'label-warning';
                                        $badgeText = $daysRemaining . ' hari lagi';
                                    } else {
                                        $badgeClass = 'label-info';
                                        $badgeText = $daysRemaining . ' hari lagi';
                                    }
                                @endphp
                                <tr>
                                    <td style="padding: 10px; vertical-align: middle;">
                                        @can('view', $license)
                                            <a href="{{ route('licenses.show', $license->id) }}">
                                                <strong>{{ $license->name }}</strong>
                                            </a>
                                        @else
                                            <strong>{{ $license->name }}</strong>
                                        @endcan
                                        @if($license->serial)
                                            <br>
                                            <small class="text-muted" style="font-family: monospace;">
                                                Key: {{ substr($license->serial, 0, 20) . (strlen($license->serial) > 20 ? '...' : '') }}
                                            </small>
                                        @endif
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        {{ date('d-m-Y', strtotime($license->expiration_date)) }}
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <span class="label {{ $badgeClass }}" style="font-size: 90%;">{{ $badgeText }}</span>
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        @can('update', $license)
                                            <a href="{{ route('licenses.edit', $license->id) }}" class="btn btn-default btn-xs" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        @endcan
                                        @can('view', $license)
                                            <a href="{{ route('licenses.show', $license->id) }}" class="btn btn-default btn-xs" title="Detail">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div style="padding: 20px; text-align: center;" class="text-muted">
                        <i class="fa fa-check-circle text-green" style="font-size: 36px; margin-bottom: 10px; display: block;"></i>
                        <span>Semua aman! Tidak ada lisensi/domain yang kadaluarsa dalam 90 hari.</span>
                    </div>
                @endif
            </div><!-- /.box-body -->
            <div class="box-footer text-center" style="padding: 8px;">
                <small class="text-muted">
                    <i class="fa fa-info-circle"></i> Menampilkan lisensi/domain yang kadaluarsa dalam 90 hari ke depan dan 30 hari ke belakang.
                </small>
            </div>
        </div><!-- /.box -->
        @endcan




        <!-- Companies / Locations Widget -->
        @if ((($snipeSettings->scope_locations_fmcs!='1') && ($snipeSettings->full_multiple_companies_support=='1')))
            


<div class="box box-default" id="widget-companies-locations">
                <div class="box-header with-border">
                    <h2 class="box-title">{{ trans('general.companies') }}</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <x-icon type="minus" />
                            <span class="sr-only">{{ trans('general.collapse') }}</span>
                        </button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table
                                    data-cookie-id-table="dashCompanySummary"
                                    data-height="400"
                                    data-pagination="false"
                                    data-side-pagination="server"
                                    data-sort-order="desc"
                                    data-show-columns="false"
                                    data-fixed-number="false"
                                    data-fixed-right-number="false"
                                    data-sort-field="assets_count"
                                    id="dashCompanySummary"
                                    class="table table-striped snipe-table"
                                    data-url="{{ route('api.companies.index', ['sort' => 'assets_count', 'order' => 'asc']) }}">
                                <thead>
                                <tr>
                                    <th class="col-sm-3" data-visible="true" data-field="name" data-formatter="companiesLinkFormatter" data-sortable="true">{{ trans('general.name') }}</th>
                                    <th class="col-sm-1" data-visible="true" data-field="users_count" data-sortable="true">
                                        <x-icon type="users" />
                                        <span class="sr-only">{{ trans('general.people') }}</span>
                                    </th>
                                    <th class="col-sm-1" data-visible="true" data-field="assets_count" data-sortable="true">
                                        <x-icon type="assets" />
                                        <span class="sr-only">{{ trans('general.asset_count') }}</span>
                                    </th>
                                    <th class="col-sm-1" data-visible="true" data-field="accessories_count" data-sortable="true">
                                        <x-icon type="accessories" />
                                        <span class="sr-only">{{ trans('general.accessories_count') }}</span>
                                    </th>
                                    <th class="col-sm-1" data-visible="true" data-field="consumables_count" data-sortable="true">
                                        <x-icon type="consumables" />
                                        <span class="sr-only">{{ trans('general.consumables_count') }}</span>
                                    </th>
                                    <th class="col-sm-1" data-visible="true" data-field="components_count" data-sortable="true">
                                        <x-icon type="components" />
                                        <span class="sr-only">{{ trans('general.components_count') }}</span>
                                    </th>
                                    <th class="col-sm-1" data-visible="true" data-field="licenses_count" data-sortable="true">
                                        <x-icon type="licenses" />
                                        <span class="sr-only">{{ trans('general.licenses_count') }}</span>
                                    </th>
                                </tr>
                                </thead>
                            </table>
                        </div> <!-- /.col -->
                        <div class="text-center col-md-12" style="padding-top: 10px;">
                            <a href="{{ route('companies.index') }}" class="btn btn-theme btn-sm" style="width: 100%">{{ trans('general.viewall') }}</a>
                        </div>
                    </div> <!-- /.row -->
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        @else
            <div class="box box-default" id="widget-companies-locations">
                <div class="box-header with-border">
                    <h2 class="box-title">{{ trans('general.locations') }}</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <x-icon type="minus" />
                            <span class="sr-only">{{ trans('general.collapse') }}</span>
                        </button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table
                                    data-cookie-id-table="dashLocationSummary"
                                    data-height="400"
                                    data-side-pagination="server"
                                    data-pagination="false"
                                    data-sort-order="desc"
                                    data-fixed-number="false"
                                    data-fixed-right-number="false"
                                    data-sort-field="assets_count"
                                    id="dashLocationSummary"
                                    data-show-columns="false"
                                    class="table table-striped snipe-table"
                                    data-url="{{ route('api.locations.index', ['sort' => 'assets_count', 'order' => 'asc']) }}">
                                <thead>
                                <tr>
                                    <th class="col-sm-3" data-visible="true" data-field="name" data-formatter="locationsLinkFormatter" data-sortable="true">{{ trans('general.name') }}</th>
                                    <th class="col-sm-1" data-visible="true" data-field="assets_count" data-sortable="true">
                                        <x-icon type="assets" />
                                        <span class="sr-only">{{ trans('general.asset_count') }}</span>
                                    </th>
                                    <th class="col-sm-1" data-visible="true" data-field="assigned_assets_count" data-sortable="true">
                                        {{ trans('general.assigned') }}
                                    </th>
                                    <th class="col-sm-1" data-visible="true" data-field="users_count" data-sortable="true">
                                        <x-icon type="users" />
                                        <span class="sr-only">{{ trans('general.people') }}</span>
                                    </th>
                                </tr>
                                </thead>
                            </table>
                        </div> <!-- /.col -->
                        <div class="text-center col-md-12" style="padding-top: 10px;">
                            <a href="{{ route('locations.index') }}" class="btn btn-theme btn-sm" style="width: 100%">{{ trans('general.viewall') }}</a>
                        </div>
                    </div> <!-- /.row -->
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        @endif

        <!-- Asset Categories Widget -->
        <div class="box box-default" id="widget-asset-categories">
            <div class="box-header with-border">
                <h2 class="box-title">{{ trans('general.asset') }} {{ trans('general.categories') }}</h2>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <x-icon type="minus" />
                        <span class="sr-only">{{ trans('general.collapse') }}</span>
                    </button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <table
                                data-cookie-id-table="dashCategorySummary"
                                data-height="400"
                                data-pagination="false"
                                data-side-pagination="server"
                                data-show-columns="false"
                                data-fixed-number="false"
                                data-fixed-right-number="false"
                                data-sort-order="desc"
                                data-sort-field="assets_count"
                                id="dashCategorySummary"
                                class="table table-striped snipe-table"
                                data-url="{{ route('api.categories.index', ['sort' => 'assets_count', 'order' => 'asc']) }}">
                            <thead>
                            <tr>
                                <th class="col-sm-3" data-visible="true" data-field="name" data-formatter="categoriesLinkFormatter" data-sortable="true">{{ trans('general.name') }}</th>
                                <th class="col-sm-3" data-visible="true" data-field="category_type" data-sortable="true">
                                    {{ trans('general.type') }}
                                </th>
                                <th class="col-sm-1" data-visible="true" data-field="assets_count" data-sortable="true">
                                    <x-icon type="assets" />
                                    <span class="sr-only">{{ trans('general.asset_count') }}</span>
                                </th>
                                <th class="col-sm-1" data-visible="true" data-field="accessories_count" data-sortable="true">
                                    <x-icon type="licenses" />
                                    <span class="sr-only">{{ trans('general.accessories_count') }}</span>
                                </th>
                                <th class="col-sm-1" data-visible="true" data-field="consumables_count" data-sortable="true">
                                    <x-icon type="consumables" />
                                    <span class="sr-only">{{ trans('general.consumables_count') }}</span>
                                </th>
                                <th class="col-sm-1" data-visible="true" data-field="components_count" data-sortable="true">
                                    <x-icon type="components" />
                                    <span class="sr-only">{{ trans('general.components_count') }}</span>
                                </th>
                                <th class="col-sm-1" data-visible="true" data-field="licenses_count" data-sortable="true">
                                    <x-icon type="licenses" />
                                    <span class="sr-only">{{ trans('general.licenses_count') }}</span>
                                </th>
                            </tr>
                            </thead>
                        </table>
                    </div> <!-- /.col -->
                    <div class="text-center col-md-12" style="padding-top: 10px;">
                        <a href="{{ route('categories.index') }}" class="btn btn-theme btn-sm" style="width: 100%">{{ trans('general.viewall') }}</a>
                    </div>
                </div> <!-- /.row -->
            </div><!-- /.box-body -->
        </div><!-- /.box -->

        <!-- Status Chart Widget (Graph Pie Terakhir) -->
        <div class="box box-default" id="widget-status-chart">
            <div class="box-header with-border">
                <h2 class="box-title">
                    {{ (\App\Models\Setting::getSettings()->dash_chart_type == 'name') ? trans('general.assets_by_status') : trans('general.assets_by_status_type') }}
                </h2>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" aria-hidden="true">
                        <x-icon type="minus" />
                        <span class="sr-only">{{ trans('general.collapse') }}</span>
                    </button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="chart-responsive">
                            <canvas id="statusPieChart" height="260"></canvas>
                        </div> <!-- ./chart-responsive -->
                    </div> <!-- /.col -->
                </div> <!-- /.row -->
            </div><!-- /.box-body -->
        </div> <!-- /.box -->

    </div>
</div>
@endif


@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['simple_view' => true, 'nopages' => true])
@stop

@push('js')


        <script src="{{ url(mix('js/dist/Chart.min.js')) }}"></script>
<script nonce="{{ csrf_token() }}">
    // ---------------------------
    // - ASSET STATUS CHART -
    // ---------------------------
      var pieChartCanvas = $("#statusPieChart").get(0).getContext("2d");
      var pieChart = new Chart(pieChartCanvas);
      var ctx = document.getElementById("statusPieChart");
      var pieOptions = {
              legend: {
                  position: 'top',
                  responsive: true,
                  maintainAspectRatio: true,
              },
              tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        counts = data.datasets[0].data;
                        total = 0;
                        for(var i in counts) {
                            total += counts[i];
                        }
                        prefix = data.labels[tooltipItem.index] || '';
                        return prefix+" "+Math.round(counts[tooltipItem.index]/total*100)+"%";
                    }
                }
              }
          };

      $.ajax({
          type: 'GET',
          url: '{{ (\App\Models\Setting::getSettings()->dash_chart_type == 'name') ? route('api.statuslabels.assets.byname') : route('api.statuslabels.assets.bytype') }}',
          headers: {
              "X-Requested-With": 'XMLHttpRequest',
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
          },
          dataType: 'json',
          success: function (data) {
              var myPieChart = new Chart(ctx,{
                  type   : 'pie',
                  data   : data,
                  options: pieOptions
              });
          },
          error: function (data) {
              // window.location.reload(true);
          },
      });
        var last = document.getElementById('statusPieChart').clientWidth;
        addEventListener('resize', function() {
        var current = document.getElementById('statusPieChart').clientWidth;
        if (current != last) location.reload();
        last = current;
    });

    // ---------------------------
    // - DRAGGABLE WIDGETS LOGIC -
    // ---------------------------
    function initSortable() {
        $(".connectedSortable").sortable({
            placeholder: "sort-highlight",
            connectWith: ".connectedSortable",
            handle: ".box-header",
            forcePlaceholderSize: true,
            zIndex: 999999,
            update: function(event, ui) {
                saveDashboardState();
            }
        });
        $(".connectedSortable .box-header").css("cursor", "move");
    }

    function saveDashboardState() {
        var leftIds = [];
        var rightIds = [];
        $("#dashboard-col-left > .box").each(function() {
            var id = $(this).attr("id");
            if (id) leftIds.push(id);
        });
        $("#dashboard-col-right > .box").each(function() {
            var id = $(this).attr("id");
            if (id) rightIds.push(id);
        });
        localStorage.setItem("snipeit_dashboard_left_col_v3", JSON.stringify(leftIds));
        localStorage.setItem("snipeit_dashboard_right_col_v3", JSON.stringify(rightIds));
    }

    function restoreDashboardState() {
        var leftCol = $("#dashboard-col-left");
        var rightCol = $("#dashboard-col-right");
        var leftIds = localStorage.getItem("snipeit_dashboard_left_col_v3");
        var rightIds = localStorage.getItem("snipeit_dashboard_right_col_v3");
        
        if (leftIds) {
            var ids = JSON.parse(leftIds);
            $.each(ids, function(index, id) {
                var widget = $("#" + id);
                if (widget.length) {
                    leftCol.append(widget);
                }
            });
        }
        if (rightIds) {
            var ids = JSON.parse(rightIds);
            $.each(ids, function(index, id) {
                var widget = $("#" + id);
                if (widget.length) {
                    rightCol.append(widget);
                }
            });
        }
    }

    function toggleCategoryComponents(targetId) {
        var targetRow = document.getElementById(targetId);
        var catId = targetId.replace('components-cat-', '');
        var caret = document.getElementById('caret-cat-' + catId);
        
        if (targetRow) {
            if (targetRow.style.display === 'none') {
                targetRow.style.display = '';
                if (caret) {
                    caret.className = 'fa fa-caret-down text-muted';
                }
            } else {
                targetRow.style.display = 'none';
                if (caret) {
                    caret.className = 'fa fa-caret-right text-muted';
                }
            }
        }
    }

    $(document).ready(function() {
        restoreDashboardState();
        if (typeof $.fn.sortable === 'undefined') {
            var script = document.createElement('script');
            script.src = "https://code.jquery.com/ui/1.12.1/jquery-ui.min.js";
            script.type = "text/javascript";
            document.getElementsByTagName('head')[0].appendChild(script);
            script.onload = initSortable;
        } else {
            initSortable();
        }

        // Live Search untuk Stok Komponen per Kategori
        $("#component-stock-search").on("keyup input", function() {
            var value = $(this).val().toLowerCase().trim();
            
            if (value === "") {
                // Tampilkan semua baris kategori & sembunyikan semua rincian komponen
                $("#widget-component-stock tbody > tr").each(function() {
                    var tr = $(this);
                    var id = tr.attr("id") || "";
                    if (id.indexOf("components-cat-") === 0) {
                        tr.hide();
                    } else {
                        tr.show();
                        var catId = tr.attr("onclick") ? tr.attr("onclick").match(/\d+/) : null;
                        if (catId) {
                            $("#caret-cat-" + catId).removeClass("fa-caret-down").addClass("fa-caret-right");
                        }
                    }
                });
                return;
            }

            // Lakukan filter pencarian
            $("#widget-component-stock tbody > tr:not([id^='components-cat-'])").each(function() {
                var catRow = $(this);
                var catName = catRow.find("strong").text().toLowerCase();
                var catId = catRow.attr("onclick") ? catRow.attr("onclick").match(/\d+/)[0] : null;
                var subRow = $("#components-cat-" + catId);
                
                var hasMatchingComponent = false;
                if (subRow.length) {
                    var compRows = subRow.find("tbody > tr");
                    compRows.each(function() {
                        var compRow = $(this);
                        var compName = compRow.find("td:first").text().toLowerCase();
                        
                        if (compName.indexOf(value) > -1) {
                            compRow.show();
                            hasMatchingComponent = true;
                        } else {
                            compRow.hide();
                        }
                    });
                }
                
                if (catName.indexOf(value) > -1 || hasMatchingComponent) {
                    catRow.show();
                    if (hasMatchingComponent) {
                        // Tampilkan & expand subrow komponen yang cocok
                        subRow.show();
                        $("#caret-cat-" + catId).removeClass("fa-caret-right").addClass("fa-caret-down");
                    } else {
                        // Jika kategori cocok tapi komponen tidak, sembunyikan subrow (kecuali diklik manual)
                        subRow.find("tbody > tr").show();
                        subRow.hide();
                        $("#caret-cat-" + catId).removeClass("fa-caret-down").addClass("fa-caret-right");
                    }
                } else {
                    catRow.hide();
                    subRow.hide();
                }
            });
        });

        // Live Search untuk Mutasi Komponen
        $("#component-mutations-search").on("keyup input", function() {
            var value = $(this).val().toLowerCase().trim();
            
            $("#widget-component-mutations tbody > tr").each(function() {
                var tr = $(this);
                // Lewatkan baris "tidak ada mutasi" jika tampil
                if (tr.find("td").length === 1 && tr.find("td").hasClass("text-muted")) {
                    return;
                }
                
                var text = tr.text().toLowerCase();
                if (text.indexOf(value) > -1) {
                    tr.show();
                } else {
                    tr.hide();
                }
            });
        });

    });
</script>
@endpush
