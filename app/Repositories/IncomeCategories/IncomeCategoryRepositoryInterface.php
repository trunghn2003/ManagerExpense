<?php
namespace App\Repositories\IncomeCategories;

interface IncomeCategoryRepositoryInterface
{
    public function all($userId);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
