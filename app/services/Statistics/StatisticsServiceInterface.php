<?php

namespace App\Services\Statistics;

interface StatisticsServiceInterface
{
    public function getStatistics($userId, $startDate, $endDate);
}
