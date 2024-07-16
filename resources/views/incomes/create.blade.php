@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Income</h1>
    <form action="{{ route('incomes.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="income_category_id">Category</label>
            <select class="form-control" id="income_category_id" name="income_category_id" required>
                @foreach($incomeCategories as $category)
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
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
