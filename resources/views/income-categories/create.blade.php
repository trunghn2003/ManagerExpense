@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Income Category</h1>
    <form action="{{ route('income-categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="user_id">User</label>
            <input type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" required readonly>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
