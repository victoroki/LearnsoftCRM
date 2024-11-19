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

<a href="{{ route('interactions.create', ['lead_id' => $lead->id]) }}" class="btn btn-primary">Create Interaction for Lead</a>
<a href="{{ route('interactions.create', ['client_id' => $client->id]) }}" class="btn btn-primary">Create Interaction for Client</a>