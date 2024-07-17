<?php
namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use App\Models\ExpenseCategory;
use App\Models\IncomeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

       
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        
        $startDate = $request->input('start_date', $startOfMonth->toDateString());
        $endDate = $request->input('end_date', $endOfMonth->toDateString());

       
        $expenseCategoryIds = ExpenseCategory::where('user_id', $userId)->pluck('id');

        
        $incomeCategoryIds = IncomeCategory::where('user_id', $userId)->pluck('id');

      
        $expenses = Expense::whereIn('expense_category_id', $expenseCategoryIds)
                            ->whereBetween('date', [$startDate, $endDate])
                            ->get();

        $incomes = Income::whereIn('income_category_id', $incomeCategoryIds)
                          ->whereBetween('date', [$startDate, $endDate])
                          ->get();

      
        $totalExpenses = $expenses->sum('amount');
        $totalIncomes = $incomes->sum('amount');

       
        $expensesByCategory = $expenses->groupBy('expense_category_id')->map(function ($row) {
            return $row->sum('amount');
        });

        $incomesByCategory = $incomes->groupBy('income_category_id')->map(function ($row) {
            return $row->sum('amount');
        });

        
        $expenseCategoryNames = ExpenseCategory::whereIn('id', $expensesByCategory->keys())->pluck('name', 'id');
        $incomeCategoryNames = IncomeCategory::whereIn('id', $incomesByCategory->keys())->pluck('name', 'id');

        return view('statistics.index', compact('totalExpenses', 'totalIncomes', 'expensesByCategory', 'incomesByCategory', 'expenseCategoryNames', 'incomeCategoryNames', 'startDate', 'endDate'));
    }
}
