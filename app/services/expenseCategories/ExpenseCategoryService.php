<?php
namespace App\Services\expenseCategories;

use App\Repositories\expenseCategories\ExpenseCategoryRepositoryInterface;

class ExpenseCategoryService implements ExpenseCategoryServiceInterface
{
    protected $expenseCategoryRepository;

    public function __construct(ExpenseCategoryRepositoryInterface $expenseCategoryRepository)
    {
        $this->expenseCategoryRepository = $expenseCategoryRepository;
    }

    public function getAllExpenseCategories($userId)
    {
        return $this->expenseCategoryRepository->all($userId);
    }

    public function getExpenseCategoryById($id)
    {
        return $this->expenseCategoryRepository->find($id);
    }

    public function createExpenseCategory(array $data)
    {
        return $this->expenseCategoryRepository->create($data);
    }

    public function updateExpenseCategory($id, array $data)
    {
        return $this->expenseCategoryRepository->update($id, $data);
    }

    public function deleteExpenseCategory($id)
    {
        return $this->expenseCategoryRepository->delete($id);
    }
}
