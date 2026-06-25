@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-100 py-6 sm:py-10 px-4 sm:px-6">
    <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-xl p-6 sm:p-10">

        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6 sm:mb-8">
            <a href="{{ route('teacher.dashboard') }}" class="text-sm text-slate-500 hover:text-slate-700 transition">
                ← Back to Dashboard
            </a>
            <a href="{{ route('teacher.competitions.edit', $competition->id) }}"
               class="px-5 py-2.5 rounded-2xl bg-amber-500 text-white font-semibold hover:bg-amber-600 transition shadow-sm text-sm">
                Edit Competition
            </a>
        </div>

        @php
            $statusColors = [
                'upcoming' => 'bg-blue-100 text-blue-700',
                'ongoing' => 'bg-emerald-100 text-emerald-700',
                'completed' => 'bg-slate-200 text-slate-600',
                'cancelled' => 'bg-rose-100 text-rose-700',
            ];
            $status = $competition->computed_status;
        @endphp

        <div class="mb-4">
            <span class="px-4 py-1.5 rounded-full text-xs font-semibold uppercase tracking-wide
                {{ $statusColors[$status] ?? 'bg-slate-100 text-slate-600' }}">
                {{ ucfirst($status) }}
            </span>
        </div>

        <h1 class="text-2xl sm:text-4xl font-bold text-slate-800 mb-6 sm:mb-8 leading-tight">
            {{ $competition->title }}
        </h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-8">

            <div class="bg-slate-50 p-5 sm:p-6 rounded-2xl border border-slate-100">
                <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-3">Description</h3>
                <p class="text-slate-700 leading-relaxed break-words text-sm">{{ $competition->description }}</p>
            </div>

            @if($competition->rules)
            <div class="bg-slate-50 p-5 sm:p-6 rounded-2xl border border-slate-100">
                <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-3">Rules</h3>
                <p class="text-slate-700 leading-relaxed break-words text-sm">{{ $competition->rules }}</p>
            </div>
            @endif

            <div class="bg-slate-50 p-5 sm:p-6 rounded-2xl border border-slate-100">
                <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-3">Start Date</h3>
                <p class="text-slate-800 font-medium text-sm">
                    {{ $competition->start_date ? $competition->start_date->format('F j, Y \a\t g:i A') : 'N/A' }}
                </p>
            </div>

            <div class="bg-slate-50 p-5 sm:p-6 rounded-2xl border border-slate-100">
                <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-3">Deadline</h3>
                <p class="text-slate-800 font-medium text-sm">
                    {{ $competition->deadline ? $competition->deadline->format('F j, Y \a\t g:i A') : 'N/A' }}
                </p>
            </div>

            <div class="bg-slate-50 p-5 sm:p-6 rounded-2xl border border-slate-100">
                <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-3">Entry Fee</h3>
                <p class="text-slate-800 font-medium text-base sm:text-lg">
                    @if($competition->fee && $competition->fee > 0)
                        ₹{{ number_format($competition->fee, 2) }}
                    @else
                        <span class="text-emerald-600 font-semibold">Free Entry</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
@endsection