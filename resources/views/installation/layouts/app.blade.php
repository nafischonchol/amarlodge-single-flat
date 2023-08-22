<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="{{ asset('/images/default-favicon.png') }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Flat - @yield('title')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link href="{{ asset('theme/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('theme/css/bootstrap-extended.css') }}" rel="stylesheet" />
    <link href="{{ asset('theme/css/fonts.googleapis.icon.material.css') }}" rel="stylesheet" />
    <link href="{{ asset('theme/css/google-icon-custom.css') }}" rel="stylesheet" />

    <style>
        .pull-right {
            float: right;
        }

        .font-size-material {
            font-size: 18px;
        }
    </style>

</head>

<body>


    <div class="content">
        @yield('content')
    </div>

    <footer class="main-footer">
        <div class="row text-center">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <span> Copyright &copy; 2020-{{ Carbon\carbon::now()->year }}
                    <a href="http://ictbanglabd.com/" target="_blank">ICT Bangla BD</a>.</span>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <span> For Support<a> +88 01766 - 94 89 57</a></span>
            </div>

        </div>
    </footer>

    <script src="{{ asset('theme/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        $.ajaxSetup({

            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}'
            }

        });
    </script>
</body>
@show

@stack('js')


</html>
