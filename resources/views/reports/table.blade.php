@if($data->isEmpty())
    <p>No records found for the selected criteria.</p>
@else
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                {{-- Display column names dynamically --}}
                @foreach ($columns as $column)
                    <th>{{ ucfirst(str_replace('_', ' ', $column)) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            {{-- Loop through the data to render each row --}}
            @foreach ($data as $row)
                <tr>
                    @foreach ($columns as $column)
                        <td>
                            {{-- Check if column is a date field for formatting --}}
                            @if (in_array($column, ['created_at', 'order_date']))
                                {{ \Carbon\Carbon::parse($row[$column])->format('d-m-Y') }}
                            {{-- Display related data for dynamically added fields like product_name, client_name, etc. --}}
                            @elseif (isset($row[$column]))
                                {{ $row[$column] }}
                            {{-- Display N/A for undefined or null values --}}
                            @else
                                N/A
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
