<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="leads-table">
            <thead>
            <tr>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Source</th>
                <th>Status</th>
                <th>Employee</th>
                <th>Notes</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($leads as $lead)
                <tr>
                    <td>{{ $lead->full_name }}</td>
                    <td>{{ $lead->email }}</td>
                    <td>{{ $lead->phone_number }}</td>
                    <td>{{ $lead->source }}</td>
                    <td>{{ $lead->status }}</td>
                    <td>{{ $lead->employee_id }}</td>
                    <td>{{ $lead->notes }}</td>
                    <td  style="width: 120px">
                        {!! Form::open(['route' => ['leads.destroy', $lead->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('leads.show', [$lead->id]) }}"
                               class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('leads.edit', [$lead->id]) }}"
                               class='btn btn-default btn-xs'>
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
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $leads])
        </div>
    </div>
</div>
