<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Competition;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index(Request $request)
    {
        $now = now();

        // Registered competition IDs
        $registeredCompetitionIds = Auth::user()
            ->artworks()
            ->whereNotNull('competition_id')
            ->pluck('competition_id')
            ->unique()
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | Base query for search/filter
        |--------------------------------------------------------------------------
        */
        $query = Competition::query()
            ->where('status', '!=', 'cancelled');

        // Search
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter
        if ($request->filter === 'registered') {
            $query->whereIn('id', $registeredCompetitionIds);
        }

        if ($request->filter === 'not_registered') {
            $query->whereNotIn('id', $registeredCompetitionIds);
        }

        /*
        |--------------------------------------------------------------------------
        | Paginated list (for cards display only)
        |--------------------------------------------------------------------------
        */
        $competitions = (clone $query)
            ->latest()
            ->paginate(6)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Full filtered dataset (for counts and sections)
        |--------------------------------------------------------------------------
        */
        $allCompetitions = (clone $query)->get();

        /*
        |--------------------------------------------------------------------------
        | Stats
        |--------------------------------------------------------------------------
        */
        $totalCompetitions = $allCompetitions->count();

        $registeredCount = $allCompetitions
            ->whereIn('id', $registeredCompetitionIds)
            ->count();

        $availableCount = $allCompetitions->filter(function ($competition) use ($registeredCompetitionIds) {
            return in_array($competition->computed_status, ['ongoing', 'upcoming']) &&
                   !in_array($competition->id, $registeredCompetitionIds);
        })->count();

        /*
        |--------------------------------------------------------------------------
        | Sections
        |--------------------------------------------------------------------------
        */
        $ongoing = $allCompetitions->filter(
            fn($competition) => $competition->computed_status === 'ongoing'
        );

        $upcoming = $allCompetitions->filter(
            fn($competition) => $competition->computed_status === 'upcoming'
        );

        $completed = $allCompetitions->filter(
            fn($competition) => $competition->computed_status === 'completed'
        );

        return view('dashboards.student', compact(
            'competitions',
            'registeredCompetitionIds',
            'totalCompetitions',
            'registeredCount',
            'availableCount',
            'ongoing',
            'upcoming',
            'completed'
        ));
    }
}