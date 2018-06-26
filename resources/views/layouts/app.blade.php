<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript">
        const app_url = "{{URL::to('/')}}";
    </script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <!-- <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css"> -->
    <link href="https://fonts.googleapis.com/css?family=Lora" rel="stylesheet" type="text/css">
    

    <!-- FontAwsome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <!-- Styles -->
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('css')
</head>
<body>
    <!-- Nav bar -->
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
        <div class="container">
            <a class="navbar-brand" href="{{URL::to('/')}}">Innovative Idea</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                @if(Auth::user())
                @if(Auth::user()->role == 0)
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/author/all') }}">Author List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/genre/all') }}">Genre List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/publisher/all') }}">Publisher List</a>
                    </li>
                   <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/book/all') }}">Book List</a>
                    </li>
                </ul>
                @endif
                @endif
                <div class="row ml-auto ">
                    <form class="form-inline" action="{{ url('search') }}" method="GET">
                        <div class="input-group ">
                            <input type="search" class="form-control" name="query" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
                            <div class="input-group-prepend">
                                <button class="btn" type="submit"><span class="fa fa-search"></span></button>
                            </div>
                        </div>                       
                    </form>
                </div>
                <ul class="navbar-nav ml-auto">
                    @if(Auth::user())
                    <li class="nav-item">
                        <form action="{{url('logout')}}" method="POST"> 
                            @csrf
                             <button class="btn btn-outline-success my-2 ml-2 my-sm-0" type="submit">Logout</button>
                        </form>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('register') }}">Sign Up</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" href="{{ url('login') }}">Sign In</a>
                    </li>
                    @endif
                </ul>

            </div>
        </div>
    </nav>
    <!-- Nav bar -->
    <div class="container">
        @yield('content')
    </div>
    @yield('scripts')
</body>
</html>
