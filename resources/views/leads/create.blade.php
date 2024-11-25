@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Create Lead</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <form method="POST" action="{{ route('leads.store') }}">
                @csrf

                <!-- Full Name Field -->
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" name="full_name" id="full_name" class="form-control" value="{{ old('full_name') }}" required>
                </div>

                <!-- Email Field -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                
                <!-- Source Field -->
                <div class="form-group">
                    <label for="source">Source</label>
                    <input type="text" placeholder="Call/Email/Referral" name="source" id="source" class="form-control" value="{{ old('source') }}">
                </div>

                <!-- Phone Number Field -->
                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ old('phone_number') }}" required>
                </div>

                <!-- Description Field -->
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                </div>

                <!-- Product Dropdown -->
                <select name="product_id" id="product_id" class="form-control" required>
                    <option value="">Select a Product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->product_name }}
                        </option>
                    @endforeach
                </select>
                

                <!-- Quantity Field -->
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" min="1" value="{{ old('quantity', 1) }}" required>
                </div>

                <!-- Lead Date Field -->
                <div class="form-group">
                    <label for="lead_date">Lead Date</label>
                    <input type="text" name="lead_date" id="lead_date" class="form-control" value="{{ old('lead_date') }}" required>
                </div>

                <!-- Employee Dropdown -->
                <div class="form-group">
                    <label for="employee_id">Employee</label>
                    <select name="employee_id" id="employee_id" class="form-control">
                        <option value="">Select an Employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">
                                {{ $employee->first_name }} {{ $employee->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Save Lead</button>
                <a href="{{ route('leads.index') }}" class="btn btn-default"> Cancel </a>
            </form>
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
