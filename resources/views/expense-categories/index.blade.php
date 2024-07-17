@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Expense Categories</h1>
            <a href="{{ route('expense-categories.create') }}" class="btn btn-primary">Add Expense Category</a>
        </div>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>User</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($expenseCategories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->user->name }}</td>
                        <td>
                            <a href="{{ route('expense-categories.edit', $category->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('expense-categories.destroy', $category->id) }}" method="POST"
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
        {{ $expenseCategories->links() }}
    </div>
@endsection
