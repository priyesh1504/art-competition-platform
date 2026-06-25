<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Paginate competitions list
        $competitions = Competition::orderBy('created_at', 'desc')
            ->paginate(5);

        // Dashboard Counts
        $totalCompetitions = Competition::count();

        // Active = Ongoing + Upcoming
        $activeCompetitions = Competition::whereIn('status', ['ongoing', 'upcoming'])
            ->count();

        // Closed = Completed
        $closedCompetitions = Competition::where('status', 'completed')
            ->count();

        return view('dashboards.admin', compact(
            'competitions',
            'totalCompetitions',
            'activeCompetitions',
            'closedCompetitions'
        ));
    }
}
