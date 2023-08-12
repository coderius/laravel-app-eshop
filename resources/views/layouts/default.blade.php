<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="@yield('mete_description')">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Pinterest -->
    <meta name="p:domain_verify" content="0ccc12f81c22e4859b0e75720a7867dc"/>
    <link rel="canonical" href="{{ url()->current() }}">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>@yield('mete_title') {{date("Y")}} - {{config('app.name')}}</title>

    @yield('mete_soc')

    <!-- Favicon  -->
    <link rel="icon" href="<?= url('/'); ?>/favicon.png" />

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="{{asset('appstyle/assets/bootstrap-5.0.2/css/bootstrap-reboot.css')}}">
    <link rel="stylesheet" href="{{asset('appstyle/assets/bootstrap-5.0.2/css/bootstrap-grid.css')}}">
    <link rel="stylesheet" href="{{asset('appstyle/assets/bootstrap-5.0.2/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('appstyle/assets/font-awesome/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('appstyle/styles/main.css?v=').time()}}">
    {{-- <style>
        @yield('styles')
    </style> --}}
    {{-- TODO  registerCss() own helper--}}
    {!! registerCss() !!}
    
</head>

<body class="">
    <!-- <body class=""> -->
    <div id="App">
        <div id="page">
            <!--header-->
            @include('layouts.header')

            <!--header menu-->
            @include('layouts.headermenu')

            <!--breadcrumbs-->
            <section class="bcr">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                            <!-- More info https://www.tutsplanet.com/snippets/how-to-check-if-the-current-page-is-homepage-in-laravel/ -->
                                @if(Request::is('/'))
                                <li class="breadcrumb-item">Главная</li>
                                @else
                                <li class="breadcrumb-item"><a href="<?= route('home', []); ?>">Главная</a></li>
                                @endif
                                @yield('breadcrumbs')
                                <!-- <li class="breadcrumb-item active" aria-current="page">Контакты</li> -->
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            </section>
       

            <!-- @include('layouts.breadcrumbs') -->
            
            
            <main>
                @yield('content')
            </main>
        </div>

        <!-- Footer -->
        @include('layouts.footer')

    </div>

    @yield('slider')

    <!-- ##### jQuery (Necessary for All JavaScript Plugins) ##### -->
    <script src="{{asset('appstyle/scripts/jquery/jquery-2.2.4.min.js')}}"></script>
    <script src="{{asset('appstyle/scripts/jquery-mobile/jquery.mobile.custom.min.js')}}"></script>
    <script src="{{asset('appstyle/assets/bootstrap-5.0.2/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('appstyle/scripts/main.js')}}"></script>
    
    <script>
        $(function () {
            @stack('scripts')
        });
    </script>
</body>

</html>