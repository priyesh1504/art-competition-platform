@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-slate-100 via-white to-slate-200 py-8 sm:py-16">
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

    <!-- Header -->
    <div class="bg-white/80 backdrop-blur-xl border border-white/40 rounded-3xl shadow-xl p-6 sm:p-8 mb-8 sm:mb-10">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 sm:gap-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">My Portfolio</h1>
                <p class="text-sm text-slate-500 mt-2">Your personal gallery and competition entries.</p>
            </div>
            <div class="text-sm text-slate-500">
                Total Artworks
                <span class="block text-xl sm:text-2xl font-bold text-slate-900">{{ $artworks->count() }}</span>
            </div>
        </div>
    </div>

    <!-- Style Filters -->
    @php $styles = ['Sketching', 'Watercolour', 'Digital', 'Oil Pastels', 'Acrylics', 'Madhubani', 'Warli']; @endphp
    <div class="flex flex-wrap gap-2 sm:gap-3 mb-8 sm:mb-10">
        <a href="{{ route('student.portfolio.index') }}"
           class="px-4 py-2 rounded-full text-sm font-semibold transition
                  {{ request()->style ? 'bg-slate-200 text-slate-700' : 'bg-slate-900 text-white shadow' }}">
            All Styles
        </a>
        @foreach($styles as $style)
            <a href="?style={{ $style }}"
               class="px-4 py-2 rounded-full text-sm font-semibold transition
                      {{ request()->style === $style
                         ? 'bg-slate-900 text-white shadow'
                         : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-100' }}">
                {{ $style }}
            </a>
        @endforeach
    </div>

    @if(session('success'))
        <div class="mb-6 sm:mb-8 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Portfolio Grid -->
    @forelse($artworks as $artwork)
        @if($loop->first) <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-8"> @endif

        <div class="group bg-white/80 backdrop-blur-xl border border-white/40
                    rounded-3xl shadow-lg overflow-hidden
                    hover:shadow-2xl hover:-translate-y-1 transition duration-300">

            <!-- Image -->
            <div class="relative h-48 sm:h-56 overflow-hidden">
                <img src="{{ asset('storage/' . $artwork->image_path) }}"
                     alt="{{ $artwork->title }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                <div class="absolute top-4 right-4">
                    @if($artwork->competition_id)
                        <span class="bg-amber-500 text-white text-xs font-semibold px-3 py-1 rounded-full shadow">Competition Entry</span>
                    @else
                        <span class="bg-purple-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow">Personal</span>
                    @endif
                </div>
            </div>

            <!-- Content -->
            <div class="p-5 sm:p-6 space-y-3 sm:space-y-4">
                <div class="flex justify-between items-start gap-2">
                    <h3 class="text-base sm:text-lg font-semibold text-slate-900 truncate">{{ $artwork->title }}</h3>
                    <span class="bg-slate-100 text-slate-700 text-xs px-3 py-1 rounded-full font-semibold uppercase flex-shrink-0">
                        {{ $artwork->art_style }}
                    </span>
                </div>
                <p class="text-sm text-slate-600 line-clamp-2">
                    {{ $artwork->description ?? 'No description provided.' }}
                </p>
                <div class="flex items-center justify-between pt-3 sm:pt-4 border-t border-slate-200 text-xs text-slate-500 flex-wrap gap-2">
                    <span>{{ $artwork->created_at->format('M d, Y') }}</span>
                    <div class="flex items-center gap-3 sm:gap-4">
                        @if($artwork->competition_id)
                            <span class="text-slate-400 hidden sm:inline">{{ $artwork->competition->title }}</span>
                        @endif
                        <a href="{{ route('student.portfolio.edit', $artwork->id) }}"
                           class="text-slate-700 hover:text-black font-semibold transition">Edit</a>
                        <form action="{{ route('student.portfolio.destroy', $artwork->id) }}"
                              method="POST" onsubmit="return confirm('Delete this artwork?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 font-semibold transition">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if($loop->last) </div> @endif

    @empty
        <div class="rounded-3xl bg-white/70 backdrop-blur-xl border border-slate-200 shadow-xl py-16 sm:py-20 text-center">
            <h2 class="text-lg sm:text-xl font-semibold text-slate-800 mb-3">No artworks yet</h2>
            <p class="text-slate-500 text-sm">Start building your portfolio by submitting your first artwork.</p>
        </div>
    @endforelse

</div>
</div>

@endsection