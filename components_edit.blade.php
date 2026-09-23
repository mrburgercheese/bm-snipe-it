@extends('layouts/edit-form', [
    'createText' => trans('admin/components/general.create') ,
    'updateText' => trans('admin/components/general.update'),
    'helpPosition'  => 'right',
    'helpText' => trans('help.components'),
    'formAction' => (isset($item->id)) ? route('components.update', ['component' => $item->id]) : route('components.store'),
    'index_route' => 'components.index',
    'options' => [
                'back' => trans('admin/hardware/form.redirect_to_type',['type' => trans('general.previous_page')]),
                'index' => trans('admin/hardware/form.redirect_to_all', ['type' => 'components']),
                'item' => trans('admin/hardware/form.redirect_to_type', ['type' => trans('general.component')]),
               ]

])

{{-- Page content --}}
@section('inputFields')

@include ('partials.forms.edit.name', ['translated_name' => trans('admin/components/table.title')])
@include ('partials.forms.edit.category-select', ['translated_name' => trans('general.category'), 'fieldname' => 'category_id','category_type' => 'component'])
@include ('partials.forms.edit.quantity')
@include ('partials.forms.edit.minimum_quantity')
@include ('partials.forms.edit.serial', ['fieldname' => 'serial'])
@include ('partials.forms.edit.manufacturer-select', ['translated_name' => trans('general.manufacturer'), 'fieldname' => 'manufacturer_id'])
@include ('partials.forms.edit.model_number')
@include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'company_id'])
@include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'location_id'])
@include ('partials.forms.edit.supplier-select', ['translated_name' => trans('general.supplier'), 'fieldname' => 'supplier_id'])
@include ('partials.forms.edit.order_number')
@include ('partials.forms.edit.datepicker', ['translated_name' => trans('general.purchase_date'),'fieldname' => 'purchase_date'])
@include ('partials.forms.edit.purchase_cost', ['unit_cost' => trans('general.unit_cost')])
@include ('partials.forms.edit.notes')
@include ('partials.forms.edit.image-upload', ['image_path' => app('components_upload_path')])


@stop


@if (!isset($item->id))
@section('moar_scripts')
<script nonce="{{ csrf_token() }}">
$(document).ready(function() {
    // Add Auto-Generate Code COM button next to Component Name and Serial fields
    var genBtnHtml = '<button type="button" id="btn-generate-com-code" class="btn btn-sm btn-success" style="margin-top: 6px; font-weight: 600;"><i class="fa fa-magic"></i> Auto Generate Kode COM (COM-YYMMDDXXX)</button>';
    
    $('#name').after(genBtnHtml);
    $('#serial').after('<button type="button" class="btn-copy-com-serial btn btn-sm btn-primary" style="margin-top: 6px; font-weight: 600;"><i class="fa fa-magic"></i> Generate Kode COM di Serial</button>');

    function fetchAndSetComCode(targetField) {
        $.ajax({
            url: "{{ route('custom.components.generate_code') }}",
            type: "GET",
            success: function(res) {
                if (res && res.code) {
                    if (targetField === 'all') {
                        if (!$('#serial').val()) {
                            $('#serial').val(res.code);
                        }
                        if (!$('#name').val() || $('#name').val() === 'COM' || $('#name').val().startsWith('COM-')) {
                            $('#name').val(res.code);
                        }
                    } else if (targetField === 'serial') {
                        $('#serial').val(res.code);
                    } else if (targetField === 'name') {
                        $('#name').val(res.code);
                    }
                }
            }
        });
    }

    // Auto-fetch on page load for Create New Component page
    fetchAndSetComCode('all');

    // Button click handlers
    $(document).on('click', '#btn-generate-com-code', function(e) {
        e.preventDefault();
        fetchAndSetComCode('all');
    });

    $(document).on('click', '.btn-copy-com-serial', function(e) {
        e.preventDefault();
        fetchAndSetComCode('serial');
    });
});
</script>
@stop
@endif
