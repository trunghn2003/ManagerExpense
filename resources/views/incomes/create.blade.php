@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Create Income</h1>
    <form action="{{ route('incomes.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="income_category_id" class="form-label">Category</label>
            <select class="form-select" id="income_category_id" name="income_category_id" required>
                @foreach($incomeCategories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
