@extends('adminlte::page')

@section('title', 'Permission | List')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Permission List</h1>
        <a href="{{ route('permissions.create') }}" class="btn btn-primary">Add New</a>
    </div>
@stop

@section('content')
    <table id="myTable" class="display" style="width:100%">
        <thead>
        <tr>
            <th>SL</th>
            <th>Module Name</th>
            <th>Permission Name</th>
            <th>Created By</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($permissions as $row)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row->module ?? 'N/A' }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->createdBy->name ?? 'N/A' }}</td>
                <td><a href="{{ route('roles.edit', $row->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('roles.destroy', $row->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
