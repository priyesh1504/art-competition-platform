@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-slate-100 via-white to-slate-200 py-8 sm:py-16">
<div class="max-w-3xl mx-auto px-4 sm:px-6">

    <!-- Back Button -->
    <div class="mb-5 sm:mb-6">
        <a href="{{ route('student.portfolio.index') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-slate-900 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Portfolio
        </a>
    </div>

    <!-- Card -->
    <div class="bg-white/80 backdrop-blur-xl border border-white/40 shadow-2xl rounded-3xl p-6 sm:p-10">

        <div class="mb-7 sm:mb-10">
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Edit Portfolio Item</h1>
            <p class="text-sm text-slate-500 mt-2">Update your artwork details and portfolio information.</p>
        </div>

        <form method="POST" action="{{ route('student.portfolio.update', $artwork->id) }}" class="space-y-5 sm:space-y-8">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Title</label>
                <input type="text" name="title" value="{{ $artwork->title }}" required
                       class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm
                              focus:outline-none focus:ring-2 focus:ring-slate-900 transition">
            </div>

            <!-- Art Style -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Art Style</label>
                <select name="art_style" required
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm
                               focus:outline-none focus:ring-2 focus:ring-slate-900 transition">
                    <option value="Sketching" {{ $artwork->art_style === 'Sketching' ? 'selected' : '' }}>Sketching</option>
                    <option value="Watercolour" {{ $artwork->art_style === 'Watercolour' ? 'selected' : '' }}>Watercolour</option>
                    <option value="Digital" {{ $artwork->art_style === 'Digital' ? 'selected' : '' }}>Digital Art</option>
                    <option value="Oil Pastels" {{ $artwork->art_style === 'Oil Pastels' ? 'selected' : '' }}>Oil Pastels</option>
                    <option value="Acrylics" {{ $artwork->art_style === 'Acrylics' ? 'selected' : '' }}>Acrylics</option>
                    <option value="Madhubani" {{ $artwork->art_style === 'Madhubani' ? 'selected' : '' }}>Madhubani</option>
                    <option value="Warli" {{ $artwork->art_style === 'Warli' ? 'selected' : '' }}>Warli</option>
                </select>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Description</label>
                <textarea name="description" rows="4"
                          class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm
                                 focus:outline-none focus:ring-2 focus:ring-slate-900 transition">{{ $artwork->description }}</textarea>
            </div>

            <!-- Current Image -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-3">Artwork Image</label>
                <div class="rounded-2xl overflow-hidden border border-slate-200 shadow-sm">
                    <img src="{{ asset('storage/'.$artwork->image_path) }}"
                         alt="Artwork Image"
                         class="w-full h-56 sm:h-72 object-cover">
                </div>
                <p class="text-xs text-slate-500 mt-2">Image cannot be changed once uploaded.</p>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-2">
                <a href="{{ route('student.portfolio.index') }}"
                   class="text-sm font-semibold text-slate-500 hover:text-slate-800 transition order-2 sm:order-1">
                    Cancel
                </a>
                <button type="submit"
                        class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-slate-900 text-white
                               font-semibold hover:bg-black transition shadow-lg text-sm order-1 sm:order-2">
                    Update Portfolio
                </button>
            </div>
        </form>
    </div>

</div>
</div>

@endsection