<?php
namespace App\Services\expenseCategories;

interface ExpenseCategoryServiceInterface
{
    public function getAllExpenseCategories($userId);
    public function getExpenseCategoryById($id);
    public function createExpenseCategory(array $data);
    public function updateExpenseCategory($id, array $data);
    public function deleteExpenseCategory($id);
}
