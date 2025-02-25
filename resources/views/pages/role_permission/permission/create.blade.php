@extends('adminlte::page')

@section('title', 'Permission | Create')

@section('content_header')
    <h1>Create New</h1>
@stop

@section('content')

    <div class="card">
        <div class="card-body">
            <form action="{{ route('permissions.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Module Name</label>
                    <input type="text" name="module" id="name" class="form-control" placeholder="Enter name" required>
                </div>

                <div class="form-group">
                    <label for="name">Select Route</label>
                    <select name="name" id="name" class="form-control">
                        <option value="">-- Select Route --</option>
                        @foreach($routes as $route)
                            <option value="{{ $route }}">{{ $route }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name')  }}</span>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
