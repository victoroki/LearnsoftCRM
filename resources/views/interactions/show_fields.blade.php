<!-- Client Id Field -->
<div class="col-sm-12">
    {!! Form::label('client_id', 'Client Id:') !!}
    <p>{{ $interaction->client_id }}</p>
</div>

<!-- Lead Id Field -->
<div class="col-sm-12">
    {!! Form::label('lead_id', 'Lead Id:') !!}
    <p>{{ $interaction->lead_id }}</p>
</div>

<!-- Type Field -->
<div class="col-sm-12">
    {!! Form::label('type', 'Type:') !!}
    <p>{{ $interaction->type }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $interaction->description }}</p>
</div>

<!-- Interactions Date Field -->
<div class="col-sm-12">
    {!! Form::label('interactions_date', 'Interactions Date:') !!}
    <p>{{ $interaction->interactions_date }}</p>
</div>

