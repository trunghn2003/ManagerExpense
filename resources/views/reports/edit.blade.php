@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="h3">Edit Report</h1>

    <form action="{{ route('reports.update', $report->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $report->title }}" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_public" name="is_public" value="1" {{ $report->is_public ? 'checked' : '' }}>
            <label class="form-check-label" for="is_public">Make Public</label>
        </div>

        <button type="submit" class="btn btn-primary">Update Report</button>
    </form>
</div>
@endsection
