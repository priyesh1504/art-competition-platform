@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 py-8 sm:py-14">
<div class="max-w-7xl mx-auto px-4 sm:px-6">

    <!-- Back Button -->
    <div class="mb-5 sm:mb-6">
        <a href="{{ route('student.dashboard') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-slate-900 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Dashboard
        </a>
    </div>

    <!-- Header + Stats -->
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-6 sm:p-8 mb-8 sm:mb-12">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5 sm:gap-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">
                    My Certificates
                </h1>
                <p class="text-sm text-slate-500 mt-2">
                    Official awards and recognitions earned through competitions.
                </p>
            </div>
            <div class="text-center sm:text-right">
                <div class="text-2xl sm:text-3xl font-bold text-amber-600">
                    {{ $certificates->count() }}
                </div>
                <div class="text-xs uppercase tracking-wide text-slate-500">Certificates Earned</div>
            </div>
        </div>
    </div>

    <!-- Certificates Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-8">

        @forelse($certificates as $cert)

        <div class="group bg-white rounded-3xl shadow-md border border-slate-200
                    hover:shadow-2xl hover:-translate-y-1 transition duration-300 overflow-hidden">

            <!-- Preview -->
            <div class="relative h-48 sm:h-56 bg-slate-50 flex items-center justify-center overflow-hidden">
                <img src="{{ asset('storage/' . $cert->image_path) }}"
                     class="max-h-full object-contain group-hover:scale-105 transition duration-500">
                <div class="absolute top-4 right-4 bg-amber-500 text-white text-xs font-semibold px-3 py-1 rounded-full shadow">
                    Award
                </div>
            </div>

            <!-- Content -->
            <div class="p-5 sm:p-6 text-center space-y-3 sm:space-y-4">
                <h3 class="font-semibold text-slate-900 text-base sm:text-lg leading-snug">
                    {{ $cert->artwork->competition->title }}
                </h3>
                <p class="text-sm text-slate-500">
                    Awarded on {{ $cert->created_at->format('M d, Y') }}
                </p>
                <div class="text-xs text-slate-400">
                    Artwork: <span class="font-medium text-slate-600">{{ $cert->artwork->title }}</span>
                </div>

                <!-- Actions -->
                <div class="pt-3 sm:pt-4 border-t border-slate-200 flex flex-col gap-2 sm:gap-3">
                    <a href="{{ asset('storage/' . $cert->image_path) }}"
                       target="_blank"
                       class="w-full py-2 rounded-xl border border-slate-300 text-slate-700 font-semibold
                              hover:bg-slate-100 transition text-sm">
                        Preview
                    </a>
                    <a href="{{ asset('storage/' . $cert->image_path) }}"
                       download
                       class="w-full py-2 rounded-xl bg-slate-900 text-white font-semibold
                              hover:bg-black transition shadow text-sm">
                        Download Certificate
                    </a>
                </div>
            </div>
        </div>

        @empty
        <div class="col-span-full bg-white rounded-3xl shadow-xl border border-slate-200 py-16 sm:py-20 text-center">
            <h2 class="text-lg sm:text-xl font-semibold text-slate-800 mb-3">No certificates yet</h2>
            <p class="text-slate-500 text-sm">Submit artwork to competitions and earn official recognition.</p>
        </div>
        @endforelse

    </div>

</div>
</div>

@endsection