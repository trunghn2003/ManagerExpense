<?php
namespace App\Repositories\reports;

use App\Models\Report;

class ReportRepository implements ReportRepositoryInterface
{
    public function all()
    {
        return Report::query(); // Trả về Query Builder
    }

    public function find($id)
    {
        return Report::find($id);
    }

    public function create(array $data)
    {
        return Report::create($data);
    }

    public function update($id, array $data)
    {
        $report = Report::find($id);
        if ($report) {
            $report->update($data);
            return $report;
        }
        return null;
    }

    public function delete($id)
    {
        $report = Report::find($id);
        if ($report) {
            $report->delete();
            return true;
        }
        return false;
    }
}
