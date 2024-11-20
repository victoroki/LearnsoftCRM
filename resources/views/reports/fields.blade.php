<!-- Lead Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('lead_name', 'Lead Name:') !!}
    {!! Form::text('lead_name', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>

<!-- Client Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('client_name', 'Client Name:') !!}
    {!! Form::text('client_name', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>

<!-- Lead Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('lead_date', 'Lead Date:') !!}
    {!! Form::text('lead_date', null, ['class' => 'form-control','id'=>'lead_date']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#lead_date').datepicker()
    </script>
@endpush

<!-- Client Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('client_date', 'Client Date:') !!}
    {!! Form::text('client_date', null, ['class' => 'form-control','id'=>'client_date']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#client_date').datepicker()
    </script>
@endpush

<!-- Product Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('product_id', 'Product:') !!}
    {!! Form::number('product_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Quantity Ordered Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity_ordered', 'Quantity Ordered:') !!}
    {!! Form::number('quantity_ordered', null, ['class' => 'form-control']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#order_date').datepicker()
    </script>
@endpush

<!-- Start Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('start_date', 'Start Date:') !!}
    {!! Form::text('start_date', null, ['class' => 'form-control','id'=>'start_date']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#start_date').datepicker()
    </script>
@endpush

<!-- End Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('end_date', 'End Date:') !!}
    {!! Form::text('end_date', null, ['class' => 'form-control','id'=>'end_date']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#end_date').datepicker()
    </script>
@endpush