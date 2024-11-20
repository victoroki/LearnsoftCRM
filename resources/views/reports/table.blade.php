<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="reports-table">
            <thead>
                <tr>
                    <th class="filterable lead-column">Lead Name</th>
                    <th class="filterable client-column">Client Name</th>
                    <th class="filterable lead-column">Lead Date</th>
                    <th class="filterable client-column">Client Date</th>
                    <th class="filterable lead-column client-column">Product</th>
                    <th class="filterable client-column">Quantity Ordered</th>
                    <th class="filterable lead-column client-column shared-column">Start Date</th>
                    <th class="filterable lead-column client-column shared-column">End Date</th>
                    <th>Actions</th> <!-- Always visible -->
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $report)
                    <tr>
                        <td class="filterable lead-column">{{ $report->lead_name }}</td>
                        <td class="filterable client-column">{{ $report->client_name }}</td>
                        <td class="filterable lead-column">{{ $report->lead_date }}</td>
                        <td class="filterable client-column">{{ $report->client_date }}</td>
                        <td class="filterable lead-column client-column">{{ $report->product_id }}</td>
                        <td class="filterable client-column">{{ $report->quantity_ordered }}</td>
                        <td class="filterable lead-column client-column shared-column">{{ $report->start_date }}</td>
                        <td class="filterable lead-column client-column shared-column">{{ $report->end_date }}</td>
                        <td style="width: 120px">
                            {!! Form::open(['route' => ['reports.destroy', $report->id], 'method' => 'delete']) !!}
                            <div class="btn-group">
                                <a href="{{ route('reports.show', [$report->id]) }}" class="btn btn-default btn-xs">
                                    <i class="far fa-eye"></i>
                                </a>
                                <a href="{{ route('reports.edit', [$report->id]) }}" class="btn btn-default btn-xs">
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

    <div class="card-footer clearfix">
        <!-- Pagination links -->
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $reports])
        </div>
    </div>
</div>
