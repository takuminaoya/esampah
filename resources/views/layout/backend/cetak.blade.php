<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Admin Dashboard Template">
    <meta name="keywords" content="admin,dashboard">
    <meta name="author" content="stacks">
    <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    
    <!-- Title -->
    <title> @yield('title')</title>

    <!-- Styles -->
    @include('layout.backend.css')
</head>
<header>
    <div class="row align-items-center">
        <div class="col text-center">
            <img src="{{ asset('images/backgrounds/mku.png') }}" width="70%" alt="">
        </div>
        
        <div class=" col-6 text-center align-item-center">
             <h2 class="text-center align-center"> @yield('judul')</h2>
             <h2 class="text-center align-center"> @yield('tahun')</h2>
        </div>
        <div class="col text-center">
            <img src="{{ asset('images/backgrounds/cub.png') }}" width="60%" alt="">
        </div>
        
    </div>
   
</header>
<body> 
    @yield('content')
</body>
<footer>
    <span style="color: grey">CIPTA UNGASAN BERSIH - BUMDESA MEGA KENCANA UNGASAN | 081238345858</span>
</footer>
</html>