<!-- Product Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('product_id', 'Product:') !!}
    {!! Form::select('product_id', $products, null, ['class' => 'form-control', 'id' => 'product_id', 'required']) !!}
</div>

<!-- Quantity Ordered Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity_ordered', 'Quantity Ordered:') !!}
    {!! Form::number('quantity_ordered', null, ['class' => 'form-control', 'id' => 'quantity_ordered', 'required']) !!}
</div>

<!-- Unit Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('unit_price', 'Unit Price:') !!}
    {!! Form::number('unit_price', null, ['class' => 'form-control', 'id' => 'unit_price', 'readonly']) !!}
</div>

<!-- Total Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('total_price', 'Total Price:') !!}
    {!! Form::number('total_price', null, ['class' => 'form-control', 'id' => 'total_price', 'readonly']) !!}
</div>

<!-- Order Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('order_date', 'Order Date:') !!}
    {!! Form::date('order_date', null, ['class' => 'form-control', 'id' => 'order_date']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            const productDropdown = document.getElementById('product_id');
            const quantityInput = document.getElementById('quantity_ordered');
            const unitPriceField = document.getElementById('unit_price');
            const totalPriceField = document.getElementById('total_price');

            let unitPrice = 0;

            productDropdown.addEventListener('change', fetchProductPrice);
            quantityInput.addEventListener('input', calculateTotalPrice);

            async function fetchProductPrice() {
                const productId = productDropdown.value;
                if (productId) {
                    const response = await fetch(`/get-product-price/${productId}`);
                    const data = await response.json();
                    if (data.price) {
                        unitPrice = data.price;
                        unitPriceField.value = unitPrice.toFixed(2);
                        calculateTotalPrice();
                    }
                }
            }

            function calculateTotalPrice() {
                const quantity = parseInt(quantityInput.value) || 0;
                const totalPrice = unitPrice * quantity;
                totalPriceField.value = totalPrice.toFixed(2);
            }

            if (productDropdown.value) {
                fetchProductPrice();
            }
        });
    </script>
@endpush

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::text('status', null, ['class' => 'form-control', 'maxlength' => 20]) !!}
</div>

<!-- Client Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('client_id', 'Client:') !!}
    {!! Form::select('client_id', $clients, null, ['class' => 'form-control']) !!}
</div>

<!-- Lead Field -->
<div class="form-group col-sm-6">
    {!! Form::label('lead_id', 'Lead:') !!}
    {!! Form::select('lead_id', $leads, null, ['class' => 'form-control']) !!}
</div>
