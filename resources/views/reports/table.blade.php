<div class="card-body p-0">
    <div class="table-responsive">
        <!-- Search Form -->
        <form method="GET" action="{{ route('reports.index') }}" class="mb-3">
        </form>

        <table class="table" id="reports-table">
            <thead>
                <tr>
                    <th>Employee Id</th>
                    <th>Employee Name</th>
                    <th>Lead Name</th>
                    <th>Client Name</th>
                    <th>Lead Date</th>
                    <th>Client Date</th>
                    <th>Product Id</th>
                    <th>Quantity Ordered</th>
                    <th>Order Date</th>
                    <th>Order Status</th>
                    <th>Interaction Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th colspan="3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $report)
                    <tr>
                        <td>{{ $report->employee_id }}</td>
                        <td>{{ $report->employee_name }}</td>
                        <td>{{ $report->lead_name }}</td>
                        <td>{{ $report->client_name }}</td>
                        <td>{{ $report->lead_date }}</td>
                        <td>{{ $report->client_date }}</td>
                        <td>{{ $report->product_id }}</td>
                        <td>{{ $report->quantity_ordered }}</td>
                        <td>{{ $report->order_date }}</td>
                        <td>{{ $report->order_status }}</td>
                        <td>{{ $report->interaction_type }}</td>
                        <td>{{ $report->start_date }}</td>
                        <td>{{ $report->end_date }}</td>
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
