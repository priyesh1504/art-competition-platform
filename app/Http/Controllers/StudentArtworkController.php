<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Competition;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentArtworkController extends Controller
{
    /**
     * Show student's artworks
     */
    public function index(Request $request)
    {
        $query = Artwork::where('user_id', Auth::id())
            ->with('competition');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->sort === 'score_high') {
            $query->orderByDesc('score');
        } elseif ($request->sort === 'score_low') {
            $query->orderBy('score');
        } else {
            $query->latest();
        }

        $artworks = $query->paginate(9)->withQueryString();

        return view('student.artworks-index', compact('artworks'));
    }

    /**
     * Show upload form
     */
    public function create(Request $request)
    {
        $competitions = Competition::orderBy('deadline')->get();

        $selectedCompetition = $request->competition_id;

        $paidCompetitionIds = Payment::where('user_id', Auth::id())
            ->where('status', 'completed')
            ->pluck('competition_id')
            ->toArray();

        return view('student.artwork-upload', compact(
            'competitions',
            'selectedCompetition',
            'paidCompetitionIds'
        ));
    }

    /**
     * Store artwork
     */
    public function store(Request $request)
    {
        $request->validate([
            'competition_id' => 'required|exists:competitions,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:50',
            'art_style' => 'required|string|in:Sketching,Watercolour,Digital,Oil Pastels,Acrylics,Madhubani,Warli',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120'
        ], [
            'description.min' => 'Description must be at least 50 characters long.',
            'art_style.required' => 'Please select an art style.',
            'image.required' => 'Please upload your artwork image.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'Only JPG, PNG, or WEBP images are allowed.',
            'image.max' => 'The image must not exceed 5MB.'
        ]);

        $competition = Competition::findOrFail($request->competition_id);

        if (now()->gt($competition->deadline)) {
            return back()->withErrors([
                'competition_id' => 'This competition is already closed.'
            ])->withInput();
        }

        if ($competition->fee > 0) {
            $payment = Payment::where('user_id', Auth::id())
                ->where('competition_id', $competition->id)
                ->where('status', 'completed')
                ->first();

            if (!$payment) {
                return redirect()
                    ->route('student.checkout', $competition->id)
                    ->with('error', 'Payment required before submitting artwork.');
            }
        }

        try {
            $path = $request->file('image')->store('artworks', 'public');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Image upload failed. Please try again.')
                ->withInput();
        }

        Artwork::create([
            'user_id' => Auth::id(),
            'competition_id' => $competition->id,
            'title' => $request->title,
            'description' => $request->description,
            'art_style' => $request->art_style,
            'image_path' => $path,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('student.artworks.index')
            ->with('success', 'Artwork submitted successfully!');
    }
}