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

                <!-- Employee ID (hidden) -->
                {!! Form::hidden('employee_id', $employee->id) !!}

                <!-- Dynamically display the form for the current day -->
                @php
                    $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
                    $currentDay = $days[$dayIndex] ?? 'monday'; // Default to Monday if dayIndex is not provided
                @endphp

                <div class="form-group">
                    {!! Form::label("{$currentDay}_report", ucfirst($currentDay) . " Report:") !!}
                    {!! Form::textarea("{$currentDay}_report", null, ['class' => 'form-control']) !!}
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save Report', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('employees.index') }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
