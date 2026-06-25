<?php

namespace App\Http\Controllers;

use App\Models\Certificate;

class StudentCertificateController extends Controller
{
    public function index()
    {
        // Get certificates that belong to logged-in student
        $certificates = Certificate::where('user_id', auth()->id())
            ->with(['artwork.competition'])
            ->latest()
            ->get();

        return view('student.certificates', compact('certificates'));
    }
}
