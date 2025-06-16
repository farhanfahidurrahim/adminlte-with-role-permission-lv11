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
            {{-- Yajra DataTable --}}
            <table id="yajraTable" class="table display" style="width:100%">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Updated By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
        // Yajra DataTable Script
        $(function() {
            let table = $('#yajraTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('posts.index') }}',
                    data: function(d) {
                        d.date_from = $('#date_from').val();
                        d.date_to = $('#date_to').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'date',
                        name: 'date',
                        searchable: true
                    },
                    {
                        data: 'category_id',
                        name: 'category_id'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'created_by',
                        name: 'created_by'
                    },
                    {
                        data: 'updated_by',
                        name: 'updated_by'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });

            // Filter Data
            $('#filter').click(function() {
                table.draw();
            });

            // Reset Filter
            $('#reset').click(function() {
                $('#date_from').val('');
                $('#date_to').val('');
                table.draw();
            });
        });
    </script>
@stop
