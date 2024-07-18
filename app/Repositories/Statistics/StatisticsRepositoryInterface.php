<?php

namespace App\Repositories\Statistics;

interface StatisticsRepositoryInterface
{
    public function getExpensesByUserAndDateRange($userId, $startDate, $endDate);
    public function getIncomesByUserAndDateRange($userId, $startDate, $endDate);
}
