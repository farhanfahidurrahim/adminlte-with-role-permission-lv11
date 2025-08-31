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

    <div class="card shadow-sm">

        <div class="card-header bg-light border-bottom position-relative">
            <!-- Left: Card Title -->
            <h3 class="card-title mb-0 text-dark fw-bold">Posts Table</h3>

            <!-- Middle: Filters (centered) -->
            <div class="d-flex align-items-center gap-2 position-absolute" style="left: 50%; transform: translateX(-50%);">
                <input type="date" id="date_from" class="form-control form-control-sm" placeholder="From Date">
                <input type="date" id="date_to" class="form-control form-control-sm" placeholder="To Date">
                <button id="filter" class="btn btn-sm btn-primary rounded-pill px-3">Filter</button>
                <button id="reset" class="btn btn-sm btn-secondary rounded-pill px-3">Reset</button>
            </div>

            <!-- Right: Export Buttons (fixed right) -->
            <div class="d-flex gap-2 position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%);">
                <a href="#" class="btn btn-sm btn-outline-success rounded-pill px-3">
                    <i class="fas fa-file-excel mr-1"></i> Excel
                </a>
                <a href="#" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                    <i class="fas fa-file-pdf mr-1"></i> PDF
                </a>
            </div>
        </div>



        <div class="card-body">

            {{-- Yajra DataTable --}}
            <div class="table-responsive">
                <table id="yajraTable" class="table table-bordered table-hover table-striped align-middle" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">SL</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th>Updated By</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

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
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false,
                        className: 'text-center'
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
                        searchable: false,
                        className: 'text-center'
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
