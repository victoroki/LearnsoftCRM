@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Leads</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right" href="{{ route('leads.create') }}">Add New</a>
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
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Source</th>
                                <th>Status</th>
                                <th>Employee</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leads as $lead)
                                <tr>
                                    <td>{{ $lead->full_name ?? 'No Lead' }}</td>
                                    <td>{{ $lead->email ?? 'No Email' }}</td>
                                    <td>{{ $lead->phone_number ?? 'No Phone' }}</td>
                                    <td>{{ $lead->source ?? 'No Source' }}</td>
                                    <td>{{ $lead->status ?? 'No Status' }}</td>
                                    <td>{{ $lead->employee->first_name ?? 'No Employee' }} {{ $lead->employee->last_name ?? '' }}</td>
                                    <td>{{ $lead->description ?? 'No Description' }}</td>
                                    <td style="width: 120px">
    {!! Form::open(['route' => ['leads.destroy', $lead->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
    <div class='btn-group'>
        <a href="{{ route('leads.show', [$lead->id]) }}" class='btn btn-default btn-xs'>
            <i class="far fa-eye"></i>
        </a>
        <a href="{{ route('leads.edit', [$lead->id]) }}" class='btn btn-default btn-xs'>
            <i class="far fa-edit"></i>
        </a>

        <!-- Convert to Client Button -->
        {{-- <a href="{{ route('leads.convertToClient', $lead->id) }}" class="btn btn-success btn-xs">
            Convert to Client
        </a> --}}
        

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
