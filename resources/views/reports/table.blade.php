<table class="table table-bordered">
    <thead>
        <tr>
            <th>Employee</th>
            <th>Created Date</th> <!-- Updated column name -->
        </tr>
    </thead>
    <tbody>
        @forelse($employees as $employee)
            <tr>
                <td>{{ $employee->full_name }}</td> <!-- Employee's name -->
                <td>{{ $employee->created_at->format('Y-m-d') }}</td> <!-- Formatted creation date -->
            </tr>
        @empty
            <tr>
                <td colspan="2">No employees found.</td> <!-- Adjusted colspan to match the number of columns -->
            </tr>
        @endforelse
    </tbody>
</table>
