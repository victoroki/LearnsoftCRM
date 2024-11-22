<!-- Order Id Field -->
<div class="col-sm-12">
    {!! Form::label('order_ref_number', 'Order Ref Number:') !!}
    <p>{{ $transaction->order_id }}</p>
</div>

<!-- Amount Paid Field -->
<div class="col-sm-12">
    {!! Form::label('amount_paid', 'Amount Paid:') !!}
    <p>{{ $transaction->amount_paid }}</p>
</div>

<!-- Payment Date Field -->
<div class="col-sm-12">
    {!! Form::label('payment_date', 'Payment Date:') !!}
    <p>{{ $transaction->payment_date }}</p>
</div>

<!-- Payment Method Field -->
<div class="col-sm-12">
    {!! Form::label('payment_method', 'Payment Method:') !!}
    <p>{{ $transaction->payment_method }}</p>
</div>

<!-- Transaction Reference Field -->
<div class="col-sm-12">
    {!! Form::label('transaction_reference', 'Transaction Reference:') !!}
    <p>{{ $transaction->transaction_reference }}</p>
</div>

<!-- Client Id Field -->
<div class="col-sm-12">
    {!! Form::label('client_id', 'Client Id:') !!}
    <p>{{ $transaction->client_id }}</p>
</div>

