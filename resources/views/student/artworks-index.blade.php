@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-slate-100 via-white to-slate-200 py-8 sm:py-16">
<div class="max-w-7xl mx-auto px-4 sm:px-6">

    <!-- Back Button -->
    <div class="mb-5 sm:mb-6">
        <a href="{{ route('student.dashboard') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-slate-900 transition">
            ← Back to Dashboard
        </a>
    </div>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 sm:gap-6 mb-8 sm:mb-10">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">My Artworks</h1>
            <p class="text-sm text-slate-500 mt-2">Manage and track all your submissions.</p>
        </div>
        <a href="{{ route('student.artworks.create') }}"
           class="px-5 py-3 rounded-2xl bg-slate-900 text-white text-sm font-semibold hover:bg-black transition shadow-lg self-start sm:self-auto">
            Submit Artwork
        </a>
    </div>

    <!-- Filter Bar -->
    <form id="filterForm" method="GET"
          class="bg-white/80 backdrop-blur-xl border border-slate-200
                 rounded-3xl shadow-lg p-4 sm:p-6 mb-8 sm:mb-10
                 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">

        <input type="text" name="search" id="searchInput"
               value="{{ request('search') }}"
               placeholder="Search title..."
               class="rounded-2xl border border-slate-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900">

        <select name="status" onchange="autoSubmit()"
                class="rounded-2xl border border-slate-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900">
            <option value="">All Status</option>
            <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
            <option value="reviewed" {{ request('status')=='reviewed'?'selected':'' }}>Reviewed</option>
        </select>

        <select name="sort" onchange="autoSubmit()"
                class="rounded-2xl border border-slate-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900">
            <option value="">Latest</option>
            <option value="score_high" {{ request('sort')=='score_high'?'selected':'' }}>Highest Score</option>
            <option value="score_low" {{ request('sort')=='score_low'?'selected':'' }}>Lowest Score</option>
        </select>

        <button type="submit"
                class="rounded-2xl bg-slate-900 text-white font-semibold hover:bg-black transition text-sm py-3">
            Apply
        </button>

    </form>

    <!-- Grid -->
    @if($artworks->isEmpty())
        <div class="bg-white rounded-3xl py-16 sm:py-20 text-center shadow-xl">
            <h2 class="text-lg sm:text-xl font-semibold text-slate-800 mb-3">No artworks found</h2>
            <p class="text-slate-400 text-sm">Try adjusting your filters or submit a new artwork.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-8">

            @foreach($artworks as $artwork)
            @php
                $scoreColor = 'text-slate-400';
                if ($artwork->score !== null) {
                    if ($artwork->score <= 40) $scoreColor = 'text-red-600';
                    elseif ($artwork->score <= 75) $scoreColor = 'text-yellow-600';
                    else $scoreColor = 'text-green-600';
                }
            @endphp

            <div class="bg-white rounded-3xl shadow-lg overflow-hidden">
                <div class="h-52 sm:h-60 overflow-hidden">
                    <img src="{{ asset('storage/'.$artwork->image_path) }}"
                         class="w-full h-full object-cover">
                </div>
                <div class="p-5 sm:p-6 space-y-3">
                    <h2 class="font-semibold text-slate-900 truncate text-base">
                        {{ $artwork->title }}
                    </h2>
                    <p class="text-sm text-slate-600 line-clamp-2">
                        {{ $artwork->description ?? 'No description.' }}
                    </p>
                    <p class="text-xs text-slate-500">
                        🎨 {{ $artwork->competition->title ?? 'No competition' }}
                    </p>
                    <p class="text-xs font-medium {{ $scoreColor }}">
                        🏆 Score: {{ $artwork->score ?? 'Not graded yet' }}
                    </p>
                    <p class="text-xs text-slate-500">
                        👨‍🏫 {{ $artwork->grader->name ?? 'Not graded yet' }}
                    </p>
                    <div class="flex justify-between items-center text-xs pt-2 border-t">
                        <span class="px-2 py-1 rounded-full font-semibold
                            {{ $artwork->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                            {{ ucfirst($artwork->status) }}
                        </span>
                        <span class="text-slate-400">
                            {{ $artwork->created_at->format('M d, Y') }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach

        </div>

        <div class="mt-8 sm:mt-12">
            {{ $artworks->links() }}
        </div>
    @endif

</div>
</div>

<script>
let timer;
function autoSubmit() {
    document.getElementById('filterForm').submit();
}
document.getElementById('searchInput').addEventListener('input', function () {
    clearTimeout(timer);
    timer = setTimeout(() => autoSubmit(), 500);
});
</script>

@endsection