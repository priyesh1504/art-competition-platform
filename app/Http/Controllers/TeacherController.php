<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\Artwork;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        // Paginated competitions (5 per page)
        $competitions = Competition::orderBy('created_at', 'desc')->paginate(5);

        // Dashboard Stats (separate queries, so pagination does NOT affect them)
        $totalCompetitions  = Competition::count();
        $activeCompetitions = Competition::where('status', 'ongoing')->count();
        $closedCompetitions = Competition::where('status', 'completed')->count();

        // Pending Reviews (artworks still pending)
        $pendingReviews = Artwork::where('status', 'pending')->count();

        return view('dashboards.teacher', compact(
            'competitions',
            'totalCompetitions',
            'activeCompetitions',
            'closedCompetitions',
            'pendingReviews'
        ));
    }
}
