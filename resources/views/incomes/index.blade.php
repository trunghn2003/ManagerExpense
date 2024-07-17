@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Incomes</h1>
        <a href="{{ route('incomes.create') }}" class="btn btn-primary">Add Income</a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Category</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Date</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($incomes as $income)
                    <tr>
                        <td>{{ $income->id }}</td>
                        <td>{{ $income->incomeCategory->name }}</td>
                        <td>{{ $income->amount }}</td>
                        <td>{{ $income->date }}</td>
                        <td>{{ $income->description }}</td>
                        <td>
                            <a href="{{ route('incomes.edit', $income->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('incomes.destroy', $income->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $incomes->links() }}
</div>
@endsection
