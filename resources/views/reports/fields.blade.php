<!-- Lead Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('lead_id', 'Lead Name:') !!}
    {!! Form::select('lead_id', $leads->pluck('full_name', 'id'), null, ['class' => 'form-control']) !!}
</div>

<!-- Client Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('client_id', 'Client Name:') !!}
    {!! Form::select('client_id', $clients->pluck('full_name', 'id'), null, ['class' => 'form-control']) !!}
</div>

<!-- Lead Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('lead_date', 'Lead Date:') !!}
    {!! Form::text('lead_date', null, ['class' => 'form-control', 'id'=>'lead_date']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#lead_date').datepicker()
    </script>
@endpush

<!-- Client Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('client_date', 'Client Date:') !!}
    {!! Form::text('client_date', null, ['class' => 'form-control', 'id'=>'client_date']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#client_date').datepicker()
    </script>
@endpush

<!-- Product Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('product_id', 'Product:') !!}
    {!! Form::select('product_id', $products, null, ['class' => 'form-control']) !!}
</div>

<!-- Quantity Ordered Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity_ordered', 'Quantity Ordered:') !!}
    {!! Form::number('quantity_ordered', null, ['class' => 'form-control']) !!}
</div>
