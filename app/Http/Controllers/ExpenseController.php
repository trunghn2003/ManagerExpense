<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\User;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with('expenseCategory', 'user')->get();
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        $users = User::all();
        $expenseCategories = ExpenseCategory::all();
        return view('expenses.create', compact('users', 'expenseCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'expense_category_id' => 'required|exists:expense_categories,id',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        Expense::create($request->all());

        return redirect()->route('expenses.index')->with('success', 'Expense created successfully.');
    }

    public function edit(Expense $expense)
    {
        $users = User::all();
        $expenseCategories = ExpenseCategory::all();
        return view('expenses.edit', compact('expense', 'users', 'expenseCategories'));
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'expense_category_id' => 'required|exists:expense_categories,id',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $expense->update($request->all());

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully.');
    }
}
