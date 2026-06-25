@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-100 py-6 sm:py-10">
<div class="max-w-7xl mx-auto px-4 sm:px-6 bg-white rounded-3xl shadow-xl p-6 sm:p-10">

    <!-- Header -->
    <div class="mb-7 sm:mb-10 border-b border-slate-200 pb-5 sm:pb-6">
        <a href="{{ route('teacher.grading.index', ['competition_id' => $artwork->competition_id]) }}"
           class="text-sm text-slate-500 hover:text-slate-700 transition">← Back to Submissions</a>

        <div class="flex flex-wrap justify-between items-center mt-4 gap-3">
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Grade Submission</h1>
            @php
                $statusColors = ['pending' => 'bg-amber-100 text-amber-700', 'graded' => 'bg-emerald-100 text-emerald-700'];
            @endphp
            <span class="px-4 py-1.5 rounded-full text-xs font-semibold uppercase tracking-wide
                {{ $statusColors[$artwork->status] ?? 'bg-slate-200 text-slate-600' }}">
                {{ ucfirst($artwork->status) }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-12">

        <!-- LEFT -->
        <div class="space-y-6 sm:space-y-8">

            <div class="bg-slate-50 rounded-2xl p-4 sm:p-6 border border-slate-200 shadow-sm">
                <img src="{{ asset('storage/' . $artwork->image_path) }}"
                     class="w-full rounded-xl shadow-md max-h-[350px] sm:max-h-none object-contain" alt="Artwork">
            </div>

            <div class="bg-slate-50 rounded-2xl p-6 sm:p-8 border border-slate-200">
                <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-5 sm:mb-6">Submission Details</h3>
                <div class="space-y-3 sm:space-y-4 text-sm">
                    <div class="flex justify-between gap-3">
                        <span class="text-slate-500">Title</span>
                        <span class="font-semibold text-slate-800 text-right">{{ $artwork->title }}</span>
                    </div>
                    <div class="flex justify-between gap-3">
                        <span class="text-slate-500">Student</span>
                        <span class="font-semibold text-slate-800 text-right">{{ optional($artwork->student)->name ?? 'Unknown Student' }}</span>
                    </div>
                    <div class="flex justify-between gap-3">
                        <span class="text-slate-500">Email</span>
                        <span class="font-medium text-slate-700 text-xs text-right break-all">{{ optional($artwork->student)->email ?? 'No Email Available' }}</span>
                    </div>
                    <div class="flex justify-between gap-3">
                        <span class="text-slate-500">Competition</span>
                        <span class="font-semibold text-slate-800 text-right">{{ optional($artwork->competition)->title ?? 'N/A' }}</span>
                    </div>
                </div>

                @if($artwork->description)
                    <div class="mt-5 sm:mt-6 pt-5 sm:pt-6 border-t border-slate-200">
                        <p class="text-slate-500 text-xs uppercase tracking-wide mb-2">Description</p>
                        <p class="text-slate-700 leading-relaxed text-sm">"{{ $artwork->description }}"</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- RIGHT -->
        <div>
            <h3 class="text-lg sm:text-xl font-semibold text-slate-900 mb-6 sm:mb-8">Provide Feedback</h3>

            @if(session('success'))
                <div class="bg-emerald-100 border border-emerald-300 text-emerald-700 px-4 py-3 rounded-xl mb-5 sm:mb-6 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-rose-100 border border-rose-300 text-rose-700 px-4 py-3 rounded-xl mb-5 sm:mb-6">
                    <ul class="list-disc ml-5 text-sm">
                        @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('teacher.grading.update', $artwork->id) }}" class="space-y-6 sm:space-y-8">
                @csrf @method('PUT')
                <input type="hidden" name="competition_id" value="{{ $artwork->competition_id }}">

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Score (0 - 100)</label>
                    <div class="relative">
                        <input type="number" name="score" min="0" max="100" required
                               value="{{ old('score', $artwork->score) }}"
                               class="w-full px-4 py-3 rounded-2xl border border-slate-300 focus:ring-2 focus:ring-slate-900 focus:outline-none transition text-sm">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm">/100</span>
                    </div>
                    <p class="text-xs text-slate-500 mt-2">Enter a value between 0 and 100.</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Feedback & Comments</label>
                    <textarea name="feedback" rows="6" sm:rows="8"
                              class="w-full px-4 py-3 rounded-2xl border border-slate-300 focus:ring-2 focus:ring-slate-900 focus:outline-none transition text-sm"
                              placeholder="Write constructive feedback for the student...">{{ old('feedback', $artwork->feedback) }}</textarea>
                    <p class="text-xs text-slate-500 mt-2">Visible to student and caregiver.</p>
                </div>

                <button type="submit"
                        class="w-full py-3 rounded-2xl bg-slate-900 text-white font-semibold hover:bg-black transition shadow-md text-sm">
                    Update Grade & Feedback
                </button>
            </form>

            <!-- Certificate -->
            <div class="mt-6 sm:mt-8 pt-6 sm:pt-8 border-t border-slate-200">
                <form action="{{ route('teacher.grading.generate', $artwork->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="w-full py-3 rounded-2xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition shadow-md text-sm">
                        Generate Certificate
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
</div>
@endsection