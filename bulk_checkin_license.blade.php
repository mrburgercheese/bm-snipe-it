@extends('layouts/default')

{{-- Page title --}}
@section('title')
Bulk Check-in Akses CCTV
@parent
@stop

@section('header_right')
    <a href="{{ route('home') }}" class="btn btn-default pull-right">{{ trans('general.back') }}</a>
@stop

{{-- Page content --}}
@section('content')
<div class="row">
    <div class="col-md-12">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fas fa-check"></i> Sukses!</h4>
                {!! session('success') !!}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fas fa-ban"></i> Error!</h4>
                {!! session('error') !!}
            </div>
        @endif

        <form class="form-horizontal" method="post" action="{{ route('custom.bulk_license.checkin_process') }}" autocomplete="off">
            {{ csrf_field() }}

            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Bulk Check-in Akses CCTV (Tarik Hak Akses Karyawan)</h3>
                </div>
                <div class="box-body">

                    <!-- Note -->
                    <div class="form-group {{ $errors->has('notes') ? 'has-error' : '' }}">
                        <label for="notes" class="col-md-3 control-label">Catatan Penarikan (Check-in)</label>
                        <div class="col-md-7">
                            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Contoh: Penarikan akses karena perubahan wewenang / mutasi kerja">{{ old('notes') }}</textarea>
                            {!! $errors->first('notes', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                        </div>
                    </div>

                    <hr>

                    <!-- Search Filter Table -->
                    <div class="form-group">
                        <label class="col-md-3 control-label">Cari Karyawan / Kamera (Filter)</label>
                        <div class="col-md-7">
                            <input type="text" id="tableFilter" class="form-control" placeholder="Ketik nama karyawan atau nama kamera untuk memfilter list, misal: Fahmi, Bali, Office...">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            @if($seats->count() > 0)
                                <table class="table table-bordered table-striped table-hover" id="checkinTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 40px; text-align: center;">
                                                <input type="checkbox" id="checkAll">
                                            </th>
                                            <th>Nama Lisensi Kamera</th>
                                            <th>Asset Tag Kamera (Serial)</th>
                                            <th>Di-checkout Ke (Karyawan)</th>
                                            <th>Tanggal Penyerahan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($seats as $seat)
                                            <tr class="seat-row">
                                                <td style="text-align: center;">
                                                    <input type="checkbox" name="seat_ids[]" value="{{ $seat->id }}" class="seat-checkbox">
                                                </td>
                                                <td class="license-name">{{ $seat->license->name ?? '' }}</td>
                                                <td class="license-serial"><code>{{ $seat->license->serial ?? '' }}</code></td>
                                                <td class="user-name">
                                                    <strong>{{ $seat->user->present()->fullName ?? '' }}</strong> 
                                                    ({{ $seat->user->username ?? '' }})
                                                </td>
                                                <td>{{ $seat->updated_at ? $seat->updated_at->format('Y-m-d H:i:s') : '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="alert alert-info text-center">
                                    <i class="fa fa-info-circle"></i> Saat ini tidak ada hak akses CCTV aktif yang sedang digunakan oleh karyawan.
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
                
                @if($seats->count() > 0)
                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-warning" id="btnSubmit" style="margin-right: 80px;" disabled>
                            <i class="fa fa-undo"></i> Tarik Hak Akses Selected
                        </button>
                    </div>
                @endif
            </div>
        </form>
    </div>
</div>
@stop

@section('moar_scripts')
<script>
    $(document).ready(function() {
        // Check/Uncheck All (only visible/filtered checkboxes)
        $('#checkAll').change(function() {
            var checked = $(this).prop('checked');
            $('.seat-row:visible').find('.seat-checkbox').prop('checked', checked);
            updateSubmitButton();
        });

        // Individual checkbox change
        $(document).on('change', '.seat-checkbox', function() {
            updateSubmitButton();
        });

        // Client side filtering
        $('#tableFilter').keyup(function() {
            var value = $(this).val().toLowerCase();
            $('#checkinTable tbody tr').filter(function() {
                var nameText = $(this).find('.license-name').text().toLowerCase();
                var serialText = $(this).find('.license-serial').text().toLowerCase();
                var userText = $(this).find('.user-name').text().toLowerCase();
                var match = nameText.indexOf(value) > -1 || serialText.indexOf(value) > -1 || userText.indexOf(value) > -1;
                $(this).toggle(match);
            });
        });

        function updateSubmitButton() {
            var anyChecked = $('.seat-checkbox:checked').length > 0;
            $('#btnSubmit').prop('disabled', !anyChecked);
        }
    });
</script>
@stop
