@extends('installation.layouts.app')
@section('title', 'Setp 1')
@section('content')
    <div class="container">
        <div class="row pt-5">
            <div class="col-md-12">
                <div class="mar-ver pad-btm text-center">
                    <h1 class="h3">Installation Progress Started!</h1>
                    <p>We are checking file permissions.</p>
                </div>

                <ul class="list-group">
                    <li class="list-group-item text-semibold">
                        Php version 8.0 +
                        @if ($permission['phpVersion'] >= 8.0)
                            <span class="material-symbols-outlined text-success pull-right">
                                done
                            </span>
                        @else
                            <span class="material-symbols-outlined text-danger pull-right">
                                close
                            </span>
                        @endif
                    </li>
                    <li class="list-group-item text-semibold">
                        Curl Enabled

                        @if ($permission['curl_enabled'])
                            <span class="material-symbols-outlined text-success pull-right">
                                done
                            </span>
                        @else
                            <i class="fa fa-close text-danger pull-right"></i>
                        @endif
                    </li>
                    <li class="list-group-item text-semibold">
                        <b>.env</b> File Permission

                        @if ($permission['db_file_write_perm'])
                            <span class="material-symbols-outlined text-success pull-right">
                                done
                            </span>
                        @else
                            <i class="fa fa-close text-danger pull-right"></i>
                        @endif
                    </li>
                    <li class="list-group-item text-semibold">
                        <b>RouteServiceProvider.php</b> File Permission

                        @if ($permission['routes_file_write_perm'])
                            <span class="material-symbols-outlined text-success pull-right">
                                done
                            </span>
                        @else
                            <i class="fa fa-close text-danger pull-right"></i>
                        @endif
                    </li>
                </ul>

                <p class="text-center pt-3">
                    @if (
                        $permission['curl_enabled'] == 1 &&
                            $permission['db_file_write_perm'] == 1 &&
                            $permission['routes_file_write_perm'] == 1 &&
                            $permission['phpVersion'] >= 8.0)
                        <a href="{{ route('step2') }}" class="btn btn-info">Next </a>
                    @endif
                </p>
            </div>
        </div>
    </div>
@endsection
