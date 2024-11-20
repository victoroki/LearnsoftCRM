<!-- Employee Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('employee_id', 'Employee Id:') !!}
    {!! Form::number('employee_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Employee Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('employee_name', 'Employee Name:') !!}
    {!! Form::text('employee_name', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>

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
    {!! Form::label('product_id', 'Product Id:') !!}
    {!! Form::number('product_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Quantity Ordered Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity_ordered', 'Quantity Ordered:') !!}
    {!! Form::number('quantity_ordered', null, ['class' => 'form-control']) !!}
</div>

<!-- Order Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('order_date', 'Order Date:') !!}
    {!! Form::text('order_date', null, ['class' => 'form-control','id'=>'order_date']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#order_date').datepicker()
    </script>
@endpush

<!-- Order Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('order_status', 'Order Status:') !!}
    {!! Form::text('order_status', null, ['class' => 'form-control', 'maxlength' => 50, 'maxlength' => 50]) !!}
</div>

<!-- Interaction Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('interaction_type', 'Interaction Type:') !!}
    {!! Form::text('interaction_type', null, ['class' => 'form-control', 'required', 'maxlength' => 250, 'maxlength' => 250]) !!}
</div>

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