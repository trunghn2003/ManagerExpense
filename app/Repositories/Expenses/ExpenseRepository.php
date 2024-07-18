<?php
namespace App\Repositories\Expenses;

use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class ExpenseRepository implements ExpenseRepositoryInterface
{
    public function all($userId, $filters)
    {
        $query = Expense::whereHas('expenseCategory', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        });

        if (!empty($filters['keyword'])) {
            $query->where(function($q) use ($filters) {
                $q->where('description', 'like', '%' . $filters['keyword'] . '%')
                  ->orWhereHas('expenseCategory', function ($q) use ($filters) {
                      $q->where('name', 'like', '%' . $filters['keyword'] . '%');
                  });
            });
        }

        if (!empty($filters['category'])) {
            $query->where('expense_category_id', $filters['category']);
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
        return Expense::find($id);
    }

    public function create(array $data)
    {
        return Expense::create($data);
    }

    public function update($id, array $data)
    {
        $expense = Expense::find($id);
        if ($expense) {
            $expense->update($data);
            return $expense;
        }
        return null;
    }

    public function delete($id)
    {
        $expense = Expense::find($id);
        if ($expense) {
            $expense->delete();
            return true;
        }
        return false;
    }
    public function getByCategoryIdsAndDateRange(array $categoryIds, $startDate, $endDate)
    {
        return Expense::whereIn('expense_category_id', $categoryIds)
            ->whereBetween('date', [$startDate, $endDate])
            ->get();
    }
}
