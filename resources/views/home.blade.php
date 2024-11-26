@extends('layouts.app')

@section('content')

<head>


    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="{{asset('css\myUI.css')}}" type="text/css" 
          rel="stylesheet" />
   
</head>

<div class="container-fluid">

    <div class="item0" style="height:50px">
    <h1>Welcome {{ Auth::user()->name }}</h1>
    <p>{{ \Carbon\Carbon::now()->format('F j, Y') }}</p>
     </div>
    
         <div class="container">
                   
                <div class="card bg-primary">
                    <div class="card-body">

                        <p>{{ $totalClients }}</p>
                        <p>Clients</p>
                        <i class="nav-icon fas fa-address-book fa-2x"></i>
                        <div>
                        <hr>
                        <form action="{{route('clients.index')}}" method="GET">
                           
                        <button type="submit" class="btn btn-dark">View clients</button>
                        </form>
                        </div>

                        </div>
                        </div>
                    
                     <div class="card bg-warning">
                    <div class="card-body">
                  
                        <p>{{ $totalProducts }}</p>
                        <p>Products</p>
                        <i class="nav-icon fas fa-shopping-cart fa-2x"></i>
                        <div>
                        <hr>
                        <form action="{{route('products.index')}}" method="GET">
                        <button type="submit" class="btn btn-dark" >View products</button>
                        </form>
                        </div>
                        </div>
            </div>

                       <div class="card bg-dark">
                   <div class="card-body">
                    
                        <p>{{ $totalOrders }}</p>
                        <p>Orders</p>
                        <i class="nav-icon fas fa-shopping-basket fa-2x"></i>
                        <div>
                        <hr>
                        <form action="{{route('orders.index')}}" method="GET">
                        <button type="submit" class="btn btn-dark" >View orders</button>
                        </form>
                        </div>
                        </div>
                        </div>
                   
                </div>
                <div>

              </div>       
                   
               <div class="container1">
        
              <div class="item7">
              @include('partials.chart') 
              </div>
     
          <div class="item8">
          @include('partials.summaryChart')
          </div>

     </div>
</div>

@endsection
