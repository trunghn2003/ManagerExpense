<?php

namespace App\Services\reports;

use App\Repositories\reports\ReportRepositoryInterface;
use App\Repositories\expenseCategories\ExpenseCategoryRepositoryInterface;
use App\Repositories\IncomeCategories\IncomeCategoryRepositoryInterface;
use App\Repositories\Expenses\ExpenseRepositoryInterface;
use App\Repositories\Incomes\IncomeRepositoryInterface;
use Carbon\Carbon;

class ReportService implements ReportServiceInterface
{
    protected $reportRepository;
    protected $expenseCategoryRepository;
    protected $incomeCategoryRepository;
    protected $expenseRepository;
    protected $incomeRepository;

    public function __construct(
        ReportRepositoryInterface $reportRepository,
        ExpenseCategoryRepositoryInterface $expenseCategoryRepository,
        IncomeCategoryRepositoryInterface $incomeCategoryRepository,
        ExpenseRepositoryInterface $expenseRepository,
        IncomeRepositoryInterface $incomeRepository
    ) {
        $this->reportRepository = $reportRepository;
        $this->expenseCategoryRepository = $expenseCategoryRepository;
        $this->incomeCategoryRepository = $incomeCategoryRepository;
        $this->expenseRepository = $expenseRepository;
        $this->incomeRepository = $incomeRepository;
    }

    public function generateReportContent($startDate, $endDate, $userId)
    {
        $expenseCategoryIds = $this->expenseCategoryRepository->getByUserId($userId)->toArray();
        $incomeCategoryIds = $this->incomeCategoryRepository->getByUserId($userId)->toArray();

        $expenses = $this->expenseRepository->getByCategoryIdsAndDateRange($expenseCategoryIds, $startDate, $endDate);
        $incomes = $this->incomeRepository->getByCategoryIdsAndDateRange($incomeCategoryIds, $startDate, $endDate);

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

        return view('reports.template', compact(
            'totalExpenses',
            'totalIncomes',
            'expensesByCategory',
            'incomesByCategory',
            'expenseCategoryNames',
            'incomeCategoryNames',
            'startDate',
            'endDate',
            'userId'
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
