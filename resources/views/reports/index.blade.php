@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 justify-content-center">
                <!-- Centered Heading -->
                <div class="col-sm-12 text-center">
                    <h1>Reports</h1>
                </div>
            </div>
            <div class="row mb-2">
                <!-- Search Box to the left -->
                <div class="col-sm-6">
                    <form method="GET" action="{{ route('reports.index') }}" class="form-inline mb-3">
                        <!-- Search Input -->
                        <input type="text" name="search" class="form-control mr-2" placeholder="Search reports" value="{{ request()->get('search') }}">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </form>
                </div>

                <!-- Add New Button to the right -->
                <div class="col-sm-6 text-right">
                    <a class="btn btn-primary" href="{{ route('reports.create') }}">
                        Add New
                    </a>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="container-fluid">
            <div class="row">
                <!-- Employee Dropdown -->
                <div class="col-sm-3">
                    <label for="employee_id">Employee</label>
                    <select name="employee_id" id="employee_id" class="form-control">
                        <option value="">Select an Employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">
                                {{ $employee->first_name }} {{ $employee->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Start Date Field -->
                <div class="col-sm-3">
                    <label for="start_date">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request()->get('start_date') }}">
                </div>

                <!-- End Date Field -->
                <div class="col-sm-3">
                    <label for="end_date">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request()->get('end_date') }}">
                </div>

                <!-- Type Dropdown -->
                <div class="col-sm-3">
                    <label for="interaction_type">Type</label>
                    <select name="interaction_type" id="interaction_type" class="form-control">
                        <option value="">All</option>
                        <option value="Lead" {{ request()->get('interaction_type') == 'Lead' ? 'selected' : '' }}>Lead</option>
                        <option value="Client" {{ request()->get('interaction_type') == 'Client' ? 'selected' : '' }}>Client</option>
                    </select>
                </div>
            </div>

            <!-- Filter Button -->
            <div class="row mt-3">
                <div class="col-sm-12 text-center">
                    <button type="submit" class="btn btn-success">Filter</button>
                </div>
            </div>
        </div>
    </section>


    <div class="content px-3">
        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            @include('reports.table') <!-- Include your table partial for the reports list -->
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {!! $reports->links() !!}
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterButton = document.querySelector('button[type="submit"]');
        const typeDropdown = document.querySelector('#interaction_type');

        function filterColumns() {
            const type = typeDropdown.value;
            const allColumns = document.querySelectorAll('.filterable');

            // Hide all columns by default
            allColumns.forEach(column => column.style.display = 'none');

            if (type === 'Lead') {
                document.querySelectorAll('.lead-column').forEach(column => column.style.display = '');
            } else if (type === 'Client') {
                document.querySelectorAll('.client-column').forEach(column => column.style.display = '');
            } else {
                document.querySelectorAll('.all-column').forEach(column => column.style.display = '');
            }
        }

        // Initial filtering on page load
        filterColumns();

        // Re-filter columns on dropdown change
        typeDropdown.addEventListener('change', filterColumns);
    });
</script>

@endsection


