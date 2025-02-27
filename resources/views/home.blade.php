
@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Dashboard</h1>
        <div>
            <select class="form-control">
                <option>Today</option>
                <option>Yesterday</option>
                <option>This Week</option>
                <option>This Month</option>
            </select>
        </div>
    </div>
@stop

@section('content')
    <div class="container mt-1">
        <div class="row">
            <!-- Example of a Gradient Card -->
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card card-gradient shadow-sm">
                    <div class="card-body text-white">
                        <h5 class="card-title">Category</h5>
                        <p class="card-text">Some quick example text to build on the card title </p>
                        <a href="#" class="btn btn-light">Go somewhere</a>
                    </div>
                </div>
            </div>

            <!-- Another Gradient Card -->
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card card-gradient shadow-sm">
                    <div class="card-body text-white">
                        <h5 class="card-title">Post</h5>
                        <p class="card-text">Some more content to demonstrate the gradient effect and card styling.</p>
                        <a href="#" class="btn btn-light">Go somewhere</a>
                    </div>
                </div>
            </div>

            <!-- Add more cards as needed -->

        </div>
    </div>
@stop

@section('css')
    <style>
        /* Gradient Background for Cards */
        .card-gradient {
            background: linear-gradient(45deg, #000000, #808080, #ffffff); /* Black to Gray to White */
            border: none;
        }

        .card-gradient .card-body {
            background: rgba(0, 0, 0, 0.5); /* Slight dark overlay for text contrast */
            color: white;
        }

        .card-gradient .btn-light {
            background-color: rgba(255, 255, 255, 0.7);
            color: #333;
        }

        .card-gradient .btn-light:hover {
            background-color: #fff;
        }

        /* Responsive Card Layout */
        @media (max-width: 576px) {
            .card-gradient {
                margin-bottom: 15px;
            }
        }
    </style>
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop



{{--@extends('layouts.app')--}}

{{--@section('content')--}}
{{--<div class="container">--}}
{{--    <div class="row justify-content-center">--}}
{{--        <div class="col-md-8">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">{{ __('Dashboard') }}</div>--}}

{{--                <div class="card-body">--}}
{{--                    @if (session('status'))--}}
{{--                        <div class="alert alert-success" role="alert">--}}
{{--                            {{ session('status') }}--}}
{{--                        </div>--}}
{{--                    @endif--}}

{{--                    {{ __('You are logged in!') }}--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--@endsection--}}

