@extends('adminlte::page')

@section('title', 'JQuery | DataTable')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Index JQuery</h1>
        <a href="" class="btn btn-primary btn-sm shadow-sm rounded-pill px-3 py-2">
            <i class="fas fa-plus-circle mr-1"></i> Add New
        </a>
    </div>
@stop

@section('content')

    <div class="card shadow-sm">
        <div class="card-header bg-light border-bottom d-flex align-items-center">
            <h3 class="card-title mb-0 text-dark fw-bold flex-grow-1">Users Table</h3>
            <div class="d-flex gap-2">
                <a href="#" class="btn btn-sm btn-outline-success rounded-pill px-3">
                    <i class="fas fa-file-excel me-1"></i> Excel
                </a>
                <a href="#" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                    <i class="fas fa-file-pdf me-1"></i> PDF
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="users-table" class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                    <tr>
                        <th class="text-center">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created At</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="text-center">1</td>
                        <td>John Doe</td>
                        <td>john@example.com</td>
                        <td><span class="badge bg-success">Admin</span></td>
                        <td>2025-08-31</td>
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-warning text-white rounded-pill px-3" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-info text-white rounded-pill px-3" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-danger rounded-pill px-3" title="Delete">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">2</td>
                        <td>Jane Smith</td>
                        <td>jane@example.com</td>
                        <td><span class="badge bg-secondary">User</span></td>
                        <td>2025-08-30</td>
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-warning text-white px-3" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-info px-3" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-danger px-3" title="Delete">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">3</td>
                        <td>Michael Lee</td>
                        <td>michael@example.com</td>
                        <td><span class="badge bg-warning text-dark">Editor</span></td>
                        <td>2025-08-29</td>
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-warning text-white rounded-pill px-3">Edit</a>
                            <a href="#" class="btn btn-sm btn-info text-white rounded-pill px-3">View</a>
                            <a href="#" class="btn btn-sm btn-danger rounded-pill px-3">Delete</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#users-table').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50],
                columnDefs: [
                    { orderable: false, targets: 5 } // Disable sorting on Action column
                ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search..."
                }
            });
        });
    </script>
@stop
