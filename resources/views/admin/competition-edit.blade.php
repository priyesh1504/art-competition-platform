@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 py-8 sm:py-14">
<div class="max-w-3xl mx-auto px-4 sm:px-6">

    <!-- Back Button -->
    <div class="mb-5 sm:mb-6">
        <a href="{{ route('admin.dashboard') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-slate-900 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Dashboard
        </a>
    </div>

    <!-- Card -->
    <div class="bg-white border border-slate-200 rounded-3xl shadow-xl p-6 sm:p-10">

        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">
                Edit Competition
            </h1>
            <p class="text-slate-500 text-sm mt-2">
                Update the details of your competition.
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700">
                <ul class="text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.competitions.update', $competition->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-5 sm:mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Competition Title</label>
                <input type="text" name="title" required
                       value="{{ old('title', $competition->title) }}"
                       placeholder="International Art Contest 2026"
                       class="w-full px-4 py-3 rounded-2xl border border-slate-300 focus:ring-2 focus:ring-slate-900 focus:outline-none transition text-sm">
            </div>

            <div class="mb-5 sm:mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Description</label>
                <textarea name="description" rows="4" required
                          placeholder="Describe the competition (minimum 50 characters)..."
                          class="w-full px-4 py-3 rounded-2xl border border-slate-300 focus:ring-2 focus:ring-slate-900 focus:outline-none transition text-sm">{{ old('description', $competition->description) }}</textarea>
                <p class="text-xs text-slate-500 mt-2">Must be at least 50 characters.</p>
            </div>

            <div class="mb-5 sm:mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Rules (Optional)</label>
                <textarea name="rules" rows="3"
                          placeholder="No plagiarism, submit original artwork..."
                          class="w-full px-4 py-3 rounded-2xl border border-slate-300 focus:ring-2 focus:ring-slate-900 focus:outline-none transition text-sm">{{ old('rules', $competition->rules) }}</textarea>
            </div>

            <div class="mb-5 sm:mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Start Date</label>
                <input type="datetime-local" name="start_date" required
                       value="{{ old('start_date', $competition->start_date ? $competition->start_date->format('Y-m-d\TH:i') : '') }}"
                       class="w-full px-4 py-3 rounded-2xl border border-slate-300 focus:ring-2 focus:ring-slate-900 focus:outline-none transition text-sm">
            </div>

            <div class="mb-5 sm:mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Submission Deadline</label>
                <input type="datetime-local" name="deadline" required
                       value="{{ old('deadline', $competition->deadline ? $competition->deadline->format('Y-m-d\TH:i') : '') }}"
                       class="w-full px-4 py-3 rounded-2xl border border-slate-300 focus:ring-2 focus:ring-slate-900 focus:outline-none transition text-sm">
            </div>

            <div class="mb-8 sm:mb-10">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Competition Fee</label>
                <input type="text"
                       value="₹{{ number_format($competition->fee, 2) }}"
                       class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-100 text-slate-600 text-sm"
                       readonly>
                <p class="text-xs text-slate-500 mt-2">Competition fee cannot be changed after creation.</p>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                <a href="{{ route('admin.dashboard') }}"
                   class="text-sm text-slate-500 hover:text-slate-700 transition order-2 sm:order-1">
                    Cancel
                </a>
                <button type="submit"
                        class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-slate-900 text-white font-semibold hover:bg-black transition shadow text-sm order-1 sm:order-2">
                    Update Competition
                </button>
            </div>

        </form>
    </div>

</div>
</div>

@endsection