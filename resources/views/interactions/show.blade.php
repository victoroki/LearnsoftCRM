@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12 text-center">
                    <!-- Check if interactions are available, and then access the lead name -->
                    <h1>Interactions Details for {{ $interactions->first()->lead->full_name ?? 'Unknown Lead' }}</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('flash::message')

        <div class="clearfix"></div>

        <!-- Back Button -->
        <div class="mb-3">
            <a href="{{ route('interactions.index') }}" class="btn btn-secondary btn-sm">Back to Interactions</a>
        </div>

        <div class="card">
            <div class="card-body">
                <h4>Most Recent Interaction:</h4>
                <!-- Display the most recent interaction -->
                <p>{{ $currentInteraction->description ?? 'No interactions available.' }}</p>
                <p><strong>Type:</strong> {{ $currentInteraction->type }}</p>
                <p><strong>Date:</strong> {{ $currentInteraction->created_at->format('Y-m-d H:i:s') }}</p>

                <!-- Edit and Delete buttons for the current interaction -->
                <div class="mb-3">
                    <a href="{{ route('interactions.edit', $currentInteraction->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('interactions.destroy', $currentInteraction->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this interaction?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>

                <h4>All Interactions</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Interaction Type</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($interactions as $interaction)
                            <tr>
                                <td>{{ $interaction->type }}</td>
                                <td>{{ $interaction->description }}</td>
                                <td>
                                    <a href="{{ route('interactions.edit', $interaction->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('interactions.destroy', $interaction->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this interaction?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
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
