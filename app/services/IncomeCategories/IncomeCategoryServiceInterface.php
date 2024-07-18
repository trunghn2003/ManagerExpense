<?php
namespace App\Services\IncomeCategories;

interface IncomeCategoryServiceInterface
{
    public function getAllIncomeCategories($userId);
    public function getIncomeCategoryById($id);
    public function createIncomeCategory(array $data);
    public function updateIncomeCategory($id, array $data);
    public function deleteIncomeCategory($id);
}
