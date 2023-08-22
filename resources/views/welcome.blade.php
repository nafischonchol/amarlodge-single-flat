<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <!--plugins-->
    <link href="{{ asset('theme/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />

    <link href="{{ asset('theme/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="{{ asset('theme/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('theme/css/bootstrap-extended.css') }}" rel="stylesheet" />
    <link href="{{ asset('theme/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('theme/css/fonts.googleapis.robots.css') }}" rel="stylesheet">

    <!-- loader-->
    <link href="{{ asset('theme/css/pace.min.css') }}" rel="stylesheet" />

    <link href="{{ asset('theme/css/fonts.googleapis.icon.material.css') }}" rel="stylesheet" />
    <link href="{{ asset('theme/css/google-icon-custom.css') }}" rel="stylesheet" />
    @vite('resources/js/app.js')
</head>

<body class="antialiased">
    <div id="app"></div>

    <!-- Bootstrap bundle JS -->
    <script src="{{ asset('theme/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->
    <script src="{{ asset('theme/js/jquery.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('theme/js/pace.min.js') }}"></script>
    <!--app-->
    <script src="{{ asset('theme/js/app.js') }}"></script>
    <script src="{{ asset('theme/js/index.js') }}"></script>

</body>

</html>
