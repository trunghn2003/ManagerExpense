<?php
namespace App\Services\Statistics;

use App\Repositories\Statistics\StatisticsRepositoryInterface;
use App\Models\ExpenseCategory;
use App\Models\IncomeCategory;

class StatisticsService implements StatisticsServiceInterface
{
    protected $statisticsRepository;

    public function __construct(StatisticsRepositoryInterface $statisticsRepository)
    {
        $this->statisticsRepository = $statisticsRepository;
    }

    public function getStatistics($userId, $startDate, $endDate)
    {
        $expenses = $this->statisticsRepository->getExpensesByUserAndDateRange($userId, $startDate, $endDate);
        $incomes = $this->statisticsRepository->getIncomesByUserAndDateRange($userId, $startDate, $endDate);

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

        return compact('totalExpenses', 'totalIncomes', 'expensesByCategory', 'incomesByCategory', 'expenseCategoryNames', 'incomeCategoryNames');
    }
}
