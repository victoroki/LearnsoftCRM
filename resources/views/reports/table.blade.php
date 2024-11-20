<table class="table table-bordered">
    <thead>
        <tr>
            <th>Client</th>
            <th>Lead</th>
            <th>Interaction Type</th>
            <th>Interaction Date</th>
        </tr>
    </thead>
    <tbody>
        @forelse($interactions as $interaction)
            <tr>
                <td>{{ $interaction->client->full_name ?? 'N/A' }}</td>
                <td>{{ $interaction->lead->full_name ?? 'N/A' }}</td>
                <td>{{ $interaction->type }}</td>
                <td>{{ $interaction->created_at->format('d-m-Y') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No interactions found for {{ $employee->full_name }} in the selected date range.</td>
            </tr>
        @endforelse
    </tbody>
</table>
