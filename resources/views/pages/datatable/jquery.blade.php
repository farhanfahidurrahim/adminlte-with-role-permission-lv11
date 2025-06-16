@extends('adminlte::page')

@section('title', 'Yajra | DataTable')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Index Yajra</h1>
        <a href="" class="btn btn-primary btn-sm shadow-sm rounded-pill px-3 py-2">
            <i class="fas fa-plus-circle mr-1"></i> Add New
        </a>
    </div>
@stop

@section('content')

    <div class="card">
        <div class="card-body">
            
        </div>
    </div>

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
