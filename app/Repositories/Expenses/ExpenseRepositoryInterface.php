<?php
namespace App\Repositories\Expenses;

interface ExpenseRepositoryInterface
{
    public function all($userId, $filters);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
