@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Expense</h1>
    <form action="{{ route('expenses.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="expense_category_id">Category</label>
            <select class="form-control" id="expense_category_id" name="expense_category_id" required>
                @foreach($expenseCategories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
