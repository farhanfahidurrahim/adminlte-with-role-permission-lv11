@extends('adminlte::page')

@section('title', 'List | Categories')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Category List</h1>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">Add New</a>
    </div>
@stop

@section('content')
    <table id="myTable" class="display" style="width:100%">
        <thead>
        <tr>
            <th>SL</th>
            <th>Name</th>
            <th>Created By</th>
            <th>Updated By</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($categories as $row)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->createdBy->name ?? 'N/A' }}</td>
                <td>{{ $row->updateddBy->name ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('categories.edit', $row->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('categories.destroy', $row->id) }}" method="POST" style="display:inline;">
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
