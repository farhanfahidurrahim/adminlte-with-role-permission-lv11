@extends('adminlte::page')

@section('title', 'List | Post')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Post List</h1>
        <a href="{{ route('posts.create') }}" class="btn btn-primary">Add New</a>
    </div>
@stop

@section('content')
    <table class="table" id="yajraTable">
        <thead>
        <tr>
            <th>SL</th>
            <th>Name</th>
            <th>Category</th>
            <th>Status</th>
            <th>Created By</th>
            <th>Updated By</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
        $(function() {
            $('#yajraTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('posts.index') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false },
                    { data: 'name', name: 'name' },
                    { data: 'category_id', name: 'category_id' },
                    { data: 'status', name: 'status' },
                    { data: 'created_by', name: 'created_by' },
                    { data: 'updated_by', name: 'updated_by' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
            });
        });
    </script>
@stop
