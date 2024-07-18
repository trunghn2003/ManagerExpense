<?php
namespace App\Services\Expenses;

interface ExpenseServiceInterface
{
    public function getAllExpenses($userId, $filters);
    public function getExpenseById($id);
    public function createExpense(array $data);
    public function updateExpense($id, array $data);
    public function deleteExpense($id);
}
