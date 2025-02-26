@extends('adminlte::page')

@section('title', 'View | Post')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Post | Details</h1>
        <a href="{{ route('posts.index') }}" class="btn btn-info">Back</a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <h3>{{ $post->name }}</h3>
            <p><strong>Category:</strong> {{ $post->category ? $post->category->name : 'N/A' }}</p>
            <p><strong>Status:</strong> {{ $post->status }}</p>
            <p><strong>Created By:</strong> {{ $post->createdBy ? $post->createdBy->name : 'N/A' }}</p>
            <p><strong>Updated By:</strong> {{ $post->updatedBy ? $post->updatedBy->name : 'N/A' }}</p>

            <a href="{{ route('posts.index') }}" class="btn btn-info">Back to List</a>
        </div>
    </div>
@stop
