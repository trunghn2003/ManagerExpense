<?php
namespace App\Http\Controllers;

use App\Models\IncomeCategory;
use App\Models\User;
use Illuminate\Http\Request;

class IncomeCategoryController extends Controller
{
    public function index()
    {
        $incomeCategories = IncomeCategory::all();
        return view('income-categories.index', compact('incomeCategories'));
    }

    public function create()
    {
        $users = User::all();
        return view('income-categories.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        IncomeCategory::create($request->all());

        return redirect()->route('income-categories.index')->with('success', 'Income category created successfully.');
    }

    public function edit(IncomeCategory $incomeCategory)
    {
        $users = User::all();
        return view('income-categories.edit', compact('incomeCategory', 'users'));
    }

    public function update(Request $request, IncomeCategory $incomeCategory)
    {
        $request->validate([
            'name' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        $incomeCategory->update($request->all());

        return redirect()->route('income-categories.index')->with('success', 'Income category updated successfully.');
    }

    public function destroy(IncomeCategory $incomeCategory)
    {
        $incomeCategory->delete();
        return redirect()->route('income-categories.index')->with('success', 'Income category deleted successfully.');
    }
}
