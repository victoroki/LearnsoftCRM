<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="orders-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity Ordered</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Client</th> <!-- Display Client -->
                    <th>Lead</th>   <!-- Display Lead -->
                    <th colspan="3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->product->product_name ?? 'N/A' }}</td> <!-- Product name -->
                        <td>{{ $order->quantity_ordered }}</td>
                        <td>{{ $order->unit_price }}</td>
                        <td>{{ $order->total_price }}</td>
                        <td>{{ $order->order_date }}</td>
                        <td>{{ $order->status }}</td>
                        <td>
                            @if($order->client)
                                {{ $order->client->first_name }} {{ $order->client->last_name }}
                            @else
                                N/A
                            @endif
                        </td> <!-- Client full name or N/A -->
                        <td>
                            @if($order->lead)
                                {{ $order->lead->full_name }}
                            @else
                                N/A
                            @endif
                        </td> <!-- Lead full name or N/A -->
                        <td style="width: 120px">
                            {!! Form::open(['route' => ['orders.destroy', $order->id], 'method' => 'delete']) !!}
                            <div class='btn-group'>
                                <a href="{{ route('orders.show', [$order->id]) }}"
                                   class='btn btn-default btn-xs'>
                                    <i class="far fa-eye"></i>
                                </a>
                                <a href="{{ route('orders.edit', [$order->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $orders])
        </div>
    </div>
</div>
