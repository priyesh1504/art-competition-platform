@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 py-8 sm:py-12">
<div class="max-w-3xl mx-auto px-4 sm:px-6">

    <!-- Back Button -->
    <div class="mb-5 sm:mb-6">
        <a href="{{ route('admin.dashboard') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-slate-900 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Dashboard
        </a>
    </div>

    <!-- Header -->
    <div class="mb-7 sm:mb-10">
        <h1 class="text-2xl sm:text-4xl font-bold text-slate-900 tracking-tight">
            Create Competition
        </h1>
        <p class="text-slate-500 mt-2 text-sm">
            Set up a new competition for students to participate in.
        </p>
    </div>

    <!-- Form Card -->
    <div id="competitionForm" class="bg-white border border-slate-200 rounded-3xl shadow-xl p-6 sm:p-8">

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200">
                <p class="text-rose-700 font-semibold text-sm">Please fix the errors below.</p>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.competitions.store') }}" class="space-y-6 sm:space-y-8">
            @csrf

            <!-- Title -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Competition Title
                </label>
                <input type="text" name="title"
                       value="{{ old('title') }}"
                       placeholder="National Painting Competition 2026"
                       class="w-full px-5 py-3 rounded-2xl border text-sm
                       @error('title') border-rose-400 ring-2 ring-rose-200 @else border-slate-300 @enderror
                       focus:ring-2 focus:ring-slate-900 focus:outline-none"
                       required>
                @error('title')
                    <p class="text-sm text-rose-600 mt-2 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Description
                </label>
                <textarea name="description" rows="4"
                          placeholder="Describe the competition, theme, eligibility, and key details (minimum 50 characters)..."
                          class="w-full px-5 py-3 rounded-2xl border border-slate-300 focus:ring-2 focus:ring-slate-900 focus:outline-none text-sm"
                          required>{{ old('description') }}</textarea>
                <p class="text-xs text-slate-400 mt-2">Must be at least 50 characters.</p>
                @error('description')
                    <p class="text-sm text-rose-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Rules -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Rules & Guidelines
                </label>
                <textarea name="rules" rows="3"
                          placeholder="Submit original work only, no plagiarism..."
                          class="w-full px-5 py-3 rounded-2xl border border-slate-300 focus:ring-2 focus:ring-slate-900 focus:outline-none text-sm">{{ old('rules') }}</textarea>
            </div>

            <!-- Dates -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Competition Start Date
                    </label>
                    <input type="datetime-local" name="start_date"
                           value="{{ old('start_date') }}"
                           class="w-full px-5 py-3 rounded-2xl border border-slate-300 focus:ring-2 focus:ring-slate-900 focus:outline-none text-sm"
                           required>
                    @error('start_date')
                        <p class="text-sm text-rose-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Submission Deadline
                    </label>
                    <input type="datetime-local" name="deadline"
                           value="{{ old('deadline') }}"
                           class="w-full px-5 py-3 rounded-2xl border border-slate-300 focus:ring-2 focus:ring-slate-900 focus:outline-none text-sm"
                           required>
                    @error('deadline')
                        <p class="text-sm text-rose-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Fee -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Entry Fee (INR)
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-medium text-sm">₹</span>
                    <input type="number" name="fee"
                           step="0.01" min="0"
                           value="{{ old('fee') }}"
                           placeholder="0.00"
                           class="w-full pl-10 pr-4 py-3 rounded-2xl border border-slate-300 focus:ring-2 focus:ring-slate-900 focus:outline-none text-sm">
                </div>
                @error('fee')
                    <p class="text-sm text-rose-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-5 sm:pt-6 border-t border-slate-200">
                <a href="{{ route('admin.dashboard') }}"
                   class="text-sm font-semibold text-slate-500 hover:text-black transition order-2 sm:order-1">
                    Cancel
                </a>
                <button type="submit"
                        class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-slate-900 text-white font-semibold shadow hover:bg-black transition text-sm order-1 sm:order-2">
                    Create Competition
                </button>
            </div>

        </form>
    </div>

</div>
</div>

@if ($errors->any())
<script>
    window.onload = function () {
        document.getElementById('competitionForm').scrollIntoView({ behavior: 'smooth', block: 'center' });
    };
</script>
@endif

@endsection