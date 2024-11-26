@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Daily Report for Employee</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'daily_reports.store']) !!}

            <div class="card-body">

                <div class="form-group">
                    {!! Form::label('monday_report', 'Monday Report:') !!}
                    {!! Form::textarea('monday_report', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('tuesday_report', 'Tuesday Report:') !!}
                    {!! Form::textarea('tuesday_report', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('wednesday_report', 'Wednesday Report:') !!}
                    {!! Form::textarea('wednesday_report', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('thursday_report', 'Thursday Report:') !!}
                    {!! Form::textarea('thursday_report', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('friday_report', 'Friday Report:') !!}
                    {!! Form::textarea('friday_report', null, ['class' => 'form-control']) !!}
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save Report', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('employees.index') }}" class="btn btn-default"> Cancel </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
