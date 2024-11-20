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
@endsection
