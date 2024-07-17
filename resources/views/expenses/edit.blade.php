@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Expense</h1>
    <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="expense_category_id">Category</label>
            <select class="form-control" id="expense_category_id" name="expense_category_id" required>
                @foreach($expenseCategories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == $expense->expense_category_id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="{{ $expense->amount }}" required>
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ $expense->date }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
