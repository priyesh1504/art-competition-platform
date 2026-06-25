<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Certificate;
use App\Models\Competition;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use App\Notifications\ArtworkGradedNotification;
use Illuminate\Support\Str;

class GradingController extends Controller
{
    /**
     * Show submissions list
     */
    public function index()
{
    $query = Artwork::with(['student', 'competition', 'payments', 'grader']);

    if (request()->has('competition_id') && request('competition_id') != '') {
        $query->where('competition_id', request('competition_id'));
    }
    $artworks = $query
        ->orderByRaw("FIELD(status, 'pending', 'reviewed') ASC")
        ->latest()
        ->paginate(10);

    $pendingCount = Artwork::where('status', 'pending')->count();
    $reviewedCount = Artwork::where('status', 'reviewed')->count();
    $competitions = Competition::orderBy('title')->pluck('title');

    $view = auth()->user()->role === 'teacher'
        ? 'teacher.grading-index'
        : 'admin.grading-index';

    return view($view, compact(
        'artworks',
        'pendingCount',
        'reviewedCount',
        'competitions'
    ));
}

    /**
     * Show grading form
     */
    public function edit($id)
    {
        $artwork = Artwork::with(['student', 'competition'])->findOrFail($id);

        $view = auth()->user()->role === 'teacher'
            ? 'teacher.grading-edit'
            : 'admin.grading-edit';

        return view($view, compact('artwork'));
    }

    /**
     * Submit grade + notify caregiver
     */
    public function update(Request $request, $id)
    {
        $artwork = Artwork::with(['student', 'competition'])->findOrFail($id);

        $competitionId = $request->input('competition_id');

        $request->validate([
            'score'    => 'required|integer|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        $artwork->update([
            'score'     => $request->score,
            'feedback'  => $request->feedback,
            'status'    => 'reviewed',
            'graded_by' => auth()->id(), 
        ]);

        if ($request->has('generate_certificate_now')) {
            $this->generateCertificate($artwork);
            return back()->with('success', 'Certificate generated successfully!');
        }

        $student = $artwork->student;

        if ($student && $student->caregivers) {
            foreach ($student->caregivers as $caregiver) {
                $caregiver->notify(new ArtworkGradedNotification($artwork));
            }
        }

        $route = auth()->user()->role === 'teacher'
            ? 'teacher.grading.index'
            : 'admin.grading.index';

        return redirect()
            ->route($route) //
            ->with('success', 'Grading submitted! Caregiver notified.');
    }

    /**
     * Manual Generate Certificate Button Route
     */
    public function generate($id)
    {
        $artwork = Artwork::with(['student', 'competition'])->findOrFail($id);

        $this->generateCertificate($artwork);

        return back()->with('success', 'Certificate generated successfully!');
    }

    /**
     * Generate Certificate Image + Save DB Record
     */
    private function generateCertificate($artwork)
    {
        if ($artwork->certificate) {
            return;
        }

        $templatePath = storage_path('app/public/templates/cert_template.png');

        if (!file_exists($templatePath)) {
            throw new \Exception("Certificate template missing!");
        }

        $img = Image::read($templatePath);

        $fontPath = public_path('fonts/Poppins-Bold.ttf');

        // Student Name
        $img->text($artwork->student->name, 500, 520, function ($font) use ($fontPath) {
            $font->file($fontPath);
            $font->size(65);
            $font->color('#1f2937');
            $font->align('center');
        });

        // Competition Title
        $img->text(
            $artwork->competition
                ? "Awarded for: " . $artwork->competition->title
                : "Portfolio Achievement",
            500,
            610,
            function ($font) use ($fontPath) {
                $font->file($fontPath);
                $font->size(32);
                $font->color('#374151');
                $font->align('center');
            }
        );

        //Artwork Title 
        $img->text(
            "Artwork: " . Str::limit($artwork->title ?? 'Untitled', 40),
            500,
            670,
            function ($font) use ($fontPath) {
                $font->file($fontPath);
                $font->size(28);
                $font->color('#4b5563');
                $font->align('center');
            }
        );

        // Date
        $img->text(
            now()->format('F j, Y'),
            500,
            910,
            function ($font) use ($fontPath) {
                $font->file($fontPath);
                $font->size(22);
                $font->color('#6b7280');
                $font->align('center');
            }
        );

        // Signature
        $signaturePath = storage_path('app/public/templates/signature.png');

        if (file_exists($signaturePath)) {
            $signature = Image::read($signaturePath)
                ->resize(220, 120);

            $img->place($signature, 'bottom-left', 120, 140);
        }

        // Save file
        $filename = "cert_" . $artwork->id . "_" . time() . ".png";
        $relativePath = "certificates/" . $filename;

        $img->toPng()->save(storage_path("app/public/" . $relativePath));

        // Save DB
        Certificate::create([
            'user_id'    => $artwork->student->id,
            'artwork_id' => $artwork->id,
            'image_path' => $relativePath,
        ]);
    }
}