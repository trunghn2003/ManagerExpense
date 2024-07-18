<?php
namespace App\Http\Controllers;

use App\Services\Statistics\StatisticsServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    protected $statisticsService;

    public function __construct(StatisticsServiceInterface $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }

    public function index(Request $request)
    {
        $userId = Auth::id();

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $startDate = $request->input('start_date', $startOfMonth->toDateString());
        $endDate = $request->input('end_date', $endOfMonth->toDateString());

        $statistics = $this->statisticsService->getStatistics($userId, $startDate, $endDate);

        return view('statistics.index', array_merge($statistics, compact('startDate', 'endDate')));
    }
}
