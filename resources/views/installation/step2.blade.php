@extends('installation.layouts.app')
@section('title', 'Purchase Code')
@section('content')
    <div class="container">
        <div class="row pt-5">
            <div class="col-md-12">
                @if (session()->has('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="mar-ver pad-btm text-center">
                    <h1 class="h3">Purchase Code </h1>
                    <p>
                        Provide your codecanyon purchase code.<br>
                        <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code"
                            class="text-info">Where to get purchase code?</a>
                    </p>
                </div>
                <div class="text-muted font-13">
                    <form method="POST" action="{{ route('purchase.code') }}">
                        @csrf
                        <div class="form-group mt-3">
                            <label for="purchase_code">Codecanyon Username</label>
                            <input type="text" value="{{ env('BUYER_USERNAME') }}" class="form-control" id="username"
                                name="username" placeholder="Enter username" required>
                        </div>

                        <div class="form-group mt-3">
                            <label for="purchase_code">Purchase Code</label>
                            <input type="text" value="{{ env('PURCHASE_CODE') }}" class="form-control" id="purchase_key"
                                name="purchase_key" placeholder="Enter key" required>
                        </div>
                        <div class="text-center mt-2">
                            <button type="submit" class="btn btn-info">Continue</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
