<?php

namespace App\Repositories\Incomes;

use App\Models\Income;
use Illuminate\Support\Facades\Auth;

class IncomeRepository implements IncomeRepositoryInterface
{
    public function all($userId, $filters)
    {
        $query = Income::whereHas('incomeCategory', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        });

        if (!empty($filters['keyword'])) {
            $query->where(function($q) use ($filters) {
                $q->where('description', 'like', '%' . $filters['keyword'] . '%')
                  ->orWhereHas('incomeCategory', function ($q) use ($filters) {
                      $q->where('name', 'like', '%' . $filters['keyword'] . '%');
                  });
            });
        }

        if (!empty($filters['category'])) {
            $query->where('income_category_id', $filters['category']);
        }

        if (!empty($filters['start_date'])) {
            $query->whereDate('date', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->whereDate('date', '<=', $filters['end_date']);
        }

        if (!empty($filters['min_amount'])) {
            $query->where('amount', '>=', $filters['min_amount']);
        }

        if (!empty($filters['max_amount'])) {
            $query->where('amount', '<=', $filters['max_amount']);
        }

        return $query->paginate(10);
    }

    public function find($id)
    {
        return Income::find($id);
    }

    public function create(array $data)
    {
        return Income::create($data);
    }

    public function update($id, array $data)
    {
        $income = Income::find($id);
        if ($income) {
            $income->update($data);
            return $income;
        }
        return null;
    }

    public function delete($id)
    {
        $income = Income::find($id);
        if ($income) {
            $income->delete();
            return true;
        }
        return false;
    }
}
