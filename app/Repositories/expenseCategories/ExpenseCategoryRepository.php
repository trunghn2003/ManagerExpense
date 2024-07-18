<?php
namespace App\Repositories\expenseCategories;

use App\Models\ExpenseCategory;

class ExpenseCategoryRepository implements ExpenseCategoryRepositoryInterface
{
    public function all($userId)
    {
        return ExpenseCategory::where('user_id', $userId)->paginate(10);
    }

    public function find($id)
    {
        return ExpenseCategory::find($id);
    }

    public function create(array $data)
    {
        return ExpenseCategory::create($data);
    }

    public function update($id, array $data)
    {
        $expenseCategory = ExpenseCategory::find($id);
        if ($expenseCategory) {
            $expenseCategory->update($data);
            return $expenseCategory;
        }
        return null;
    }

    public function delete($id)
    {
        $expenseCategory = ExpenseCategory::find($id);
        if ($expenseCategory) {
            $expenseCategory->delete();
            return true;
        }
        return false;
    }
    public function getByIds(array $ids)
    {
        return ExpenseCategory::whereIn('id', $ids)->pluck('name', 'id');
    }
    public function getByUserId($userId)
    {
        return ExpenseCategory::where('user_id', $userId)->pluck('id');
    }
}
