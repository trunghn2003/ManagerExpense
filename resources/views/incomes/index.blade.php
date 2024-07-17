@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Incomes</h1>
        <a href="{{ route('incomes.create') }}" class="btn btn-primary">Add Income</a>
    </div>


    <form action="{{ route('incomes.index') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="keyword" class="form-control" placeholder="Search..." value="{{ request('keyword') }}">
            </div>
            <div class="col-md-3">
                <select name="category" class="form-control">
                    <option value="">All Categories</option>
                    @foreach($incomeCategories as $category)
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
                <a href="{{ route('incomes.index') }}" class="btn btn-secondary">Clear</a>
            </div>
        </div>
    </form>

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
