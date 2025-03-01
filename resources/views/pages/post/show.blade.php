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
            <span>
                <img src="{{ $post->image ? asset('storage/images/post/' . $post->image) : asset('storage/images/no-image.png') }}" alt="Post Image" width="150" height="100">
            </span>
            <span>
                @if($post->document)
                    <a href="{{ asset('storage/documents/post/' . $post->document) }}" >View Document</a>
                @else
                    <p>No document available</p>
                @endif
            </span>
            <h3>{{ $post->name }}</h3>
            <p><strong>Category:</strong> {{ $post->category ? $post->category->name : 'N/A' }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($post->date)->format('d M Y') }}</p>
            <p><strong>Status:</strong> {{ $post->status }}</p>
            <p><strong>Created By:</strong> {{ $post->createdBy ? $post->createdBy->name : 'N/A' }}</p>
            <p><strong>Updated By:</strong> {{ $post->updatedBy ? $post->updatedBy->name : 'N/A' }}</p>
            <p><strong>Created At:</strong> {{ $post->created_at ? $post->created_at->format('Y-m-d h:i A') : 'N/A' }}</p>
            <p><strong>Updated At:</strong> {{ $post->updated_at ? $post->updated_at->format('Y-m-d h:i A') : 'N/A' }}</p>

            <a href="{{ route('posts.index') }}" class="btn btn-info">Back to List</a>
        </div>
    </div>
@stop
