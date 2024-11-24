@extends('layouts.app')

@section('content')

<head>
    
<style>
h1,p{
    text-align: center;
}
    </style>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
   
</head>
<div class="container-fluid">
    <h1 class="text-black">Welcome {{ Auth::user()->name }}</h1>
    <p>{{ \Carbon\Carbon::now()->format('F j, Y') }}</p>
    
    <div class="container-fluid-1">
        <div class="row-1">
            <div class="col">
              
                    <div class="card-body" style="width: 425px; height:175px">
                    <div class="card bg-gradient-primary">
                        <p class="h3 mb-1 text-black">{{ $totalClients }}</p>
                        <p class="text-black">Clients</p>
                        <i class="nav-icon fas fa-address-book"></i>
                        <hr>
                        <form action="{{route('clients.index')}}" method="GET">
                        <button type="submit" class="btn btn-dark">View clients</button>
                        </form>
                        </div>
                    </div>
                
            </div>
            <div class="col">
            
                    <div class="card-body"style="width: 425px; height:175px">
                    <div class="card bg-gradient-success">
                        <p class="h3 mb-1 text-black">{{ $totalProducts }}</p>
                        <p class="text-black">Products</p>
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <hr>
                        <form action="{{route('products.index')}}" method="GET">
                        <button type="submit" class="btn btn-dark" >View products</button>
                        </form>
                        </div>
                    </div>
                
            </div>
            <div class="col">
            
                    <div class="card-body" style="width: 425px; height:175px">
                    <div class="card bg-gradient-warning">
                        <p class="h3 mb-1 text-black">{{ $totalOrders }}</p>
                        <p class="text-black">Orders</p>
                        <i class="nav-icon fas fa-shopping-basket"></i>
                        <hr>
                        <form action="{{route('orders.index')}}" method="GET">
                        <button type="submit" class="btn btn-dark" >View orders</button>
                        </form>
                        </div>
                    </div>
               </div>
        </div>
    </div>

    <div class="container-fluid-1">
    <div class="row-1">
            <div class="col">
            
                    <div class="card-body" style="width: 425px; height:175px">
                    <div class="card bg-gradient-secondary">
                        <p class="h3 mb-1 text-black">{{ $totalDepartments }}</p>
                        <p class="text-black">Departments</p>
                        <i class="nav-icon fas fa-users"></i>
                        <hr>
                        <form action="{{route('departments.index')}}" method="GET">
                        <button type="submit" class="btn btn-dark">View departments</button>
                        </form>
                        </div>
                    </div>
               
            </div>
            <div class="col">
            
                    <div class="card-body" style="width: 425px; height:175px">
                      <div class="card bg-info">
                        <p class="h3 mb-1 text-black">{{ $totalEmployees }}</p>
                        <p class="text-black">Employees</p>
                        <i class="nav-icon fas fa-user"></i>
                        <hr>
                        <form action="{{route('employees.index')}}" method="GET">
                        <button type="submit" class="btn btn-dark">View employees</button>
                        </form>
                          </div>
                        </div>
                   
            </div>
            <div class="col">
            
                    <div class="card-body" style="width: 425px; height:175px">
                    <div class="card bg-light">
                        <p class="h3 mb-1 text-black">{{ $totalInteractions }}</p>
                        <p class="text-black">Interactions</p>
                        <i class="nav-icon fas fa-tasks"></i>
                        <hr>
                        <form action="{{route('interactions.index')}}" method="GET">
                        <button type="submit" class="btn btn-dark">View interactions</button>
                        </form>
                        </div>
                   
                </div>
            </div>
    </div>
    </div>

    <div class="container-fluid-2">

        <div class="row-1">
        <div class= "col-1">
            <div class="card-body"style="width:250px; height:250px; margin:auto;">
             @include('partials.summaryChart')
             </div>
             </div>
     
  <div class= "col-1"> 
    <div class="card-body">
    @include('partials.infoChart') 
    </div>
  </div>
  </div>
   <div class="container-fluid-2">
    <div class="row-1">
    <div class="col-1">
  <div class="card-body"> @include('partials.chart') </div>
  </div>
   <div class="col-1">
  <div class="card-body"> @include('partials.myChart') </div>
  </div>
   </div>
   </div>

  </div>

  </div>
    

</div>
@endsection
