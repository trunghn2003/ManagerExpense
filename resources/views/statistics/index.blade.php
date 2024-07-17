@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Statistics for {{ \Carbon\Carbon::parse($startDate)->format('F Y') }}</h1>

    <form method="GET" action="{{ route('statistics.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label for="start_date">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="col-md-4">
                <label for="end_date">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            <div class="col-md-4">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary form-control">Filter</button>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-md-6">
            <h2>Total</h2>
            <p>Total Expenses: <span style="color: red;">-{{ $totalExpenses }}đ</span></p>
            <p>Total Incomes: <span style="color: green;">+{{ $totalIncomes }}đ</span></p>
            <p>Net Balance: <span style="color: {{ $totalIncomes - $totalExpenses >= 0 ? 'green' : 'red' }};">{{ $totalIncomes - $totalExpenses }}đ</span></p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h2>Expenses by Category</h2>
            <ul class="list-group">
                @foreach($expensesByCategory as $categoryId => $amount)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $expenseCategoryNames[$categoryId] ?? 'Unknown Category' }}
                        <span class="badge bg-danger rounded-pill">-{{ $amount }}đ</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="col-md-6">
            <h2>Incomes by Category</h2>
            <ul class="list-group">
                @foreach($incomesByCategory as $categoryId => $amount)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $incomeCategoryNames[$categoryId] ?? 'Unknown Category' }}
                        <span class="badge bg-success rounded-pill">+{{ $amount }}đ</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
