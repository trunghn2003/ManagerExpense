<?php

namespace App\Repositories\Statistics;

use App\Models\Expense;
use App\Models\Income;
use Illuminate\Support\Facades\Auth;
use App\Models\ExpenseCategory;
use App\Models\IncomeCategory;
class StatisticsRepository implements StatisticsRepositoryInterface
{
    public function getExpensesByUserAndDateRange($userId, $startDate, $endDate)
    {
        $expenseCategoryIds = ExpenseCategory::where('user_id', $userId)->pluck('id');
        return Expense::whereIn('expense_category_id', $expenseCategoryIds)
                        ->whereBetween('date', [$startDate, $endDate])
                        ->get();
    }

    public function getIncomesByUserAndDateRange($userId, $startDate, $endDate)
    {
        $incomeCategoryIds = IncomeCategory::where('user_id', $userId)->pluck('id');
        return Income::whereIn('income_category_id', $incomeCategoryIds)
                      ->whereBetween('date', [$startDate, $endDate])
                      ->get();
    }
}
