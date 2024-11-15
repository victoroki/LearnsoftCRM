@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <form action="{{ route('employees.index') }}" method="GET" class="form-inline">
            <div class="form-group mr-2">
                <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Department</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($employees as $employee)
                        <tr>
                            <td>{{ $employee->first_name }}</td>
                            <td>{{ $employee->last_name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->phone_number }}</td>
                            <td>{{ $employee->department->dept_name ?? 'No Department' }}</td>
                            <td>
                                <div class='btn-group'>
                                    <a href="{{ route('employees.show', $employee->id) }}" class='btn btn-default btn-xs'>
                                        <i class="far fa-eye"></i>
                                    </a>
                                    <a href="{{ route('employees.edit', $employee->id) }}" class='btn btn-default btn-xs'>
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure?')">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No employees found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer clearfix">
        {{ $employees->links() }}
    </div>
</div>
@endsection
