<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use Illuminate\Http\Request;

class StudentPortfolioController extends Controller
{
    /**
     * Show ALL artworks (competition + personal)
     */
    public function index()
    {
        $query = Artwork::where('user_id', auth()->id());

        // Filter by art style
        if (request()->has('style') && request('style') != '') {
            $query->where('art_style', request('style'));
        }

        $artworks = $query->latest()->get();

        return view('student.portfolio-index', compact('artworks'));
    }
    /**
     * Store artwork (image upload allowed ONLY here)
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'art_style'   => 'required|in:Sketching,Watercolour,Digital,Oil Pastels,Acrylics,Madhubani,Warli',
        ]);

        $path = $request->file('image')->store('portfolio', 'public');

        Artwork::create([
            'user_id'        => auth()->id(),
            'title'          => $request->title,
            'description'    => $request->description,
            'image_path'     => $path,
            'art_style'      => $request->art_style,
            'competition_id' => null,
            'status'         => 'pending',
        ]);

        return redirect()->route('student.portfolio.index')
            ->with('success', 'Artwork added successfully!');
    }

    /**
     * Edit artwork
     */
    public function edit($id)
    {
        $artwork = Artwork::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('student.portfolio-edit', compact('artwork'));
    }

    /**
     * Update artwork 
     */
    public function update(Request $request, $id)
    {
        $artwork = Artwork::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'art_style'   => 'required|in:Sketching,Watercolour,Digital,Oil Pastels,Acrylics,Madhubani,Warli',
        ]);
        $artwork->update([
            'title'       => $request->title,
            'description' => $request->description,
            'art_style'   => $request->art_style,
        ]);

        return redirect()->route('student.portfolio.index')
            ->with('success', 'Artwork updated successfully!');
    }

    /**
     * Delete artwork
     */
    public function destroy($id)
    {
        $artwork = Artwork::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $artwork->delete();

        return redirect()->route('student.portfolio.index')
            ->with('success', 'Artwork removed successfully.');
    }
}