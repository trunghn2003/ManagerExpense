<?php
namespace App\Services\Expenses;

use App\Repositories\Expenses\ExpenseRepositoryInterface;

class ExpenseService implements ExpenseServiceInterface
{
    protected $expenseRepository;

    public function __construct(ExpenseRepositoryInterface $expenseRepository)
    {
        $this->expenseRepository = $expenseRepository;
    }

    public function getAllExpenses($userId, $filters)
    {
        return $this->expenseRepository->all($userId, $filters);
    }

    public function getExpenseById($id)
    {
        return $this->expenseRepository->find($id);
    }

    public function createExpense(array $data)
    {
        return $this->expenseRepository->create($data);
    }

    public function updateExpense($id, array $data)
    {
        return $this->expenseRepository->update($id, $data);
    }

    public function deleteExpense($id)
    {
        return $this->expenseRepository->delete($id);
    }
}
