<?php
namespace App\Services\IncomeCategories;

use App\Repositories\IncomeCategories\IncomeCategoryRepositoryInterface;

class IncomeCategoryService implements IncomeCategoryServiceInterface
{
    protected $incomeCategoryRepository;

    public function __construct(IncomeCategoryRepositoryInterface $incomeCategoryRepository)
    {
        $this->incomeCategoryRepository = $incomeCategoryRepository;
    }

    public function getAllIncomeCategories($userId)
    {
        return $this->incomeCategoryRepository->all($userId);
    }

    public function getIncomeCategoryById($id)
    {
        return $this->incomeCategoryRepository->find($id);
    }

    public function createIncomeCategory(array $data)
    {
        return $this->incomeCategoryRepository->create($data);
    }

    public function updateIncomeCategory($id, array $data)
    {
        return $this->incomeCategoryRepository->update($id, $data);
    }

    public function deleteIncomeCategory($id)
    {
        return $this->incomeCategoryRepository->delete($id);
    }
}
