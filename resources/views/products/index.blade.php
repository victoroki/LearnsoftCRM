@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Products</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('products.create') }}">
                        Add New
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <!-- Products Table -->
            <div class="table-responsive">
                <table class="table table-striped" id="products-table">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Quantity Available</th>
                            <th colspan="3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->quantity_available }}</td>
                            <td>
                                <div class='btn-group'>
                                    <a href="{{ route('products.show', [$product->id]) }}" class='btn btn-default'>
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('products.edit', [$product->id]) }}" class='btn btn-primary'>
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    {!! Form::open(['route' => ['products.destroy', $product->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                    {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger', 'onclick' => 'return confirm("Are you sure?")']) !!}
                                    {!! Form::close() !!}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
