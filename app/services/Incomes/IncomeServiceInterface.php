<?php
namespace App\Services\Incomes;

interface IncomeServiceInterface
{
    public function getAllIncomes($userId, $filters);
    public function getIncomeById($id);
    public function createIncome(array $data);
    public function updateIncome($id, array $data);
    public function deleteIncome($id);
}
