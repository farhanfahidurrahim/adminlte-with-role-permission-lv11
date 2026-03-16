@extends('adminlte::page')

@section('title', 'Master Report Page')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Master Report Page</h1>

        <button class="btn btn-primary btn-sm" id="reloadTable">
            <i class="fas fa-sync"></i> Reload
        </button>
    </div>
@stop


@section('content')

    <div class="card shadow-sm">

        <div class="card-header bg-light">
            <strong>Filters</strong>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-2">
                    <label>Start Date</label>
                    <input type="date" id="start_date" class="form-control">
                </div>

                <div class="col-md-2">
                    <label>End Date</label>
                    <input type="date" id="end_date" class="form-control">
                </div>

                <div class="col-md-2">
                    <label>Status</label>
                    <select id="status" class="form-control">
                        <option value="">All</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Search</label>
                    <input type="text" id="keyword" class="form-control" placeholder="Search...">
                </div>

                <div class="col-md-3 d-flex align-items-end">

                    <button class="btn btn-success mr-2" id="filter">
                        <i class="fas fa-search"></i> Search
                    </button>

                    <button class="btn btn-secondary" id="reset">
                        Reset
                    </button>

                </div>

            </div>

        </div>

    </div>


    <div class="card">

        <div class="card-body">

            <table id="reportTable" class="table table-bordered table-striped table-hover">

                <thead class="thead-dark">

                <tr>
                    <th width="50">SL</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th width="120">Action</th>
                </tr>

                </thead>

            </table>

        </div>
    </div>

@stop


@section('js')

    <script>

        $(function () {

            let table = $('#reportTable').DataTable({

                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth:false,

                ajax: {

                    url: "{{ route('reports.index') }}",

                    data: function (d) {

                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                        d.status = $('#status').val();
                        d.keyword = $('#keyword').val();

                    }

                },

                dom: 'Bfrtip',

                buttons: [

                    {
                        extend:'copy',
                        className:'btn btn-sm btn-secondary'
                    },

                    {
                        extend:'excel',
                        className:'btn btn-sm btn-success'
                    },

                    {
                        extend:'csv',
                        className:'btn btn-sm btn-info'
                    },

                    {
                        extend:'pdf',
                        className:'btn btn-sm btn-danger'
                    },

                    {
                        extend:'print',
                        className:'btn btn-sm btn-primary'
                    },

                    {
                        extend:'colvis',
                        className:'btn btn-sm btn-dark'
                    }

                ],

                columns: [

                    {data:'DT_RowIndex', name:'DT_RowIndex', orderable:false, searchable:false},

                    {data:'name', name:'name'},

                    {data:'category', name:'category'},

                    {data:'price', name:'price'},

                    {data:'status', name:'status'},

                    {data:'created_at', name:'created_at'},

                    {data:'action', name:'action', orderable:false, searchable:false}

                ]

            });



            $('#filter').click(function(){

                table.draw();

            });


            $('#reset').click(function(){

                $('#start_date').val('');
                $('#end_date').val('');
                $('#status').val('');
                $('#keyword').val('');

                table.draw();

            });


            $('#reloadTable').click(function(){

                table.ajax.reload();

            });


        });

    </script>

@stop
