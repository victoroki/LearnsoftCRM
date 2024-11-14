<!-- Client Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('client_first_name', 'Client Full Name:') !!}
    {!! Form::text('client_first_name', null, ['class' => 'form-control', 'maxlength' => 255, 'placeholder' => 'Enter client name']) !!}
</div>

<!-- Lead Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('lead_full_name', 'Lead Full Name:') !!}
    {!! Form::text('lead_full_name', null, ['class' => 'form-control', 'maxlength' => 255, 'placeholder' => 'Enter lead name']) !!}
</div>

<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type', 'Type:') !!}
    {!! Form::text('type', null, ['class' => 'form-control', 'maxlength' => 30, 'maxlength' => 30]) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'maxlength' => 65535, 'maxlength' => 65535]) !!}
</div>

<!-- Interactions Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('interactions_date', 'Interactions Date:') !!}
    {!! Form::date('interactions_date', null, ['class' => 'form-control','id'=>'interactions_date']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#interactions_date').datepicker()
    </script>
@endpush