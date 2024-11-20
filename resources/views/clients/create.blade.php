@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Create Client</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('adminlte-templates::common.errors')

        <div class="card">
            {!! Form::open(['route' => 'clients.store']) !!}

            <div class="card-body">

                <!-- Lead Field: Dropdown -->
                <!-- <div class="form-group">
                    {!! Form::label('lead_id', 'Lead Full Name:') !!}
                    <select name="lead_id" id="lead_id" class="form-control">
                        <option value="">Select a Lead</option>
                        @foreach ($leads as $lead)
                            <option value="{{ $lead->id }}">
                                {{ $lead->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div> -->

                <!-- Full Name Field: Input -->
                <div class="form-group">
                    {!! Form::label('full_name', 'Full Name:') !!}
                    {!! Form::text('full_name', null, ['class' => 'form-control']) !!}
                </div>

                <!-- Company Name Field: Input -->
                <div class="form-group">
                    {!! Form::label('company_name', 'Company Name:') !!}
                    {!! Form::text('company_name', null, ['class' => 'form-control']) !!}
                </div>

                <!-- Email Address Field: Input -->
                <div class="form-group">
                    {!! Form::label('email_address', 'Email Address:') !!}
                    {!! Form::email('email_address', null, ['class' => 'form-control']) !!}
                </div>

                <!-- Phone Number Field: Input -->
                <div class="form-group">
                    {!! Form::label('phone_number', 'Phone Number:') !!}
                    {!! Form::text('phone_number', null, ['class' => 'form-control']) !!}
                </div>

                <!-- Location Field: Input -->
                <div class="form-group">
                    {!! Form::label('location', 'Location:') !!}
                    {!! Form::text('location', null, ['class' => 'form-control']) !!}
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('clients.index') }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection