<?php

namespace App\Http\Controllers;

use App\Services\Incomes\IncomeServiceInterface;
use App\Services\IncomeCategories\IncomeCategoryServiceInterface;
use App\Models\IncomeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    protected $incomeService;
    protected $incomeCategoryService;

    public function __construct(IncomeServiceInterface $incomeService,
                                IncomeCategoryServiceInterface $incomeCategoryService   )
    {
        $this->incomeService = $incomeService;
        $this->incomeCategoryService = $incomeCategoryService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['keyword', 'category', 'start_date', 'end_date', 'min_amount', 'max_amount']);
        $userId = Auth::id();
        $incomes = $this->incomeService->getAllIncomes($userId, $filters);
        $incomeCategories = $this->incomeCategoryService->getAllIncomeCategories($userId);
        // $incomeCategories = IncomeCategory::where('user_id', $userId)->get();

        return view('incomes.index', compact('incomes', 'incomeCategories'));
    }

    public function create()
    {
        // $incomeCategories = IncomeCategory::where('user_id', Auth::id())->get();
        $incomeCategories = $this->incomeCategoryService->getAllIncomeCategories(Auth::id());
        return view('incomes.create', compact('incomeCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'income_category_id' => 'required|exists:income_categories,id',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $this->incomeService->createIncome([
            'income_category_id' => $request->income_category_id,
            'amount' => $request->amount,
            'date' => $request->date,
            'description' => $request->description,
        ]);

        return redirect()->route('incomes.index')->with('success', 'Income created successfully.');
    }

    public function edit($id)
    {
        $income = $this->incomeService->getIncomeById($id);
        if ($income->incomeCategory->user_id != Auth::id()) {
            return redirect()->route('incomes.index')->with('error', 'Unauthorized access.');
        }

        $incomeCategories = IncomeCategory::where('user_id', Auth::id())->get();
        return view('incomes.edit', compact('income', 'incomeCategories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'income_category_id' => 'required|exists:income_categories,id',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

       
        $this->incomeService->updateIncome($id, [
            'income_category_id' => $request->income_category_id,
            'amount' => $request->amount,
            'date' => $request->date,
            'description' => $request->description,
        ]);

        return redirect()->route('incomes.index')->with('success', 'Income updated successfully.');
    }

    public function destroy($id)
    {
        $income = $this->incomeService->getIncomeById($id);
        if ($income->incomeCategory->user_id != Auth::id()) {
            return redirect()->route('incomes.index')->with('error', 'Unauthorized access.');
        }

        $this->incomeService->deleteIncome($id);
        return redirect()->route('incomes.index')->with('success', 'Income deleted successfully.');
    }
}
