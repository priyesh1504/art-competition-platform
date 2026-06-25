@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-100 via-white to-slate-200 py-8 sm:py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">

        <!-- Back Button -->
        <a href="{{ route('caregiver.children.show', $child->id) }}"
           class="inline-block mb-5 sm:mb-6 px-4 py-2 bg-indigo-100 text-indigo-700 rounded-lg font-medium hover:bg-indigo-200 transition text-sm">
            ← Back to {{ $child->name }}'s Dashboard
        </a>

        <!-- Title -->
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold mb-8 sm:mb-10 text-slate-900">
            {{ $child->name }} — Submissions
        </h1>

        <!-- Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 sm:gap-8">

            @forelse($submissions as $submission)
            @php
                $scoreColor = 'text-slate-400';
                if ($submission->score !== null) {
                    if ($submission->score <= 40) $scoreColor = 'text-red-600';
                    elseif ($submission->score <= 75) $scoreColor = 'text-yellow-600';
                    else $scoreColor = 'text-green-600';
                }
            @endphp

            <div class="bg-white/70 backdrop-blur-lg border border-white/30 rounded-3xl shadow-lg
                        hover:shadow-2xl transition hover:scale-105 overflow-hidden">
                <img src="{{ asset('storage/'.$submission->image_path) }}"
                     class="w-full h-44 sm:h-48 object-cover">
                <div class="p-4 sm:p-5 space-y-2">
                    <p class="text-sm text-slate-500">🎨 {{ $submission->competition->title ?? 'Competition' }}</p>
                    <h2 class="font-semibold text-base sm:text-lg text-slate-900">{{ $submission->title }}</h2>
                    <p class="text-sm text-slate-600 line-clamp-2">
                        {{ $submission->description ?? 'No description provided.' }}
                    </p>
                    <p class="font-medium {{ $scoreColor }} text-sm mt-2">
                        🏆 Score: {{ $submission->score ?? 'Not graded yet' }}
                    </p>
                </div>
            </div>

            @empty
            <p class="text-slate-400 col-span-full text-center italic text-sm">No submissions found</p>
            @endforelse

        </div>

        @if($submissions->hasPages())
        <div class="mt-8 sm:mt-12 flex justify-center">
            {{ $submissions->links() }}
        </div>
        @endif

    </div>
</div>
@endsection