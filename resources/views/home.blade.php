@extends('layouts.app')
<title>LearnsoftCRM</title>
@section('content')
    <div class="container-fluid">
        <h1 class="text-black-50">You are logged in!</h1>
        <h2>Welcome, {{$user_name}}!</h2>
    </div>
@endsection
