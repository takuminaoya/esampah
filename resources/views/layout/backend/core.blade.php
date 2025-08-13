
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
    <title>Cipta Ungasan Bersih - Desa Ungasan</title>

    <!-- Styles -->
    @include('layout.backend.css')

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div class="app horizontal-menu align-content-stretch d-flex flex-wrap">
        <div class="app-container">

            {{-- header --}}
            @include('layout.backend.header')
            {{-- header --}}
            @auth
                @include('layout.backend.nav')
            @endauth
            {{-- Content --}}
            <div class="app-content">
                <div class="content-wrapper">
                    @yield('content')
                </div>
            </div>
            {{-- Content --}}
        </div>
    </div>
    
    <!-- Javascripts -->
    @include('layout.backend.js')
</body>
</html>