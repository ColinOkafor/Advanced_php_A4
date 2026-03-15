@extends('layouts.app')
@section('title', 'Manage')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Manage Blog Articles</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- TOP SECTION: The single form handling both Publish and Save --}}
    <form action="/manage/process" method="POST" class="mb-4">
        @csrf
        
        <button type="submit" name="action" value="publish" class="btn btn-primary mb-3">Publish</button>

        <div class="mb-3">
            <label for="title" class="form-label">Article Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ session('draftTitle', '') }}">
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Article Content (HTML Allowed)</label>
            <textarea name="content" id="content" class="form-control" rows="8">{{ session('draftContent', '') }}</textarea>
        </div>

        <button type="submit" name="action" value="save" class="btn btn-secondary mb-3">Save</button>
    </form>

    @if(session()->has('snapshots') && count(session('snapshots')) > 0)
        <div class="mb-5 p-3 bg-light border rounded">
            <h5>Saved Snapshots:</h5>
            <ul class="list-unstyled mb-0">
                @foreach(session('snapshots') as $id => $snapshot)
                    <li class="mb-2">
                        <a href="/snapshot/load/{{ $id }}" class="text-decoration-none me-3">
                            {{ $snapshot['time'] }}
                        </a>
                        <a href="/snapshot/delete/{{ $id }}" style="color: red; font-weight: bold; text-decoration: none;" title="Delete Snapshot">
                            X
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <hr class="my-5">

    <h3 class="mb-3">Your Published Articles</h3>
    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>Title</th>
                <th>Date/Time</th>
                <th style="width: 100px; text-align: center;">Delete</th>
            </tr>
        </thead>
        <tbody>
            @forelse($userBlogs as $blog)
                <tr>
                    <td>{{ $blog->title }}</td>
                    <td>{{ $blog->created_at->format('Y-m-d g:ia') }}</td>
                    <td style="text-align: center;">
                        <form action="/delete/{{ $blog->id }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; padding: 0;" title="Delete Article">
                                <img src="{{ asset('images/delete.png') }}" alt="Delete" style="width: 24px; height: 24px;">
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">You haven't published any articles yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection