<!-- First Name Field -->
<div class="col-sm-12">
    {!! Form::label('first_name', 'First Name:') !!}
    <p>{{ $client->first_name }}</p>
</div>

<!-- Last Name Field -->
<div class="col-sm-12">
    {!! Form::label('last_name', 'Last Name:') !!}
    <p>{{ $client->last_name }}</p>
</div>

<!-- Company Name Field -->
<div class="col-sm-12">
    {!! Form::label('company_name', 'Company Name:') !!}
    <p>{{ $client->company_name }}</p>
</div>

<!-- Email Address Field -->
<div class="col-sm-12">
    {!! Form::label('email_address', 'Email Address:') !!}
    <p>{{ $client->email_address }}</p>
</div>

<!-- Phone Number Field -->
<div class="col-sm-12">
    {!! Form::label('phone_number', 'Phone Number:') !!}
    <p>{{ $client->phone_number }}</p>
</div>

<!-- Lead Id Field -->
<div class="col-sm-12">
    {!! Form::label('lead_id', 'Lead Id:') !!}
    <p>{{ $client->lead_id }}</p>
</div>

<!-- Location Field -->
<div class="col-sm-12">
    {!! Form::label('location', 'Location:') !!}
    <p>{{ $client->location }}</p>
</div>

