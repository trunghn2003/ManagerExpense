@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Expenses</h1>
            <a href="{{ route('expenses.create') }}" class="btn btn-primary">Add Expense</a>
        </div>
        
        <form action="{{ route('expenses.index') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="keyword" class="form-control" placeholder="Search..." value="{{ request('keyword') }}">
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-control">
                        <option value="">All Categories</option>
                        @foreach($expenseCategories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" name="start_date" class="form-control" placeholder="Start Date" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3">
                    <input type="date" name="end_date" class="form-control" placeholder="End Date" value="{{ request('end_date') }}">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-3">
                    <input type="number" name="min_amount" class="form-control" placeholder="Min Amount" value="{{ request('min_amount') }}">
                </div>
                <div class="col-md-3">
                    <input type="number" name="max_amount" class="form-control" placeholder="Max Amount" value="{{ request('max_amount') }}">
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Clear</a>
                </div>
            </div>
        </form>

        <table class="table mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Amount</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($expenses as $expense)
                    <tr>
                        <td>{{ $expense->id }}</td>
                        <td>{{ $expense->amount }}</td>
                        <td>{{ $expense->expenseCategory->name }}</td>
                        <td>{{ $expense->date }}</td>
                        <td>{{ $expense->description }}</td>
                        <td>
                            <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $expenses->links() }}
    </div>
@endsection
