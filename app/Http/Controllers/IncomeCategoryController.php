<?php

namespace App\Http\Controllers;

use App\Services\IncomeCategories\IncomeCategoryServiceInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeCategoryController extends Controller
{
    protected $incomeCategoryService;

    public function __construct(IncomeCategoryServiceInterface $incomeCategoryService)
    {
        $this->incomeCategoryService = $incomeCategoryService;
    }

    public function index()
    {
        $userId = Auth::id();
        $incomeCategories = $this->incomeCategoryService->getAllIncomeCategories($userId);
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

        $this->incomeCategoryService->createIncomeCategory($request->all());

        return redirect()->route('income-categories.index')->with('success', 'Income category created successfully.');
    }

    public function edit($id)
    {
        $incomeCategory = $this->incomeCategoryService->getIncomeCategoryById($id);
        $users = User::all();
        return view('income-categories.edit', compact('incomeCategory', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        $this->incomeCategoryService->updateIncomeCategory($id, $request->all());

        return redirect()->route('income-categories.index')->with('success', 'Income category updated successfully.');
    }

    public function destroy($id)
    {
        $this->incomeCategoryService->deleteIncomeCategory($id);
        return redirect()->route('income-categories.index')->with('success', 'Income category deleted successfully.');
    }
}
