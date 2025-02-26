@extends('adminlte::page')

@section('title', 'List | Post')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Post List</h1>
        <a href="{{ route('posts.create') }}" class="btn btn-sm btn-primary">Add New</a>
    </div>
@stop
@section('content')
    {{-- Date Range Filter --}}
    <div class="row mb-2">
        <div class="col-md-2">
            <input type="date" id="date_from" class="form-control" placeholder="From Date (YYYY-MM-DD)">
        </div>
        <div class="col-md-2">
            <input type="date" id="date_to" class="form-control" placeholder="To Date (YYYY-MM-DD)">
        </div>
        <div class="col-md-2">
            <button id="filter" class="btn btn-sm btn-primary">Filter</button>
            <button id="reset" class="btn btn-sm btn-secondary">Reset</button>
        </div>

        <!-- Export -->
        <div class="col-md-4">
            <a href="#" class="btn btn-sm btn-success" id="exportPostBtn">Export Posts</a>
            <a href="" class="btn btn-sm btn-danger" id="pdfExportBtn">PDF</a>
        </div>
    </div>

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
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
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
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false },
                    { data: 'name', name: 'name' },
                    { data: 'date', name: 'date', searchable: true },
                    { data: 'category_id', name: 'category_id' },
                    { data: 'status', name: 'status' },
                    { data: 'created_by', name: 'created_by' },
                    { data: 'updated_by', name: 'updated_by' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
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

    {{--    Handle export button click with date filters--}}
    <script>
        document.getElementById('exportPostBtn').addEventListener('click', function () {
            const dateFrom = document.getElementById('date_from').value;
            const dateTo = document.getElementById('date_to').value;

            let url = '{{ route('export', ['modelType' => 'posts']) }}';
            if (dateFrom) {
                url += '?date_from=' + dateFrom;
            }
            if (dateTo) {
                url += '&date_to=' + dateTo;
            }

            window.location.href = url; // Trigger the download
        });
    </script>
@stop
