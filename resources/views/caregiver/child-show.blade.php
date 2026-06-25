@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-100 via-white to-slate-200 py-8 sm:py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">

        <!-- Back Button -->
        <a href="{{ route('caregiver.dashboard') }}"
           class="inline-flex items-center gap-2 mb-6 sm:mb-8 px-4 py-2 rounded-xl
                  bg-white/70 backdrop-blur border border-slate-200
                  text-slate-700 font-medium shadow-sm text-sm
                  hover:bg-white hover:shadow-md transition">
            ← Back to Dashboard
        </a>

        <!-- Header -->
        <div class="mb-8 sm:mb-12">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-900 tracking-tight">
                {{ $child->name }}'s Dashboard
            </h1>
            <p class="text-slate-500 mt-2 text-base sm:text-lg">
                Manage and track student activities in one place
            </p>
        </div>

        <!-- Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-8">

            <!-- Submissions -->
            <a href="{{ route('caregiver.submissions.show', $child->id) }}"
               class="group bg-white/70 backdrop-blur border border-slate-200
                      rounded-2xl p-5 sm:p-6 shadow-sm
                      hover:shadow-xl hover:-translate-y-1 transition duration-300">
                <div class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center rounded-xl
                            bg-indigo-50 text-xl sm:text-2xl mb-4
                            group-hover:bg-indigo-100 transition">📂</div>
                <h2 class="text-base sm:text-lg font-semibold text-slate-800 group-hover:text-indigo-600 transition">Submissions</h2>
                <p class="text-sm text-slate-500 mt-1">View all artworks submitted</p>
            </a>

            <!-- Certificates -->
            <a href="{{ route('caregiver.certificates.show', $child->id) }}"
               class="group bg-white/70 backdrop-blur border border-slate-200
                      rounded-2xl p-5 sm:p-6 shadow-sm
                      hover:shadow-xl hover:-translate-y-1 transition duration-300">
                <div class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center rounded-xl
                            bg-amber-50 text-xl sm:text-2xl mb-4
                            group-hover:bg-amber-100 transition">🏆</div>
                <h2 class="text-base sm:text-lg font-semibold text-slate-800 group-hover:text-amber-600 transition">Certificates</h2>
                <p class="text-sm text-slate-500 mt-1">Awards and achievements</p>
            </a>

            <!-- Performance -->
            <a href="{{ route('caregiver.performance', $child->id) }}"
               class="group bg-white/70 backdrop-blur border border-slate-200
                      rounded-2xl p-5 sm:p-6 shadow-sm
                      hover:shadow-xl hover:-translate-y-1 transition duration-300">
                <div class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center rounded-xl
                            bg-emerald-50 text-xl sm:text-2xl mb-4
                            group-hover:bg-emerald-100 transition">📊</div>
                <h2 class="text-base sm:text-lg font-semibold text-slate-800 group-hover:text-emerald-600 transition">Performance</h2>
                <p class="text-sm text-slate-500 mt-1">Score progress & analytics</p>
            </a>

        </div>
    </div>
</div>
@endsection