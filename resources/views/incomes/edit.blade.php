@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Income</h1>
    <form action="{{ route('incomes.update', $income->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="income_category_id">Category</label>
            <select class="form-control" id="income_category_id" name="income_category_id" required>
                @foreach($incomeCategories as $category)
                    <option value="{{ $category->id }}" {{ $income->income_category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="{{ $income->amount }}" required>
        </div>
        <button type="submit" class="btn btn
