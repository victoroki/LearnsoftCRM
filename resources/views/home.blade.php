@extends('layouts.app')

@section('content')

<head>


    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="{{asset('css\myUI.css')}}" type="text/css" 
          rel="stylesheet" />
   
</head>

<div class="container-fluid">
    <h1 class="text-black">Welcome {{ Auth::user()->name }}</h1>
    <p>{{ \Carbon\Carbon::now()->format('F j, Y') }}</p>
    
    <div class="container-fluid-1">
        <div class="row-1">
           
              <div class="card-body-1">
                   
                        <p class="h3 mb-1 text-black">{{ $totalClients }}</p>
                        <p class="text-black">Clients</p>
                        <i class="nav-icon fas fa-address-book fa-2x"></i>
                        <hr>
                        <form action="{{route('clients.index')}}" method="GET">
                        <button type="submit" class="btn btn-dark">View clients</button>
                        </form>
                    
                </div>
           </div>

            <div class="row-1">
            
                    <div class="card-body-2">
                  
                        <p class="h3 mb-1 text-black">{{ $totalProducts }}</p>
                        <p class="text-black">Products</p>
                        <i class="nav-icon fas fa-shopping-cart fa-2x"></i>
                        <hr>
                        <form action="{{route('products.index')}}" method="GET">
                        <button type="submit" class="btn btn-dark" >View products</button>
                        </form>
                       
                    </div>
                
            </div>
            <div class="row-1">
            
                    <div class="card-body-3">
                    
                        <p class="h3 mb-1 text-black">{{ $totalOrders }}</p>
                        <p class="text-black">Orders</p>
                        <i class="nav-icon fas fa-shopping-basket fa-2x"></i>
                        <hr>
                        <form action="{{route('orders.index')}}" method="GET">
                        <button type="submit" class="btn btn-dark" >View orders</button>
                        </form>
                        </div>
                   
               </div>
    </div>

    <div class="container-fluid-2">
    
            <div class="row-2">
            
                    <div class="card-body-4">
                   
                        <p class="h3 mb-1 text-black">{{ $totalDepartments }}</p>
                        <p class="text-black">Departments</p>
                        <i class="nav-icon fas fa-users fa-2x"></i>
                        <hr>
                        <form action="{{route('departments.index')}}" method="GET">
                        <button type="submit" class="btn btn-dark">View departments</button>
                        </form>
                        </div>
               
            </div>
            <div class="row-2">
            
                    <div class="card-body-5">
                      
                        <p class="h3 mb-1 text-black">{{ $totalEmployees }}</p>
                        <p class="text-black">Employees</p>
                        <i class="nav-icon fas fa-user fa-2x"></i>
                        <hr>
                        <form action="{{route('employees.index')}}" method="GET">
                        <button type="submit" class="btn btn-dark">View employees</button>
                        </form>
                          
                        </div>
                   
            </div>
            <div class="row-2">
            
                    <div class="card-body-6">
                   
                        <p class="h3 mb-1 text-black">{{ $totalInteractions }}</p>
                        <p class="text-black">Interactions</p>
                        <i class="nav-icon fas fa-tasks fa-2x"></i>
                        <hr>
                        <form action="{{route('interactions.index')}}" method="GET">
                        <button type="submit" class="btn btn-dark">View interactions</button>
                        </form>
                        </div>
                   
               
            </div>
     </div>

    <div class="container-fluid-3">

        <div class="row-3">
        
            <div class="card-body-7">


             @include('partials.summaryChart')
              </div>
        </div>

  <div class= "row-3"> 
    
    <div class="card-body-8">


    @include('partials.infoChart') 
    </div>
  </div>

  
  <div class="row-3">

      <div class="card-body-9"> @include('partials.chart') </div>
  </div>

  <div class="row-3">
  <div class="card-body-10"> @include('partials.myChart') </div>
  </div>


  </div>
  

    
</div>

@endsection
