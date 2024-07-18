@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Reports</h1>
        <a href="{{ route('reports.create') }}" class="btn btn-primary">Create Report</a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Title</th>
                    <th scope="col">Public</th>
                    <th scope="col">UserId</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $report)
                    <tr>
                        <td>{{ $report->id }}</td>
                        <td>{{ $report->title }}</td>
                        <td>{{ $report->is_public ? 'Yes' : 'No' }}</td>
                        <td>{{ $report->user_id }}</td>
                        <td>
                            <a href="{{ route('reports.show', $report->id) }}" class="btn btn-primary btn-sm">View</a>
                            @if ($report->user_id == Auth::id())
                                <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('reports.destroy', $report->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $reports->links() }}
</div>
@endsection
