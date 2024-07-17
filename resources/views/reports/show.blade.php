@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="h3">{{ $report->title }}</h1>
    <div>{!! $report->content !!}</div>
    <p><strong>Public:</strong> {{ $report->is_public ? 'Yes' : 'No' }}</p>
</div>
@endsection
