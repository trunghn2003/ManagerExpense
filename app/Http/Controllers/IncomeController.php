<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\IncomeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Income::whereHas('incomeCategory', function ($query) {
            $query->where('user_id', Auth::id());
        });

        if ($request->filled('keyword')) {
            $query->where(function($q) use ($request) {
                $q->where('description', 'like', '%' . $request->keyword . '%')
                  ->orWhereHas('incomeCategory', function ($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->keyword . '%');
                  });
            });
        }

        if ($request->filled('category')) {
            $query->where('income_category_id', $request->category);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        if ($request->filled('min_amount')) {
            $query->where('amount', '>=', $request->min_amount);
        }

        if ($request->filled('max_amount')) {
            $query->where('amount', '<=', $request->max_amount);
        }

        $incomes = $query->paginate(10);
        $incomeCategories = IncomeCategory::where('user_id', Auth::id())->get();

        return view('incomes.index', compact('incomes', 'incomeCategories'));
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
            'description' => $request->description,
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
            'description' => $request->description,
        ]);

        return redirect()->route('incomes.index')->with('success', 'Income updated successfully.');
    }

    public function destroy(Income $income)
    {
        $income->delete();
        return redirect()->route('incomes.index')->with('success', 'Income deleted successfully.');
    }
}
