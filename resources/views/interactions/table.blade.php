<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="interactions-table">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Interactions Date</th>
                    <th colspan="3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($interactions as $interaction)
                    <tr>
                        <td>{{ $interaction->client ? $interaction->client->first_name . ' ' . $interaction->client->last_name : 'No client' }}</td>
                        <td>{{ $interaction->lead ? $interaction->lead->full_name : 'No lead' }}</td>
                        <td>{{ $interaction->type }}</td>
                        <td>{{ $interaction->description }}</td>
                        <td>{{ $interaction->interactions_date }}</td>
                        <td style="width: 120px">
                            {!! Form::open(['route' => ['interactions.destroy', $interaction->id], 'method' => 'delete']) !!}
                            <div class='btn-group'>
                                <a href="{{ route('interactions.show', [$interaction->id]) }}" class='btn btn-default btn-xs'>
                                    <i class="far fa-eye"></i>
                                </a>
                                <a href="{{ route('interactions.edit', [$interaction->id]) }}" class='btn btn-default btn-xs'>
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
            @include('adminlte-templates::common.paginate', ['records' => $interactions])
        </div>
    </div>
</div>
