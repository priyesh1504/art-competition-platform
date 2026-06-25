<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artwork;
use App\Models\Certificate;
use App\Models\Competition;
use App\Models\User;

class CaregiverController extends Controller
{
    /**
     * Reusable authorization
     */
    private function authorizeChild($id)
    {
        if (!auth()->user()->students->contains('id', $id)) {
            abort(403);
        }
    }


    /**
     * ===============================
     * MAIN DASHBOARD
     * ===============================
     */
    public function index()
    {
        $students = auth()->user()->students;
        $studentIds = $students->pluck('id');

        $activities = Artwork::whereIn('user_id', $studentIds)
            ->with(['competition', 'student'])
            ->latest()
            ->get();

        $childrenCount = $students->count();
        $submissionsCount = $activities->count();

        $competitionsCount = $activities
            ->pluck('competition_id')
            ->unique()
            ->count();

        $certificates = Certificate::whereIn('user_id', $studentIds)
            ->with(['artwork.competition', 'user'])
            ->latest()
            ->get();

        $awardsCount = $certificates->count();

        $avgScore = $activities
            ->whereNotNull('score')
            ->avg('score') ?? 0;

        $upcomingCompetitions = Competition::where('deadline', '>=', now())
            ->orderBy('deadline')
            ->take(5)
            ->get();

        $studentStats = $students->map(function ($student) {

            $studentArtworks = Artwork::where('user_id', $student->id);

            return [
                'id' => $student->id,
                'name' => $student->name,
                'submissions' => $studentArtworks->count(),
                'avg_score' => round(
                    $studentArtworks->whereNotNull('score')->avg('score') ?? 0,
                    2
                ),
            ];
        });

        $chartLabels = $activities->pluck('competition.title')->filter()->values();
        $chartScores = $activities->pluck('score')->filter()->values();

        return view('dashboards.caregiver', compact(
            'students',
            'activities',
            'childrenCount',
            'competitionsCount',
            'submissionsCount',
            'awardsCount',
            'avgScore',
            'studentStats',
            'certificates',
            'upcomingCompetitions',
            'chartLabels',
            'chartScores'
        ));
    }


    /**
     * ===============================
     * CHILD LIST PAGE
     * ===============================
     */
    public function children()
    {
        $students = auth()->user()->students;

        return view('caregiver.children', compact('students'));
    }


    /**
     * ===============================
     * SINGLE CHILD DASHBOARD
     * ===============================
     */
    public function showChild($id)
    {
        $this->authorizeChild($id);

        $child = User::findOrFail($id);

        return view('caregiver.child-show', compact('child'));
    }

    /**
     * ===============================
     * CHILD SUBMISSIONS
     * ===============================
     */
    public function studentSubmissions($id)
    {
        $this->authorizeChild($id);

        $child = User::findOrFail($id);

        $submissions = Artwork::where('user_id', $id)
            ->with('competition')
            ->latest()
            ->paginate(8);

        return view('caregiver.submissions.show', compact('child', 'submissions'));
    }

    /**
     * ===============================
     * CHILD CERTIFICATES
     * ===============================
     */
    public function studentCertificates($id)
    {
        $this->authorizeChild($id);

        $child = User::findOrFail($id);

        $certificates = Certificate::where('user_id', $id)
            ->with('artwork.competition')
            ->latest()
            ->paginate(8);

        return view('caregiver.certificates.show', compact('child', 'certificates'));
    }


    /**
     * ===============================
     * CHILD PERFORMANCE
     * ===============================
     */
    public function performance($id)
    {
        $this->authorizeChild($id);

        $child = User::findOrFail($id);

        $artworks = Artwork::where('user_id', $id)
            ->whereNotNull('score')
            ->with('competition')
            ->get();

        $labels = $artworks->pluck('competition.title')->filter()->values();
        $scores = $artworks->pluck('score')->values();

        return view('caregiver.performance', compact('child', 'labels', 'scores'));
    }
}