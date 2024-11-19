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
                    <div class="card bg-gradient-primary">
                        <p class="h3 mb-1 text-black">{{ $totalClients }}</p>
                        <p class="text-black">Clients</p>
                        <hr>
                        <hr>
                        <form action="{{route('clients.index')}}" method="GET">
                        <button type="submit" >View clients</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                    <div class="card bg-gradient-success">
                        <p class="h3 mb-1 text-black">{{ $totalProducts }}</p>
                        <p class="text-black">Products</p>
                        <hr>
                        <hr>
                        <form action="{{route('products.index')}}" method="GET">
                        <button type="submit" >View products</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                    <div class="card bg-gradient-warning">
                        <p class="h3 mb-1 text-black">{{ $totalOrders }}</p>
                        <p class="text-black">Orders</p>
                        <hr>
                        <hr>
                        <form action="{{route('orders.index')}}" method="GET">
                        <button type="submit" >View orders</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                    <div class="card bg-gradient-primary">
                        <p class="h3 mb-1 text-black">{{ $totalDepartments }}</p>
                        <p class="text-black">Departments</p>
                        <hr>
                        <hr>
                        <form action="{{route('departments.index')}}" method="GET">
                        <button type="submit" >View departments</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                      <div class="card bg-gradient-primary">
                        <p class="h3 mb-1 text-black">{{ $totalEmployees }}</p>
                        <p class="text-black">Employees</p>
                        <hr>
                        <hr>
                        <form action="{{route('employees.index')}}" method="GET">
                        <button type="submit" >View employees</button>
                        </form>
                          </div>
                        </div>
                    </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                    <div class="card bg-gradient-primary">
                        <p class="h3 mb-1 text-black">{{ $totalInteractions }}</p>
                        <p class="text-black">Interactions</p>
                        <hr>
                        <form action="{{route('interactions.index')}}" method="GET">
                        <button type="submit" >View interactions</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container row">
    <div class= "col-md-6"> @include('partials.summaryChart') </div>
     
  <div class= "col-md-6"> @include('partials.infoChart') </div>

  <div class= "col-md-6"> @include('partials.chart') </div>

  <div class="col-md-6"> @include('partials.myChart') </div>

  </div>
    

</div>
@endsection
