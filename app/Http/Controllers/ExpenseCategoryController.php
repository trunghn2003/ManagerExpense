<?php

namespace App\Http\Controllers;

use App\Services\expenseCategories\ExpenseCategoryServiceInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseCategoryController extends Controller
{
    protected $expenseCategoryService;

    public function __construct(ExpenseCategoryServiceInterface $expenseCategoryService)
    {
        $this->expenseCategoryService = $expenseCategoryService;
    }

    public function index()
    {
        $userId = Auth::id();
        $expenseCategories = $this->expenseCategoryService->getAllExpenseCategories($userId);
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

        $this->expenseCategoryService->createExpenseCategory($request->all());

        return redirect()->route('expense-categories.index')->with('success', 'Expense category created successfully.');
    }

    public function edit($id)
    {
        $expenseCategory = $this->expenseCategoryService->getExpenseCategoryById($id);
        $users = User::all();
        return view('expense-categories.edit', compact('expenseCategory', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        $this->expenseCategoryService->updateExpenseCategory($id, $request->all());

        return redirect()->route('expense-categories.index')->with('success', 'Expense category updated successfully.');
    }

    public function destroy($id)
    {
        $this->expenseCategoryService->deleteExpenseCategory($id);
        return redirect()->route('expense-categories.index')->with('success', 'Expense category deleted successfully.');
    }
}
