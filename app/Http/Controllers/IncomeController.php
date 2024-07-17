<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\IncomeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    public function index()
    {
        $incomeCategories = IncomeCategory::where('user_id', Auth::id())->pluck('id');
        $incomes = Income::whereIn('income_category_id', $incomeCategories)->paginate(10);
        return view('incomes.index', compact('incomes'));
    }

    public function create()
    {
        $incomeCategories = IncomeCategory::where('user_id', Auth::id())->get();
        return view('incomes.create', compact('incomeCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'income_category_id' => 'required|exists:income_categories,id',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $incomeCategory = IncomeCategory::where('id', $request->income_category_id)
                                        ->where('user_id', Auth::id())
                                        ->firstOrFail();

        $incomeCategory->incomes()->create([
            'amount' => $request->amount,
            'date' => $request->date,
        ]);

        return redirect()->route('incomes.index')->with('success', 'Income created successfully.');
    }

    public function edit(Income $income)
    {
        $incomeCategories = IncomeCategory::where('user_id', Auth::id())->get();
        return view('incomes.edit', compact('income', 'incomeCategories'));
    }

    public function update(Request $request, Income $income)
    {
        $request->validate([
            'income_category_id' => 'required|exists:income_categories,id',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $incomeCategory = IncomeCategory::where('id', $request->income_category_id)
                                        ->where('user_id', Auth::id())
                                        ->firstOrFail();

        $income->update([
            'income_category_id' => $request->income_category_id,
            'amount' => $request->amount,
            'date' => $request->date,
        ]);

        return redirect()->route('incomes.index')->with('success', 'Income updated successfully.');
    }

    public function destroy(Income $income)
    {
        $income->delete();
        return redirect()->route('incomes.index')->with('success', 'Income deleted successfully.');
    }
}
