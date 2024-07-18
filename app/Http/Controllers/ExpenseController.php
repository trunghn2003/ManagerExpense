<?php
namespace App\Http\Controllers;
use App\Services\Expenses\ExpenseServiceInterface;  
use App\Services\expenseCategories\ExpenseCategoryServiceInterface;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    protected $expenseService;
    protected $expenseCategoryService;

    public function __construct(ExpenseServiceInterface $expenseService,
                                ExpenseCategoryServiceInterface $expenseCategoryService)
    {
        $this->expenseService = $expenseService;
        $this->expenseCategoryService = $expenseCategoryService;
    }
   

    public function index(Request $request)
    {
        $filters = $request->only(['keyword', 'category', 'start_date', 'end_date', 'min_amount', 'max_amount']);
        $userId = Auth::id();
        $expenses = $this->expenseService->getAllExpenses($userId, $filters);
        $expenseCategories = $this->expenseCategoryService->getAllExpenseCategories($userId);

        return view('expenses.index', compact('expenses', 'expenseCategories'));
    }

    public function create()
    {
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

        $expenseCategory = $this->expenseCategoryService->getExpenseCategoryById($request->expense_category_id);
        if ($expenseCategory->user_id != Auth::id()) {
            return redirect()->route('expenses.index')->with('error', 'Unauthorized access.');
        }

        $this->expenseService->createExpense($request->all());

        return redirect()->route('expenses.index')->with('success', 'Expense created successfully.');
    }

    public function edit($id)
    {
        $expense = $this->expenseService->getExpenseById($id);
        if ($expense->expenseCategory->user_id != Auth::id()) {
            return redirect()->route('expenses.index')->with('error', 'Unauthorized access.');
        }

        $expenseCategories = ExpenseCategory::where('user_id', Auth::id())->get();
        return view('expenses.edit', compact('expense', 'expenseCategories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'expense_category_id' => 'required|exists:expense_categories,id',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $expenseCategory = $this->expenseCategoryService->getExpenseCategoryById($request->expense_category_id);
        if ($expenseCategory->user_id != Auth::id()) {
            return redirect()->route('expenses.index')->with('error', 'Unauthorized access.');
        }

        $this->expenseService->updateExpense($id, $request->all());

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
    }

    public function destroy($id)
    {
        $expense = $this->expenseService->getExpenseById($id);
        if ($expense->expenseCategory->user_id != Auth::id()) {
            return redirect()->route('expenses.index')->with('error', 'Unauthorized access.');
        }

        $this->expenseService->deleteExpense($id);
        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully.');
    }
}
