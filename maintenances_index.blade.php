@extends('layouts/default')

{{-- Page title --}}
@section('title')
  {{ trans('admin/maintenances/general.asset_maintenances') }}
  @parent
@stop


{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-12">
  
  <center><h2><strong>📌 Jangan Lupa tambahkan <em>Tiket ID</em> di setiap laporan maintenance!</strong></h2></center>
<center> contoh : Y6R-ZVG-3N9U - Perbaikan mati karena kotor </center>
<h3 style="margin-bottom:12px;">
  <strong>🛠️ Maintenance Report Kategori</strong>
</h3>

<table width="700" cellpadding="8" cellspacing="0"
       style="border-collapse:collapse; border:1px solid #ccc;">

  <tr style="background:#f5f5f5;">
    <th width="180" align="left" style="border:1px solid #ccc;">Kategori</th>
    <th align="left" style="border:1px solid #ccc;">Deskripsi</th>
  </tr>

  <tr>
    <td style="border:1px solid #ccc;"><strong>🚀 Upgrade</strong></td>
    <td style="border:1px solid #ccc;">
      Peningkatan spesifikasi atau performa perangkat<br>
      <em>Contoh:</em> HDD → SSD, RAM 4GB → 8GB
    </td>
  </tr>

  <tr>
    <td style="border:1px solid #ccc;"><strong>🛠️ Repair</strong></td>
    <td style="border:1px solid #ccc;">
      Perbaikan perangkat akibat kerusakan atau kegagalan fungsi<br>
      <em>Contoh:</em> ganti SSD rusak, perbaikan mainboard, fan mati, roller patah
    </td>
  </tr>

  <tr>
    <td style="border:1px solid #ccc;"><strong>💻 Software Support</strong></td>
    <td style="border:1px solid #ccc;">
      Penanganan pada sisi software atau sistem<br>
      <em>Contoh:</em> install ulang OS, update aplikasi, reaktivasi lisensi
    </td>
  </tr>

  <tr>
    <td style="border:1px solid #ccc;"><strong>🧼 Maintenance</strong></td>
    <td style="border:1px solid #ccc;">
      Perawatan rutin atau preventif untuk menjaga performa<br>
      <em>Contoh:</em> cleaning PC, printer, cleaning print head
    </td>
  </tr>

  <tr>
    <td style="border:1px solid #ccc;"><strong>⚙️ Configuration Change</strong></td>
    <td style="border:1px solid #ccc;">
      Perubahan konfigurasi atau penataan ulang perangkat tanpa peningkatan spesifikasi<br>
      <em>Contoh:</em> tukar SSD antar unit, tukar RAM antar PC, ganti IP address, pindah perangkat user
    </td>
  </tr>

</table>


<br/>
    <x-container>
        <x-box>

              <table
                  data-columns="{{ \App\Presenters\MaintenancesPresenter::dataTableLayout() }}"
                  data-cookie-id-table="maintenancesTable"
                  data-side-pagination="server"
                  data-show-footer="true"
                  data-advanced-search="false"
                  id="maintenancesTable"
                  data-buttons="maintenanceButtons"
                  class="table table-striped snipe-table"
                  data-url="{{route('api.maintenances.index') }}"
                  data-export-options='{
                    "fileName": "export-maintenances-{{ date('Y-m-d') }}",
                        "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                  }'>
            </table>

        </x-box>
    </x-container>
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'maintenances-export', 'search' => true])
<script nonce="{{ csrf_token() }}">
    function maintenanceActions(value, row) {
        var actions = '<nobr>';
        if ((row) && (row.available_actions.update === true)) {
            actions += '<a href="{{ config('app.url') }}/hardware/maintenances/' + row.id + '/edit" class="btn btn-sm btn-warning" data-tooltip="true" title="Update"><i class="fas fa-pencil-alt"></i></a>&nbsp;';
        }
        actions += '</nobr>'
        if ((row) && (row.available_actions.delete === true)) {
            actions += '<a href="{{ config('app.url') }}/hardware/maintenances/' + row.id + '" '
                + ' class="btn btn-danger btn-sm delete-asset"  data-tooltip="true"  '
                + ' data-toggle="modal" '
                + ' data-content="{{ trans('general.sure_to_delete') }} ' + row.name + '?" '
                + ' data-title="{{  trans('general.delete') }}" onClick="return false;">'
                + '<i class="fas fa-trash"></i></a></nobr>';
        }

        return actions;
    }

</script>
@stop
