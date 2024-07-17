@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Expenses</h1>
            <a href="{{ route('expenses.create') }}" class="btn btn-primary">Add Expense</a>
        </div>
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
