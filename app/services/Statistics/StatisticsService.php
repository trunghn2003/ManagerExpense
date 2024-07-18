<?php
namespace App\Services\Statistics;

use App\Repositories\Statistics\StatisticsRepositoryInterface;
use App\Repositories\expenseCategories\ExpenseCategoryRepositoryInterface;
use App\Repositories\IncomeCategories\IncomeCategoryRepositoryInterface;
use App\Models\ExpenseCategory;
use App\Models\Income;
use App\Models\IncomeCategory;
use Illuminate\Validation\Rules\In;

class StatisticsService implements StatisticsServiceInterface
{
    protected $statisticsRepository;
    protected $expenseCategoryRepository;
    protected $incomeCategoryRepository;

    public function __construct(StatisticsRepositoryInterface $statisticsRepository,
                                ExpenseCategoryRepositoryInterface $expenseCategoryRepository,
                                IncomeCategoryRepositoryInterface $incomeCategoryRepository
    )
    {
        $this->statisticsRepository = $statisticsRepository;
        $this->expenseCategoryRepository = $expenseCategoryRepository;
        $this->incomeCategoryRepository = $incomeCategoryRepository;
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
        $expenseCategoryNames = $this->expenseCategoryRepository->getByIds($expensesByCategory->keys()->toArray());
        $incomeCategoryNames = $this->incomeCategoryRepository->getByIds($incomesByCategory->keys()->toArray());

        return compact('totalExpenses', 'totalIncomes', 'expensesByCategory', 'incomesByCategory', 'expenseCategoryNames', 'incomeCategoryNames');
    }
}
