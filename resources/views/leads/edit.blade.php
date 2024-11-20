@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Lead</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-right" href="{{ route('leads.index') }}">Back</a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('adminlte-templates::common.errors')

        <div class="card">
            {!! Form::model($lead, ['route' => ['leads.update', $lead->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    <!-- Full Name Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('full_name', 'Full Name:') !!}
                        {!! Form::text('full_name', null, ['class' => 'form-control', 'maxlength' => 100]) !!}
                    </div>

                    <!-- Email Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('email', 'Email:') !!}
                        {!! Form::email('email', null, ['class' => 'form-control', 'required', 'maxlength' => 30]) !!}
                    </div>

                    <!-- Phone Number Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('phone_number', 'Phone Number:') !!}
                        {!! Form::number('phone_number', null, ['class' => 'form-control']) !!}
                    </div>

                    <!-- Source Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('source', 'Source:') !!}
                        {!! Form::text('source', null, ['class' => 'form-control', 'maxlength' => 30]) !!}
                    </div>

                    <!-- Product Dropdown Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('product_id', 'Product:') !!}
                        {!! Form::select('product_id', ['' => 'N/A'] + $products->pluck('product_name', 'id')->toArray(), null, ['class' => 'form-control']) !!}
                    </div>


                    <!-- Employee Dropdown Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('employee_id', 'Employee:') !!}
                        {!! Form::select('employee_id', $employees->pluck('first_name', 'id'), null, ['class' => 'form-control']) !!}
                    </div>

                    <!-- Description Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::label('description', 'Description:') !!}
                        {!! Form::textarea('description', null, ['class' => 'form-control', 'maxlength' => 65535]) !!}
                    </div>
                </div>
            </div>
            <!-- Lead Date Field -->
            <div class="form-group">
                <label for="lead_date">Lead Date</label>
                <input type="text" name="lead_date" id="lead_date" class="form-control" value="{{ old('lead_date', $lead->lead_date) }}" required>
            </div>

<!-- Product Dropdown -->
<div class="form-group">
    <label for="product_id">Product</label>
    <select name="product_id" id="product_id" class="form-control">
        <option value="">Select a Product (Optional)</option>
        @foreach($products as $product)
            <option value="{{ $product->id }}" 
                {{ old('product_id', $lead->product_id) == $product->id ? 'selected' : '' }}>
                {{ $product->product_name }}
            </option>
        @endforeach
    </select>
</div>


            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('leads.index') }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}
        </div>
    </div>

@endsection

@push('page_scripts')
    <!-- Include jQuery UI Datepicker -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#lead_date').datepicker({
                dateFormat: 'yy-mm-dd'  // Set format as per your requirements
            });
        });
    </script>
@endpush