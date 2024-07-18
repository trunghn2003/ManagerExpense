<?php
namespace App\Services\reports;

use App\Repositories\reports\ReportRepositoryInterface;
use Carbon\Carbon;
use App\Models\Expense;
use App\Models\Income;
use App\Models\ExpenseCategory;
use App\Models\IncomeCategory;

class ReportService implements ReportServiceInterface
{
    protected $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function generateReportContent($startDate, $endDate, $userId)
    {
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

        return view('reports.template', compact(
            'totalExpenses',
            'totalIncomes',
            'expensesByCategory',
            'incomesByCategory',
            'expenseCategoryNames',
            'incomeCategoryNames',
            'startDate',
            'endDate'
            ,'userId'
        ))->render();
    }

    public function createReport(array $data)
    {
        return $this->reportRepository->create($data);
    }

    public function updateReport($id, array $data)
    {
        return $this->reportRepository->update($id, $data);
    }

    public function deleteReport($id)
    {
        return $this->reportRepository->delete($id);
    }

    public function getReportById($id)
    {
        return $this->reportRepository->find($id);
    }

    public function getAllReports()
    {
        return $this->reportRepository->all();
    }
}
