<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/app2.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/pages/welcome.css') }}" />

    <title>Home | MissDIY</title>
    <script src="https://kit.fontawesome.com/25b5310acf.js" crossorigin="anonymous"></script>

</head>

<body>
    {{-- {{ Auth::check() ? Auth::user()->email : 'Not logged in' }} --}}
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">

                <div class="collapse navbar-collapse topnav" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto topnav-left">
                        <a href="/"><img src="{{ asset('images/missDIY.png') }}" class="logo"> <span
                                class="title">Miss DIY</span> </a>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto topnav-right">
                        <a href="/">Home</a>
                        <div class="dropdown">
                            <a href="{{ route('products.index') }}" class="dropbtn">
                                Products <i class="fa fa-caret-down"></i>
                            </a>
                            <div class="dropdown-content">
                                <a href="{{ route('products.index') }}">All Categories</a>
                                @foreach ($categories as $category)
                                    <a href="{{ route('products.index', ['categoryId' => $category->id]) }}">{{ $category->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        @if (Auth::check() && Auth::user()->isCustomer())
                            <a href="{{ route('cart.index') }}"><i class="fa-solid fa-cart-shopping"></i></a>
                        @endif

                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fa-solid fa-user"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end dropdown-content"
                                    aria-labelledby="navbarDropdown">
                                    <a class="nav-link" href="{{ route('profile.show') }}">
                                        {{ __('My Profile') }}
                                    </a>
                                    <a class="nav-link" href="{{ route('profile.orders') }}">
                                        {{ __('My Orders') }}
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="nav-link" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main>
            @yield('content')
        </main>
    </div>
</body>

</html>
