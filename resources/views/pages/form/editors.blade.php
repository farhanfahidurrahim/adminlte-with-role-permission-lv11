@extends('adminlte::page')

@section('title', 'Bootstrap | DataTable')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>General Form</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
{{--                    <li class="breadcrumb-item"><a href="#">Home</a></li>--}}
{{--                    <li class="breadcrumb-item active">General Form</li>--}}
                    <a href="" class="btn btn-primary btn-sm shadow-sm rounded-pill px-3 py-2">
                        <i class="fas fa-plus-circle mr-1"></i> Add New
                    </a>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')


@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@stop
