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
    <div class="row mb-2 d-flex justify-content-between">
        <div class="col-md-8 d-flex">
                <small>From:</small>
            <div class="col-md-3">
                <input type="date" id="date_from" class="form-control" placeholder="From Date (YYYY-MM-DD)">
            </div>
                <small>To:</small>
            <div class="col-md-3">
                <input type="date" id="date_to" class="form-control" placeholder="To Date (YYYY-MM-DD)">
            </div>
            <div class="col-md-3 d-flex">
                <button id="filter" class="btn btn-sm btn-primary mr-2">Filter</button>
                <button id="reset" class="btn btn-sm btn-secondary">Reset</button>
            </div>
        </div>

        <!-- Export Buttons -->
        <div class="col-md-4 d-flex justify-content-end">
            <a href="#" class="btn btn-sm btn-success mr-2" id="excelExportBtn"> <i class="fas fa-file-excel mr-1"></i>Excel</a>
            <a href="#" class="btn btn-sm btn-danger" id="pdfExportBtn"><i class="fas fa-file-pdf mr-1"></i>PDF</a>
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

    {{--Handle export button click with date filters--}}
    <script>
        // Handle EXCEL export button click
        $(document).ready(function () {
            var table = $('#yajraTable').DataTable();

            $('#excelExportBtn').click(function () {
                const dateFrom = $('#date_from').val();
                const dateTo = $('#date_to').val();
                const searchValue = table.search(); // Get search input from DataTable

                console.log("searchValue:", searchValue); // Debugging output

                let url = '{{ route('export', ['modelType' => 'posts']) }}';
                let params = [];

                if (dateFrom) params.push('date_from=' + dateFrom);
                if (dateTo) params.push('date_to=' + dateTo);
                if (searchValue) params.push('search=' + encodeURIComponent(searchValue));

                if (params.length > 0) {
                    url += '?' + params.join('&');
                }

                console.log("url", url)

                window.location.href = url;
            });


            // Handle PDF export button click
            $('#pdfExportBtn').click(function () {
                const dateFrom = document.getElementById('date_from').value;
                const dateTo = document.getElementById('date_to').value;
                const searchValue = table.search();

                let url = '{{ route('export', ['modelType' => 'posts']) }}';
                url += '?export_type=pdf';
                let params = [];

                if (dateFrom) params.push('date_from=' + dateFrom);
                if (dateTo) params.push('date_to=' + dateTo);
                if (searchValue) params.push('search=' + encodeURIComponent(searchValue));

                if (params.length > 0) {
                    url += '&' + params.join('&');
                }

                console.log("url", url)

                window.location.href = url; // Trigger PDF export
            });
        });
    </script>
@stop
