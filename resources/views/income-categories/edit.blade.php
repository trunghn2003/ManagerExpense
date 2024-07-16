@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Income Category</h1>
    <form action="{{ route('income-categories.update', $incomeCategory->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $incomeCategory->name }}" required>
        </div>
        <div class="form-group">
            <label for="user_id">User</label>
            <select class="form-control" id="user_id" name="user_id" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $incomeCategory->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
