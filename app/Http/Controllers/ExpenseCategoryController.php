<?php
namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $expenseCategories = ExpenseCategory::where('user_id', Auth::id())->paginate(10);
        return view('expense-categories.index', compact('expenseCategories'));
    }

    public function create()
    {
        $users = User::all();
        return view('expense-categories.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        ExpenseCategory::create($request->all());

        return redirect()->route('expense-categories.index')->with('success', 'Expense category created successfully.');
    }

    public function edit(ExpenseCategory $expenseCategory)
    {
        $users = User::all();
        return view('expense-categories.edit', compact('expenseCategory', 'users'));
    }

    public function update(Request $request, ExpenseCategory $expenseCategory)
    {
        $request->validate([
            'name' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        $expenseCategory->update($request->all());

        return redirect()->route('expense-categories.index')->with('success', 'Expense category updated successfully.');
    }

    public function destroy(ExpenseCategory $expenseCategory)
    {
        $expenseCategory->delete();
        return redirect()->route('expense-categories.index')->with('success', 'Expense category deleted successfully.');
    }
}
