<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use App\Models\ExpenseCategory;
use App\Models\IncomeCategory;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::where('user_id', Auth::id())->orWhere('is_public', true)->paginate(10);
        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        return view('reports.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_public' => 'boolean',
        ]);

        $userId = Auth::id();
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

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

        // Generate the report content using a Blade view
        $reportContent = view('reports.template', compact(
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

        $isPublic = $request->has('is_public') ? (bool)$request->is_public : false;

        Report::create([
            'user_id' => $userId,
            'title' => $request->title,
            'content' => $reportContent,
            'is_public' => $isPublic,
        ]);

        return redirect()->route('reports.index')->with('success', 'Report created successfully.');
    }

    public function edit(Report $report)
    {
        if ($report->user_id != Auth::id()) {
            return redirect()->route('reports.index')->with('error', 'Unauthorized access.');
        }

        return view('reports.edit', compact('report'));
    }

    public function update(Request $request, Report $report)
    {
        if ($report->user_id != Auth::id()) {
            return redirect()->route('reports.index')->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'is_public' => 'boolean',
        ]);

        $isPublic = $request->has('is_public') ? (bool)$request->is_public : false;

        $report->update([
            'title' => $request->title,
            'is_public' => $isPublic,
        ]);

        return redirect()->route('reports.index')->with('success', 'Report updated successfully.');
    }


    public function show(Report $report)
    {
        if (!$report->is_public && $report->user_id != Auth::id()) {
            return redirect()->route('reports.index')->with('error', 'Unauthorized access.');
        }

        return view('reports.show', compact('report'));
    }
}
