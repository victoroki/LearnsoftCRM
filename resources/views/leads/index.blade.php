@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <!-- Title Centered -->
                <div class="col text-center">
                    <h1>Leads</h1>
                </div>
            </div>
            <div class="row align-items-center">
                <!-- Search Box Left -->
                <div class="col-md-6">
                    <form action="{{ route('leads.index') }}" method="GET" class="form-inline">
                        <input type="text" name="search" class="form-control mr-2" placeholder="Search Leads" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                </div>
                <!-- Add New Button Right -->
                <div class="col-md-6 text-right">
                    <a class="btn btn-primary" href="{{ route('leads.create') }}">Add New</a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">

                <table class="table">
    <thead>
        <tr>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Status</th>
            <th>Product</th> <!-- Ensure Product column is here -->
            <th>Employee</th> <!-- Add Employee column -->
            <th>Source</th> <!-- Add Source column -->
            <th>Description</th> <!-- Add Description column -->
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($leads as $lead)
            <tr>
                <td>{{ $lead->full_name ?? 'No Lead' }}</td>
                <td>{{ $lead->email ?? 'No Email' }}</td>
                <td>{{ $lead->phone_number ?? 'No Phone' }}</td>
                <td>{{ $lead->status ?? 'No Status' }}</td>
                <td>{{ $lead->product->product_name ?? 'N/A' }}</td> <!-- Display selected product -->
                <td>{{ $lead->employee->first_name ?? 'No Employee' }} {{ $lead->employee->last_name ?? '' }}</td> <!-- Display employee's name -->
                <td>{{ $lead->source ?? 'No Source' }}</td> <!-- Display source -->
                <td>{{ $lead->description ?? 'No description' }}</td>
                <td style="width: 120px">
                    {!! Form::open(['route' => ['leads.destroy', $lead->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('leads.show', [$lead->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('leads.edit', [$lead->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>


                </div>
            </div>

            <div class="card-footer clearfix">
                <div class="float-right">
                    @include('adminlte-templates::common.paginate', ['records' => $leads])
                </div>
            </div>
        </div>
    </div>
@endsection