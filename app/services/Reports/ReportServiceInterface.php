<?php
namespace App\Services\reports;

interface ReportServiceInterface
{
    public function generateReportContent($startDate, $endDate, $userId);
    public function createReport(array $data);
    public function updateReport($id, array $data);
    public function deleteReport($id);
    public function getReportById($id);
    public function getAllReports();
}
