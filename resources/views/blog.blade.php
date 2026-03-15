@extends('layouts.app')
@section('title', 'Blog')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-center">All Blog Articles</h1>

    @if($blogs->isEmpty())
        <div class="alert alert-info text-center">
            No blog articles have been published yet!
        </div>
    @else
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($blogs as $blog)
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h4 class="card-title mb-0">{{ $blog->title }}</h4>
                        </div>
                        <div class="card-body">
                            {{-- We use {!! !!} here to render the HTML tags exactly as the requirements asked --}}
                            <div class="card-text">
                                {!! $blog->content !!}
                            </div>
                        </div>
                        <div class="card-footer text-muted d-flex justify-content-between">
                            <span><strong>Author:</strong> {{ $blog->user->name }}</span>
                            <span><strong>Date:</strong> {{ $blog->created_at->format('F j, Y g:i a') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection