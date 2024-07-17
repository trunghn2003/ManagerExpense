@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Income Categories</h1>
    <a href="{{ route('income-categories.create') }}" class="btn btn-primary">Add Income Category</a>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($incomeCategories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <a href="{{ route('income-categories.edit', $category->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('income-categories.destroy', $category->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{  $incomeCategories->links() }}

</div>
@endsection
