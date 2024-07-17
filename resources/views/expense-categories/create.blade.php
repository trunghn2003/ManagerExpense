@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Expense Category</h1>
    <form action="{{ route('expense-categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="user_id">User</label>
            <select class="form-control" id="user_id" name="user_id" disabled>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == Auth::id() ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
