<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ __('Keloola') }}</title>
    <meta name="description" content="">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/logo_keloola_Icon_only.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/logo_keloola_Icon_only.png">
    <link rel="manifest" href="/site.webmanifest">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('/theme-assets/feather/feather.css?ver='.time()) }}">
    <link rel="stylesheet" href="{{asset('/theme-assets/mdi/css/materialdesignicons.min.css?ver='.time()) }}">
    <link rel="stylesheet" href="{{asset('/theme-assets/ti-icons/css/themify-icons.css?ver='.time()) }}">
    <link rel="stylesheet" href="{{asset('/theme-assets/typicons/typicons.css?ver='.time()) }}">
    <link rel="stylesheet" href="{{asset('/theme-assets/simple-line-icons/css/simple-line-icons.css?ver='.time()) }}">
    <link rel="stylesheet" href="{{asset('/theme-assets/css/vendor.bundle.base.css?ver='.time()) }}">
    <link rel="stylesheet" href="{{asset('/css/horizontal-layout-dark/style.css?ver='.time()) }}">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="main-panel">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>

</body>
</html>
