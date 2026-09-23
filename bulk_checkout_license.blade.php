@extends('layouts/default')

{{-- Page title --}}
@section('title')
Bulk Checkout Akses CCTV
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

        <form class="form-horizontal" method="post" action="{{ route('custom.bulk_license.process') }}" autocomplete="off">
            {{ csrf_field() }}

            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Bulk Checkout Akses CCTV / HikConnect</h3>
                </div>
                <div class="box-body">
                    
                    <!-- Select Karyawan -->
                    @include ('partials.forms.edit.user-select', ['translated_name' => 'Pilih Karyawan / User', 'fieldname' => 'assigned_to', 'required' => 'true'])

                    <!-- Note -->
                    <div class="form-group {{ $errors->has('notes') ? 'has-error' : '' }}">
                        <label for="notes" class="col-md-3 control-label">Catatan Checkout</label>
                        <div class="col-md-7">
                            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Contoh: Pemberian akses CCTV atas persetujuan Unit Head">{{ old('notes') }}</textarea>
                            {!! $errors->first('notes', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                        </div>
                    </div>

                    <hr>

                    <!-- Search Filter Table -->
                    <div class="form-group">
                        <label class="col-md-3 control-label">Cari Kamera (Filter)</label>
                        <div class="col-md-7">
                            <input type="text" id="tableFilter" class="form-control" placeholder="Ketik untuk memfilter list kamera, misal: Bali, Office, Loading...">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <table class="table table-bordered table-striped table-hover" id="licenseTable">
                                <thead>
                                    <tr>
                                        <th style="width: 40px; text-align: center;">
                                            <input type="checkbox" id="checkAll">
                                        </th>
                                        <th>Nama Lisensi Kamera</th>
                                        <th>Asset Tag Kamera (Serial)</th>
                                        <th style="width: 150px; text-align: center;">Seat Tersedia</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($licenses as $license)
                                        @php
                                            $freeSeats = $license->licenseseats()->whereNull('assigned_to')->count();
                                        @endphp
                                        <tr class="license-row">
                                            <td style="text-align: center;">
                                                <input type="checkbox" name="license_ids[]" value="{{ $license->id }}" class="license-checkbox" {{ $freeSeats == 0 ? 'disabled' : '' }}>
                                            </td>
                                            <td class="license-name">{{ $license->name }}</td>
                                            <td class="license-serial"><code>{{ $license->serial }}</code></td>
                                            <td style="text-align: center;">
                                                @if($freeSeats > 0)
                                                    <span class="label label-success">{{ $freeSeats }} / {{ $license->seats }}</span>
                                                @else
                                                    <span class="label label-danger">Habis</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                
                <div class="box-footer text-right">
                    <button type="submit" class="btn btn-primary" id="btnSubmit" style="margin-right: 80px;" disabled>
                        <i class="fa fa-key"></i> Lakukan Bulk Checkout
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('moar_scripts')
<script>
    $(document).ready(function() {
        // Check/Uncheck All (only visible/filtered checkboxes that are not disabled)
        $('#checkAll').change(function() {
            var checked = $(this).prop('checked');
            $('.license-row:visible').find('.license-checkbox:not(:disabled)').prop('checked', checked);
            updateSubmitButton();
        });

        // Individual checkbox change
        $(document).on('change', '.license-checkbox', function() {
            updateSubmitButton();
        });

        // Client side filtering
        $('#tableFilter').keyup(function() {
            var value = $(this).val().toLowerCase();
            $('#licenseTable tbody tr').filter(function() {
                var nameText = $(this).find('.license-name').text().toLowerCase();
                var serialText = $(this).find('.license-serial').text().toLowerCase();
                var match = nameText.indexOf(value) > -1 || serialText.indexOf(value) > -1;
                $(this).toggle(match);
            });
        });

        function updateSubmitButton() {
            var anyChecked = $('.license-checkbox:checked').length > 0;
            $('#btnSubmit').prop('disabled', !anyChecked);
        }
    });
</script>
@stop
