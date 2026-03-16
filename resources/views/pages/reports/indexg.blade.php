@extends('adminlte::page')

@section('title', 'Master Report Page || All in one')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>📊 Master Report Template</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Master Report</li>
            </ol>
        </nav>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card card-default accordion" id="filterAccordion">
            <div class="card-header" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="true" style="cursor: pointer;">
                <h3 class="card-title"><i class="fas fa-filter mr-2"></i> Advanced Filters</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool"><i class="fas fa-chevron-down"></i></button>
                </div>
            </div>
            <div id="collapseFilter" class="collapse show" data-parent="#filterAccordion">
                <div class="card-body">
                    <form id="filterForm">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Date Range:</label>
                                <div class="input-group">
                                    <input type="date" id="from_date" class="form-control form-control-sm">
                                    <div class="input-group-append"><span class="input-group-text">to</span></div>
                                    <input type="date" id="to_date" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label>Status:</label>
                                <select id="status" class="form-control form-control-sm select2">
                                    <option value="">All Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Category:</label>
                                <select id="category" class="form-control form-control-sm select2">
                                    <option value="">All Category</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Keyword Search:</label>
                                <input type="text" id="keyword" class="form-control form-control-sm" placeholder="Search anything...">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" id="searchBtn" class="btn btn-primary btn-sm mr-2 px-3">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                <button type="button" id="resetBtn" class="btn btn-secondary btn-sm px-3">
                                    <i class="fas fa-undo"></i> Reset
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Report Data</h3>
                <div class="card-tools">
                    <button type="button" id="reloadBtn" class="btn btn-tool" title="Reload Data">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="reportTable" class="table table-bordered table-striped table-hover nowrap w-100">
                        <thead class="bg-light text-primary">
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        /* Sticky Header for Tables */
        thead th { position: sticky; top: 0; z-index: 10; background: #f4f6f9; }
        .dataTables_processing { background: rgba(255, 255, 255, 0.8) !important; color: #007bff !important; font-weight: bold; }
        .table-hover tbody tr:hover { background-color: #f1f7ff !important; transition: 0.3s; }
    </style>
@stop

@section('js')
    <script>
        $(function () {
            // 1. DataTable Initialization
            let table = $('#reportTable').DataTable({
                processing: true,
                serverSide: true, // Yajra Power
                responsive: true,
                autoWidth: false,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                ajax: {
                    url: "{{ route('reports.index') }}",
                    data: function (d) {
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                        d.status = $('#status').val();
                        d.category = $('#category').val();
                        d.keyword = $('#keyword').val();
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'date', name: 'date'},
                    {data: 'name', name: 'name'},
                    {data: 'category', name: 'category'},
                    {data: 'status', name: 'status', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                dom: '<"row mb-3"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                buttons: [
                    { extend: 'copy', className: 'btn btn-sm btn-outline-secondary' },
                    { extend: 'csv', className: 'btn btn-sm btn-outline-info' },
                    { extend: 'excel', className: 'btn btn-sm btn-outline-success', title: 'Report Excel' },
                    { extend: 'pdf', className: 'btn btn-sm btn-outline-danger' },
                    { extend: 'print', className: 'btn btn-sm btn-outline-dark' },
                    { extend: 'colvis', className: 'btn btn-sm btn-outline-primary', text: 'Columns' }
                ]
            });

            // 2. Filter Action
            $('#searchBtn').click(function(){
                table.draw();
            });

            // 3. Reset Action
            $('#resetBtn').click(function(){
                $('#filterForm')[0].reset();
                $('.select2').val('').trigger('change');
                table.draw();
            });

            // 4. Reload Action
            $('#reloadBtn').click(function(){
                table.ajax.reload(null, false);
            });
        });
    </script>
@stop
