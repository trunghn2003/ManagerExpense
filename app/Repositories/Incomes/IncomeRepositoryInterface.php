<?php

namespace App\Repositories\Incomes;

interface IncomeRepositoryInterface
{
    public function all($userId, $filters);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
