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

                    <div class="container">
                        @if(!$pageWithVue)
                            @section('breadcrumbs', Breadcrumbs::render())
                            @yield('breadcrumbs')
                            @include('layouts.partials.flash')
                            @yield('content')
                        @endif
                    </div>
            </main>

            <footer>
                <div class="container">
                    <div class="border-top pt-3">
                        <p style="text-align: center;">&copy; {{ date('Y') }} - {{ config('app.author') }}</p>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Scripts -->
        <script  src="{{ mix('js/app.js', (config('app.env') == 'local') ? 'build' : '') }}"></script>

        @yield('scripts')

        @env('local')
        @endenv
    </body>
</html>
