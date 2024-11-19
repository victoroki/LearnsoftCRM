@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12 text-center">
                    <h1>Interactions</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <form action="{{ route('interactions.index') }}" method="GET" class="form-inline">
                        <input type="text" name="search" class="form-control mr-2" placeholder="Search Interactions" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Lead Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($interactions as $interaction)
                            <tr>
                                <!-- Display Lead Name -->
                                <td>{{ $interaction->lead->full_name }}</td>

                                <td>
                                    <!-- View button (to view all interactions for a specific lead) -->
                                    <a href="{{ route('interactions.show', $interaction->lead->id) }}" class="btn btn-info btn-sm">View Interactions</a>
                                    
                                    <!-- Add button (to add a new interaction for the specific lead) -->
                                    <a href="{{ route('interactions.create', ['lead_id' => $interaction->lead->id]) }}" class="btn btn-success btn-sm">Add Interaction</a>
                                    
                                    {{-- <!-- Delete button (to delete a specific interaction) -->
                                    <form action="{{ route('interactions.destroy', $interaction->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this interaction?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form> --}}
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination links -->
                {{ $interactions->links() }}
            </div>
        </div>
    </div>
@endsection
