<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\NewCompetitionNotification;

class CompetitionController extends Controller
{
    /**
     * Show competitions
     */
    public function index()
    {
        Competition::where('deadline', '<', now())
            ->where('status', '!=', 'completed')
            ->update(['status' => 'completed']);

        Competition::where('start_date', '<=', now())
            ->where('deadline', '>=', now())
            ->where('status', 'upcoming')
            ->update(['status' => 'ongoing']);

        $competitions = Competition::latest()->get();

        return view('admin.competitions-index', compact('competitions'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.create-competition');
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

        $competition = Competition::create([
            'title'       => $request->title,
            'description' => $request->description,
            'rules'       => $request->rules,
            'start_date'  => $request->start_date,
            'deadline'    => $request->deadline,
            'status'      => 'upcoming',
            'fee'         => $request->fee,
            'created_by'  => auth()->id(),
        ]);

        $usersToNotify = User::whereIn('role', ['student', 'caregiver'])->get();

        foreach ($usersToNotify as $user) {
            $user->notify(new NewCompetitionNotification($competition));
        }

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Competition created successfully and notifications sent!');
    }

    /**
     * Show competition
     */
    public function show($id)
    {
        $competition = Competition::findOrFail($id);

        return view('admin.competition-show', compact('competition'));
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $competition = Competition::findOrFail($id);

        if (in_array($competition->status, ['completed', 'cancelled'])) {
            return back()->with('error', 'This competition cannot be edited.');
        }

        return view('admin.competition-edit', compact('competition'));
    }

    /**
     * Update competition
     * Fee cannot be changed after creation
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
            ->route('admin.dashboard')
            ->with('success', 'Competition updated successfully!');
    }

    /**
     * Cancel competition
     */
    public function cancel($id)
    {
        $competition = Competition::findOrFail($id);

        if ($competition->status === 'completed') {
            return back()->with('error', 'Completed competitions cannot be cancelled.');
        }

        if ($competition->status === 'cancelled') {
            return back()->with('error', 'This competition is already cancelled.');
        }

        $competition->update([
            'status' => 'cancelled'
        ]);

        return back()->with('success', 'Competition has been cancelled successfully.');
    }

    /**
     * Delete competition
     */
    public function destroy($id)
    {
        $competition = Competition::findOrFail($id);

        if ($competition->payments()->withTrashed()->exists()) {
            return back()->with(
                'error',
                'Cannot delete this competition because payments exist. You may cancel it instead.'
            );
        }

        $competition->delete();

        return back()->with('success', 'Competition deleted successfully!');
    }
}