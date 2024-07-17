@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Expense Category</h1>
    <form action="{{ route('expense-categories.update', $expenseCategory->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $expenseCategory->name }}" required>
        </div>
        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
