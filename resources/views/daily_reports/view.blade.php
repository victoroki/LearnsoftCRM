@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Daily Report for {{ $employee->name }}</h1>
                    <p>{{ ucfirst($currentDay) }} Report</p>
                    <p><strong>Date:</strong> {{ $report->report_date->format('Y-m-d') }}</p> <!-- Now it works -->
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="report_content">Report:</label>
                    <textarea class="form-control" id="report_content" rows="5" readonly>{{ $report->{$currentDay . '_report'} }}</textarea>
                </div>
            </div>

            <div class="card-footer">
                <a href="{{ route('employees.index') }}" class="btn btn-default">Back to Employees</a>
            </div>
        </div>
    </div>
@endsection
