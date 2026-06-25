<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use Illuminate\Http\Request;

class TeacherCompetitionController extends Controller
{
    /**
     * Display competitions
     */
    public function index()
    {
        $competitions = Competition::orderBy('created_at', 'desc')->paginate(10);

        return view('teacher.competitions-index', compact('competitions'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('teacher.create-competition');
    }

    /**
     * Store competition
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255|unique:competitions,title',
            'description' => 'required|string|min:50',
            'rules'       => 'nullable|string',
            'start_date'  => 'required|date|after_or_equal:today',
            'deadline'    => 'required|date|after:start_date',
            'fee'         => 'required|numeric|min:0',
        ], [
            'title.unique' => 'A competition with this title already exists.',
            'description.min' => 'Description must be at least 50 characters long.',
        ]);

        Competition::create([
            'title'       => $request->title,
            'description' => $request->description,
            'rules'       => $request->rules,
            'start_date'  => $request->start_date,
            'deadline'    => $request->deadline,
            'fee'         => $request->fee,
            'status'      => 'upcoming',
            'created_by'  => auth()->id(),
        ]);

        return redirect()
            ->route('teacher.dashboard')
            ->with('success', 'Competition created successfully!');
    }

    /**
     * Show competition
     */
    public function show($id)
    {
        $competition = Competition::findOrFail($id);

        return view('teacher.competition-show', compact('competition'));
    }

    /**
     * Edit form
     */
    public function edit($id)
    {
        $competition = Competition::findOrFail($id);

        if (in_array($competition->status, ['completed', 'cancelled'])) {
            return back()->with('error', 'This competition cannot be edited.');
        }

        return view('teacher.edit-competition', compact('competition'));
    }

    /**
     * Update competition
     * Fee cannot be edited after creation
     */
    public function update(Request $request, $id)
    {
        $competition = Competition::findOrFail($id);

        if (in_array($competition->status, ['completed', 'cancelled'])) {
            return back()->with('error', 'This competition cannot be updated.');
        }

        $request->validate([
            'title'       => 'required|string|max:255|unique:competitions,title,' . $competition->id,
            'description' => 'required|string|min:50',
            'rules'       => 'nullable|string',
            'start_date'  => 'required|date',
            'deadline'    => 'required|date|after:start_date',
        ], [
            'title.unique' => 'A competition with this title already exists.',
            'description.min' => 'Description must be at least 50 characters long.',
        ]);

        $competition->update([
            'title'       => $request->title,
            'description' => $request->description,
            'rules'       => $request->rules,
            'start_date'  => $request->start_date,
            'deadline'    => $request->deadline,
        ]);

        return redirect()
            ->route('teacher.dashboard')
            ->with('success', 'Competition updated successfully!');
    }

    /**
     * Delete competition
     */
    public function destroy($id)
    {
        $competition = Competition::findOrFail($id);

        $competition->delete();

        return redirect()
            ->route('teacher.dashboard')
            ->with('success', 'Competition deleted successfully!');
    }
}