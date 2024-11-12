@extends('layouts.app')

@section('content')

<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<div class="container-fluid">
    <h1 class="text-black">Welcome {{ Auth::user()->name }}</h1>
    <p>{{ \Carbon\Carbon::now()->format('F j, Y') }}</p>
    
    <div class="container my-4">
        <div class="row text-center">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <p class="h3 mb-1 text-blue">{{ $totalClients }}</p>
                        <p class="text-muted">Clients</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <p class="h3 mb-1 text-blue">{{ $totalProducts }}</p>
                        <p class="text-muted">Products</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <p class="h3 mb-1 text-blue">{{ $totalOrders }}</p>
                        <p class="text-muted">Orders</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.chart')  

</div>
@endsection
