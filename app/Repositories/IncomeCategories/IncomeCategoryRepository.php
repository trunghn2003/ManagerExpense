<?php
namespace App\Repositories\IncomeCategories;

use App\Models\IncomeCategory;

class IncomeCategoryRepository implements IncomeCategoryRepositoryInterface
{
    public function all($userId)
    {
        return IncomeCategory::where('user_id', $userId)->paginate(10);
    }

    public function find($id)
    {
        return IncomeCategory::find($id);
    }

    public function create(array $data)
    {
        return IncomeCategory::create($data);
    }

    public function update($id, array $data)
    {
        $incomeCategory = IncomeCategory::find($id);
        if ($incomeCategory) {
            $incomeCategory->update($data);
            return $incomeCategory;
        }
        return null;
    }

    public function delete($id)
    {
        $incomeCategory = IncomeCategory::find($id);
        if ($incomeCategory) {
            $incomeCategory->delete();
            return true;
        }
        return false;
    }
    public function getByIds($ids)
    {
        return IncomeCategory::whereIn('id', $ids)->pluck('name', 'id');
    }
    public function getByUserId($userId)
    {
        return IncomeCategory::where('user_id', $userId)->pluck('id');
    }
    
}
