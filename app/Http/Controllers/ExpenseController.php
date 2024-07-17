<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::whereHas('expenseCategory', function ($query) {
            $query->where('user_id', Auth::id());
        });

        if ($request->filled('keyword')) {
            $query->where(function($q) use ($request) {
                $q->where('description', 'like', '%' . $request->keyword . '%')
                  ->orWhereHas('expenseCategory', function ($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->keyword . '%');
                  });
            });
        }

        if ($request->filled('category')) {
            $query->where('expense_category_id', $request->category);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        if ($request->filled('min_amount')) {
            $query->where('amount', '>=', $request->min_amount);
        }

        if ($request->filled('max_amount')) {
            $query->where('amount', '<=', $request->max_amount);
        }

        $expenses = $query->paginate(10);
        $expenseCategories = ExpenseCategory::where('user_id', Auth::id())->get();

        return view('expenses.index', compact('expenses', 'expenseCategories'));
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
