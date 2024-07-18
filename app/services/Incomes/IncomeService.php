<?php

namespace App\Services\Incomes;

use App\Repositories\Incomes\IncomeRepositoryInterface;

class IncomeService implements IncomeServiceInterface
{
    protected $incomeRepository;

    public function __construct(IncomeRepositoryInterface $incomeRepository)
    {
        $this->incomeRepository = $incomeRepository;
    }

    public function getAllIncomes($userId, $filters)
    {
        return $this->incomeRepository->all($userId, $filters);
    }

    public function getIncomeById($id)
    {
        return $this->incomeRepository->find($id);
    }

    public function createIncome(array $data)
    {
        return $this->incomeRepository->create($data);
    }

    public function updateIncome($id, array $data)
    {
        return $this->incomeRepository->update($id, $data);
    }

    public function deleteIncome($id)
    {
        return $this->incomeRepository->delete($id);
    }
}
