@php
    $pageWithVue = in_array(Route::currentRouteName(), ['home', 'any']);
    //$value = 'null';
    //echo (!('null' === 'null' || (Str::length('null') === 32 && \App\Models\Admin\Cart\Token::firstWhere('token', 'null'))));

@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>
            {{ config('app.name', 'Laravel') }}
{{--            @yield('title')--}}
        </title>
    {{--    @yield('meta')--}}
    <!-- Styles -->
        <link href="{{ mix('css/app.css', (config('app.env') == 'local') ? 'build' : '' ) }}" rel="stylesheet">
        @yield('custom_css')
    </head>
    <body>
        <div id="app">
            <header class="header">
                <nav class="navbar navbar-expand-md navbar-dark">
                    <div class="container">
                        <a class="navbar-brand" href="{{ url('/') }}">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <!-- Left Side Of Navbar -->
                            <ul class="navbar-nav mr-auto">

                            </ul>

                            <!-- Right Side Of Navbar -->
                            <ul class="navbar-nav ml-auto">
                                <!-- Authentication Links -->
{{--                                @guest--}}
{{--                                    <li><a class="nav-link" href="{{ route('login') }}">Login</a></li>--}}
{{--                                    <li><a class="nav-link" href="{{ route('register') }}">Register</a></li>--}}
{{--                                @else--}}
                                    @auth
                                        <li class="nav-item dropdown">
                                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                {{ Auth::user()->name }} <span class="caret"></span>
                                            </a>

                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
    {{--                                            @can ('admin-panel')--}}
                                                    <a class="dropdown-item" href="{{ route('admin.home') }}">Admin</a>
    {{--                                            @endcan--}}
                                                {{--                                    <a class="dropdown-item" href="{{ route('cabinet.home') }}">Cabinet</a>--}}
                                                <a class="dropdown-item" href="{{ route('logout') }}"
                                                   onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();">
                                                    Logout
                                                </a>

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                            </div>
                                        </li>
                                    @endauth
{{--                                @endguest--}}
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
            <main
                @class(['app-content', 'py-3' => !$pageWithVue])
                {!! !$pageWithVue ?: 'id="app-vue"' !!}
            >
                    @if($pageWithVue)
{{--                        <app-component date="{{ date('d.m.Y') }}"></app-component>--}}
                        <app-component/>
                    @endif


                        @if(!$pageWithVue)
                            <div class="container">
                                @section('breadcrumbs', Breadcrumbs::render())
                                @yield('breadcrumbs')
                                @include('layouts.partials.flash')
                                @yield('content')
                            </div>
                        @endif

            </main>

{{--            <footer>--}}
{{--                <div class="container">--}}
{{--                    <div class="mobile-button">--}}
{{--                        <a href="#">--}}
{{--                            <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                <path d="M11.8688 2.25259C12.2477 1.9158 12.8187 1.9158 13.1976 2.25259L22.1976 10.2526C22.6104 10.6195 22.6475 11.2516 22.2806 11.6644C21.9137 12.0771 21.2816 12.1143 20.8689 11.7474L20.5332 11.4491V19C20.5332 20.1046 19.6378 21 18.5332 21H6.53321C5.42864 21 4.53321 20.1046 4.53321 19V11.4491L4.19758 11.7474C3.78479 12.1143 3.15272 12.0771 2.7858 11.6644C2.41889 11.2516 2.45607 10.6195 2.86885 10.2526L11.8688 2.25259ZM6.53321 9.67129V19H9.53321V14C9.53321 13.4477 9.98093 13 10.5332 13H14.5332C15.0855 13 15.5332 13.4477 15.5332 14V19H18.5332V9.67129L12.5332 4.33795L6.53321 9.67129ZM13.5332 19V15H11.5332V19H13.5332Z" fill="#2F3ED7" fill-opacity="0.9"></path>--}}
{{--                            </svg>--}}
{{--                            <span>Главная</span>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                    <div class="mobile-button relative">--}}
{{--                        <a href="#">--}}
{{--                            <span class="cart-total basket-mobile-count">--}}
{{--                                0--}}
{{--                            </span>--}}
{{--                            <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                <path d="M5.03272 3.99989L6.89975 16.1356C6.91334 16.2357 6.94176 16.3312 6.98273 16.4197C7.10605 16.6859 7.34308 16.8888 7.6315 16.966C7.71961 16.9897 7.81196 17.0015 7.9064 16.9999H18.8906C19.3322 16.9999 19.7216 16.7102 19.8485 16.2872L22.8485 6.28724C22.9393 5.98447 22.8816 5.65657 22.6929 5.40296C22.5042 5.14935 22.2067 4.99989 21.8906 4.99989H7.2101L6.88121 2.86209C6.86889 2.7727 6.84475 2.68709 6.81043 2.60687C6.74814 2.4608 6.65275 2.33426 6.53492 2.23508C6.4256 2.14289 6.29623 2.07372 6.15429 2.03502C6.06496 2.01056 5.97123 1.9983 5.87532 1.99989H3.89062C3.33834 1.99989 2.89062 2.44761 2.89062 2.99989C2.89062 3.55218 3.33834 3.99989 3.89062 3.99989H5.03272ZM8.74856 14.9999L7.51779 6.99989H20.5466L18.1466 14.9999H8.74856Z" fill="black" fill-opacity="0.9"></path>--}}
{{--                                <path d="M10.8906 19.9999C10.8906 21.1045 9.99519 21.9999 8.89062 21.9999C7.78606 21.9999 6.89062 21.1045 6.89062 19.9999C6.89062 18.8953 7.78606 17.9999 8.89062 17.9999C9.99519 17.9999 10.8906 18.8953 10.8906 19.9999Z" fill="black" fill-opacity="0.9"></path>--}}
{{--                                <path d="M19.8906 19.9999C19.8906 21.1045 18.9952 21.9999 17.8906 21.9999C16.7861 21.9999 15.8906 21.1045 15.8906 19.9999C15.8906 18.8953 16.7861 17.9999 17.8906 17.9999C18.9952 17.9999 19.8906 18.8953 19.8906 19.9999Z" fill="black" fill-opacity="0.9"></path>--}}
{{--                            </svg>--}}
{{--                            <span>Корзина</span>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                    <div class="mobile-button">--}}
{{--                        <a href="#" data-toggle="offcanvas-profile" data-target="#menu-mobile-ns-profile.navmenu.offcanvas" data-canvas="body">--}}
{{--                            <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                <path d="M12.25 4C10.0409 4 8.25 5.79086 8.25 8C8.25 10.2091 10.0409 12 12.25 12C14.4591 12 16.25 10.2091 16.25 8C16.25 5.79086 14.4591 4 12.25 4ZM6.25 8C6.25 4.68629 8.93629 2 12.25 2C15.5637 2 18.25 4.68629 18.25 8C18.25 11.3137 15.5637 14 12.25 14C8.93629 14 6.25 11.3137 6.25 8ZM8.25 18C6.59315 18 5.25 19.3431 5.25 21C5.25 21.5523 4.80228 22 4.25 22C3.69772 22 3.25 21.5523 3.25 21C3.25 18.2386 5.48858 16 8.25 16H16.25C19.0114 16 21.25 18.2386 21.25 21C21.25 21.5523 20.8023 22 20.25 22C19.6977 22 19.25 21.5523 19.25 21C19.25 19.3431 17.9069 18 16.25 18H8.25Z" fill="black" fill-opacity="0.9"></path>--}}
{{--                            </svg>--}}
{{--                            <span> Профиль</span>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                    <div class="border-top pt-3">--}}
{{--                        <p style="text-align: center;">&copy; {{ date('Y') }} - {{ config('app.author') }}</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </footer>--}}
        </div>

        <!-- Scripts -->
        <script  src="{{ mix('js/app.js', (config('app.env') == 'local') ? 'build' : '') }}"></script>

        @yield('scripts')

        @env('local')
        @endenv
    </body>
</html>
