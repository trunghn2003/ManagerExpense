<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\reports\ReportRepository;
use App\Repositories\reports\ReportRepositoryInterface;
use App\Services\reports\ReportService;
use App\Services\reports\ReportServiceInterface;
use App\Repositories\expenseCategories\ExpenseCategoryRepository;
use App\Repositories\expenseCategories\ExpenseCategoryRepositoryInterface;
use App\Services\expenseCategories\ExpenseCategoryService;
use App\Services\expenseCategories\ExpenseCategoryServiceInterface;
use App\Repositories\Expenses\ExpenseRepository;
use App\Repositories\Expenses\ExpenseRepositoryInterface;
use App\Services\Expenses\ExpenseService;
use App\Services\Expenses\ExpenseServiceInterface;
use App\Repositories\IncomeCategories\IncomeCategoryRepository;
use App\Repositories\IncomeCategories\IncomeCategoryRepositoryInterface;
use App\Services\IncomeCategories\IncomeCategoryService;
use App\Services\IncomeCategories\IncomeCategoryServiceInterface;
use App\Repositories\Incomes\IncomeRepository;
use App\Repositories\Incomes\IncomeRepositoryInterface;
use App\Services\Incomes\IncomeService;
use App\Services\Incomes\IncomeServiceInterface;
use App\Repositories\Statistics\StatisticsRepository;
use App\Repositories\Statistics\StatisticsRepositoryInterface;
use App\Services\Statistics\StatisticsService;
use App\Services\Statistics\StatisticsServiceInterface;
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->bind(ReportRepositoryInterface::class, ReportRepository::class);
        $this->app->bind(ReportServiceInterface::class, ReportService::class);

        $this->app->bind(ExpenseCategoryRepositoryInterface::class, ExpenseCategoryRepository::class);
        $this->app->bind(ExpenseCategoryServiceInterface::class, ExpenseCategoryService::class);

        $this->app->bind(ExpenseRepositoryInterface::class, ExpenseRepository::class);
        $this->app->bind(ExpenseServiceInterface::class, ExpenseService::class);

        $this->app->bind(IncomeCategoryRepositoryInterface::class, IncomeCategoryRepository::class);
        $this->app->bind(IncomeCategoryServiceInterface::class, IncomeCategoryService::class);

        $this->app->bind(IncomeRepositoryInterface::class, IncomeRepository::class);
        $this->app->bind(IncomeServiceInterface::class, IncomeService::class);

        $this->app->bind(StatisticsRepositoryInterface::class, StatisticsRepository::class);
        $this->app->bind(StatisticsServiceInterface::class, StatisticsService::class);

        
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
