<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials._head')
</head>
<body class="nav-md">
    <div class="container body">

        <div class="main_container">

            {{--top nav--}}
            @include('partials._sidenav')
            {{--/topnav--}}

            <!-- top navigation -->
            @include('partials._topnav')
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                <div class="page-title">
                    <div class="title_left">
                        <h3>@yield('title')</h3>
                    </div>

                    <div class="clearfix"></div>
                    <div class="data-pjax">
                        @yield('content')

                    </div>
                </div>
                <!-- /page content -->

                <!-- footer content -->
                @include('partials._footer')
                <!-- /footer content -->
            </div>

            <script src="{{asset('js/app.js')}}"></script>
            @include('partials._notification')
            @stack('scripts')

</body>

</html>
