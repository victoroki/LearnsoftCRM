<!-- Product Id Field -->
<div class="col-sm-12">
    {!! Form::label('product_id', 'Product Id:') !!}
    <p>{{ $order->product_id }}</p>
</div>

<!-- Quantity Ordered Field -->
<div class="col-sm-12">
    {!! Form::label('quantity_ordered', 'Quantity Ordered:') !!}
    <p>{{ $order->quantity_ordered }}</p>
</div>

<!-- Unit Price Field -->
<div class="col-sm-12">
    {!! Form::label('unit_price', 'Unit Price:') !!}
    <p>{{ $order->unit_price }}</p>
</div>

<!-- Total Price Field -->
<div class="col-sm-12">
    {!! Form::label('total_price', 'Total Price:') !!}
    <p>{{ $order->total_price }}</p>
</div>

<!-- Order Date Field -->
<div class="col-sm-12">
    {!! Form::label('order_date', 'Order Date:') !!}
    <p>{{ $order->order_date }}</p>
</div>

<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $order->status }}</p>
</div>

<!-- Client or Lead Name Field -->
<div class="col-sm-12">
    {!! Form::label('client_or_lead_name', 'Client or Lead Name:') !!}
    <p>
        @if($order->client_id)
            {{ $order->client ? $order->client->first_name : 'Client not found' }}
        @elseif($order->lead_id)
            {{ $order->lead ? $order->lead->full_name : 'Lead not found' }}
        @else
            No client or lead assigned
        @endif
    </p>
</div>
