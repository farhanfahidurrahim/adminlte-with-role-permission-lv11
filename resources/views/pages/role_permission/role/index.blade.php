@extends('adminlte::page')

@section('title', 'Role | List')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Role List</h1>
        <a href="{{ route('roles.create') }}" class="btn btn-primary">Add New</a>
    </div>
@stop

@section('content')
    <table id="myTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>SL</th>
                <th>Role Name</th>
                <th>Role Has Permission</th>
                <th>Created By</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->name }}</td>
                    <td>
                        @foreach($row->permissions as $permission)
                            <span class="badge bg-success">{{ $permission->name }}</span>
                        @endforeach
                    </td>
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
