<?php
namespace App\Http\Controllers;

use App\Services\reports\ReportServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportServiceInterface $reportService)
    {
        $this->reportService = $reportService;
    }

    public function index()
    {
        $userId = Auth::id();
        $reports = $this->reportService->getAllReports()
            ->where('user_id', $userId)
            ->orWhere('is_public', true)
            ->paginate(10);

        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        return view('reports.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_public' => 'boolean',
        ]);

        $userId = Auth::id();
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        $reportContent = $this->reportService->generateReportContent($startDate, $endDate, $userId);

        $isPublic = $request->has('is_public') ? (bool)$request->is_public : false;

        $this->reportService->createReport([
            'user_id' => $userId,
            'title' => $request->title,
            'content' => $reportContent,
            'is_public' => $isPublic,
        ]);

        return redirect()->route('reports.index')->with('success', 'Report created successfully.');
    }

    public function show($id)
    {
        $report = $this->reportService->getReportById($id);
        if (!$report->is_public && $report->user_id != Auth::id()) {
            return redirect()->route('reports.index')->with('error', 'Unauthorized access.');
        }

        return view('reports.show', compact('report'));
    }

    public function edit($id)
    {
        $report = $this->reportService->getReportById($id);
        if ($report->user_id != Auth::id()) {
            return redirect()->route('reports.index')->with('error', 'Unauthorized access.');
        }

        return view('reports.edit', compact('report'));
    }

    public function update(Request $request, $id)
    {
        $report = $this->reportService->getReportById($id);
        if ($report->user_id != Auth::id()) {
            return redirect()->route('reports.index')->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'is_public' => 'boolean',
        ]);

        $isPublic = $request->has('is_public') ? (bool)$request->is_public : false;

        $this->reportService->updateReport($id, [
            'title' => $request->title,
            'is_public' => $isPublic,
        ]);

        return redirect()->route('reports.index')->with('success', 'Report updated successfully.');
    }
}
