<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        // Retrieve expense categories that belong to the logged-in user
        $expenseCategories = ExpenseCategory::where('user_id', Auth::id())->pluck('id');

        // Retrieve expenses that belong to those categories
        $expenses = Expense::whereIn('expense_category_id', $expenseCategories)->paginate(10);

        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        // Retrieve expense categories that belong to the logged-in user
        $expenseCategories = ExpenseCategory::where('user_id', Auth::id())->get();

        return view('expenses.create', compact('expenseCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'expense_category_id' => 'required|exists:expense_categories,id',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        // Ensure the expense category belongs to the logged-in user
        $expenseCategory = ExpenseCategory::find($request->expense_category_id);
        if ($expenseCategory->user_id != Auth::id()) {
            return redirect()->route('expenses.index')->with('error', 'Unauthorized access.');
        }

        Expense::create($request->all());

        return redirect()->route('expenses.index')->with('success', 'Expense created successfully.');
    }

    public function edit(Expense $expense)
    {
        // Ensure the expense belongs to a category that belongs to the logged-in user
        if ($expense->expenseCategory->user_id != Auth::id()) {
            return redirect()->route('expenses.index')->with('error', 'Unauthorized access.');
        }

        // Retrieve expense categories that belong to the logged-in user
        $expenseCategories = ExpenseCategory::where('user_id', Auth::id())->get();

        return view('expenses.edit', compact('expense', 'expenseCategories'));
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'expense_category_id' => 'required|exists:expense_categories,id',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        // Ensure the expense category belongs to the logged-in user
        $expenseCategory = ExpenseCategory::find($request->expense_category_id);
        if ($expenseCategory->user_id != Auth::id()) {
            return redirect()->route('expenses.index')->with('error', 'Unauthorized access.');
        }

        $expense->update($request->all());

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
    }

    public function destroy(Expense $expense)
    {
        // Ensure the expense belongs to a category that belongs to the logged-in user
        if ($expense->expenseCategory->user_id != Auth::id()) {
            return redirect()->route('expenses.index')->with('error', 'Unauthorized access.');
        }

        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully.');
    }
}
