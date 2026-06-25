<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminTemplateController extends Controller
{
    public function index()
    {
        return view('admin.templates');
    }

    public function update(Request $request)
    {
        $request->validate([
            'certificate_bg' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'signature'      => 'nullable|image|mimes:png|max:5120',
        ]);

        /**
         * Save Certificate Background Template
         */
        if ($request->hasFile('certificate_bg')) {

            $image = $request->file('certificate_bg');

            [$width, $height] = getimagesize($image->getRealPath());

            // Required A4 landscape ratio: 1123 x 794
            $expectedRatio = 1123 / 794;
            $uploadedRatio = $width / $height;

            // Allow tiny floating-point difference
            if (abs($uploadedRatio - $expectedRatio) > 0.02) {
                throw ValidationException::withMessages([
                    'certificate_bg' => 'Certificate background must match A4 landscape ratio (1123 × 794).',
                ]);
            }

            // Minimum size check
            if ($width < 1123 || $height < 794) {
                throw ValidationException::withMessages([
                    'certificate_bg' => 'Certificate background must be at least 1123 × 794 pixels.',
                ]);
            }

            $image->storeAs(
                'templates',
                'cert_template.png',
                'public'
            );
        }

        /**
         * Save Signature Template
         */
        if ($request->hasFile('signature')) {

            $request->file('signature')
                ->storeAs(
                    'templates',
                    'signature.png',
                    'public'
                );
        }

        return back()->with('success', 'Templates updated successfully!');
    }
}