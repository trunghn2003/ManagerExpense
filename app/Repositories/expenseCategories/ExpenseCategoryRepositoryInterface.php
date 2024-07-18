<?php
namespace App\Repositories\expenseCategories;

interface ExpenseCategoryRepositoryInterface
{
    public function all($userId);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function getByIds(array $ids);
    public function getByUserId($userId);
}
