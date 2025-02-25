@extends('adminlte::page')

@section('title', 'Edit | Role')

@section('content_header')
    <h1>Role Edit</h1>
@stop

@section('content')

    <div class="card">
        <div class="card-body">
            <form action="{{ route('roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Role Name</label>
                    <input type="text" name="name" value="{{ old('name', $role->name) }}" id="name" class="form-control" placeholder="Enter name">
                    @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name')  }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="permissions">Assign Permissions</label>
                    <div class="d-flex flex-column">
                        @foreach($permissionsByGroup as $group => $permissions)
                            <div class="permission-group">
                                <h4>{{ ucfirst($group) }} Permissions</h4> <!-- Display Module Name -->
                                @foreach($permissions as $permission)
                                    <div class="form-check">
                                        <input type="checkbox"
                                               name="permissions[]"
                                               value="{{ $permission->name }}"
                                               class="form-check-input"
                                            {{ in_array($permission->name, old('permissions', $role->permissions->pluck('name')->toArray())) ? 'checked' : '' }}>
                                        <label class="form-check-label">{{ $permission->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                    @error('permissions')
                    <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
