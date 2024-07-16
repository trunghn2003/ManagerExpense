@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Incomes</h1>
    <a href="{{ route('incomes.create') }}" class="btn btn-primary">Add Income</a>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Category</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($incomes as $income)
                <tr>
                    <td>{{ $income->id }}</td>
                    <td>{{ $income->incomeCategory->name }}</td>
                    <td>{{ $income->amount }}</td>
                    <td>{{ $income->date }}</td>
                    <td>
                        <a href="{{ route('incomes.edit', $income->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('incomes.destroy', $income->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
