<!-- Client Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('client_id', 'Client Id:') !!}
    {!! Form::select('client_id', \App\Models\Client::pluck('first_name', 'id'), null, ['class' => 'form-control']) !!}
</div>

<!-- Lead Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('lead_id', 'Lead Id:') !!}
    {!! Form::select('lead_id', \App\Models\Lead::pluck('full_name', 'id'), null, ['class' => 'form-control']) !!}
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
    {!! Form::text('interactions_date', null, ['class' => 'form-control','id'=>'interactions_date']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#interactions_date').datepicker()
    </script>
@endpush