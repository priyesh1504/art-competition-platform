@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-6 sm:mt-10 px-4 max-w-7xl">

    <div class="bg-white shadow-2xl rounded-3xl overflow-hidden border border-gray-100">

        <!-- Header -->
        <div class="px-5 sm:px-8 py-5 sm:py-6 border-b bg-gray-50 flex flex-col gap-3 sm:flex-row sm:justify-between sm:items-center">

            <div class="space-y-2">
                <a href="{{ route('admin.grading.index', ['competition_id' => $artwork->competition_id]) }}"
                   class="text-sm font-semibold text-gray-600 hover:text-black transition">
                    ← Back to Submissions
                </a>

                <div class="flex flex-wrap items-center gap-3">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                        Grade Submission
                    </h1>
                    <span class="px-4 py-1.5 rounded-full text-xs font-bold tracking-wide uppercase
                        @if($artwork->status === 'pending') bg-yellow-100 text-yellow-700
                        @else bg-gray-900 text-white
                        @endif">
                        {{ ucfirst($artwork->status) }}
                    </span>
                </div>
            </div>

        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-12 p-5 sm:p-8">

            <!-- LEFT COLUMN -->
            <div class="space-y-6 sm:space-y-8">

                <!-- Artwork Preview -->
                <div class="bg-gray-100 rounded-2xl p-3 sm:p-4 shadow-inner">
                    <img
                        src="{{ asset('storage/' . $artwork->image_path) }}"
                        class="w-full rounded-2xl object-contain max-h-[300px] sm:max-h-[500px] mx-auto shadow-lg"
                        alt="Artwork Submission"
                    >
                </div>

                <!-- Submission Info -->
                <div class="bg-white border border-gray-200 rounded-2xl p-5 sm:p-6 shadow-sm">

                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-5 sm:mb-6">
                        Submission Information
                    </h3>

                    <div class="space-y-3 sm:space-y-4 text-sm">
                        <div class="flex justify-between gap-4">
                            <span class="text-gray-500 flex-shrink-0">Title</span>
                            <span class="font-semibold text-gray-900 text-right">{{ $artwork->title }}</span>
                        </div>
                        <div class="flex justify-between gap-4">
                            <span class="text-gray-500 flex-shrink-0">Student</span>
                            <span class="font-semibold text-gray-900 text-right">
                                {{ optional($artwork->student)->name ?? 'Unknown Student' }}
                            </span>
                        </div>
                        <div class="flex justify-between gap-4">
                            <span class="text-gray-500 flex-shrink-0">Email</span>
                            <span class="font-medium text-gray-700 text-xs text-right break-all">
                                {{ optional($artwork->student)->email ?? 'No Email Available' }}
                            </span>
                        </div>
                        <div class="flex justify-between gap-4">
                            <span class="text-gray-500 flex-shrink-0">Competition</span>
                            <span class="font-semibold text-gray-900 text-right">
                                {{ optional($artwork->competition)->title ?? 'Not Assigned' }}
                            </span>
                        </div>
                    </div>

                    @if($artwork->description)
                        <div class="mt-5 sm:mt-6 pt-5 sm:pt-6 border-t border-gray-200">
                            <p class="text-gray-500 font-medium mb-2 text-sm">Description</p>
                            <p class="text-gray-800 text-sm leading-relaxed italic bg-gray-50 p-4 rounded-xl">
                                "{{ $artwork->description }}"
                            </p>
                        </div>
                    @endif
                </div>

            </div>

            <!-- RIGHT COLUMN -->
            <div class="space-y-6 sm:space-y-8 lg:border-l lg:pl-10">

                <h3 class="text-lg sm:text-xl font-bold text-gray-900">
                    Grading & Feedback
                </h3>

                @if(session('success'))
                    <div class="bg-gray-100 border border-gray-200 text-gray-800 px-5 py-4 rounded-xl text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl">
                        <ul class="list-disc ml-5 space-y-1 text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Grading Card -->
                <div class="bg-white border border-gray-200 rounded-2xl p-5 sm:p-6 shadow-sm">
                    <form method="POST"
                          action="{{ route('admin.grading.update', $artwork->id) }}"
                          class="space-y-5 sm:space-y-6">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="competition_id" value="{{ $artwork->competition_id }}">

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Score (0 – 100)
                            </label>
                            <input
                                type="number" name="score"
                                min="0" max="100" required
                                value="{{ old('score', $artwork->score) }}"
                                class="w-full rounded-xl border-gray-300 px-4 py-3 focus:ring-2 focus:ring-gray-900 focus:border-gray-900 text-sm"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Feedback & Comments
                            </label>
                            <textarea
                                name="feedback" rows="5"
                                class="w-full rounded-xl border-gray-300 px-4 py-3 focus:ring-2 focus:ring-gray-900 focus:border-gray-900 text-sm"
                            >{{ old('feedback', $artwork->feedback) }}</textarea>
                        </div>

                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 bg-gray-900 hover:bg-black text-white font-semibold py-3 rounded-xl shadow-sm hover:shadow-lg transition duration-200 text-sm">
                            Update Grade & Feedback
                        </button>
                    </form>
                </div>

                <!-- Certificate Section -->
                <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5 sm:p-6">
                    <h4 class="text-sm font-semibold text-gray-700 mb-4 uppercase tracking-wide">
                        Certificate Management
                    </h4>
                    <form action="{{ route('admin.grading.generate', $artwork->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 bg-white hover:bg-gray-100 text-gray-900 font-semibold py-3 rounded-xl border border-gray-300 shadow-sm hover:shadow-md transition duration-200 text-sm">
                            Generate Certificate Manually
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection