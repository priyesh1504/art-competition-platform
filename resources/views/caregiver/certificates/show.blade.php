@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 sm:py-12 px-4 sm:px-6">

    <!-- Back Button -->
    <a href="{{ route('caregiver.children.show', $child->id) }}"
       class="inline-block mb-6 sm:mb-8 px-4 py-2 bg-indigo-100 text-indigo-700 rounded-lg font-medium hover:bg-indigo-200 transition text-sm">
        ← Back to {{ $child->name }}'s Dashboard
    </a>

    <!-- Title -->
    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold mb-8 sm:mb-10 text-slate-900">
        Certificates — {{ $child->name }}
    </h1>

    <!-- Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-8">

        @forelse($certificates as $cert)
        <div class="bg-white/70 backdrop-blur-lg border border-white/30 rounded-3xl p-5 sm:p-6 shadow-lg
                    hover:shadow-2xl transition flex flex-col justify-between">
            <div>
                <h2 class="font-semibold text-base sm:text-xl text-slate-800">
                    {{ optional($cert->artwork->competition)->title ?? 'Competition' }}
                </h2>
                <p class="text-sm text-slate-500 mt-2">
                    Issued: {{ $cert->created_at->format('d M Y') }}
                </p>
            </div>
            <div class="mt-5 sm:mt-6 flex gap-3">
                <a href="{{ asset('storage/'.$cert->image_path) }}"
                   target="_blank"
                   class="flex-1 text-center px-4 py-2 bg-slate-200 rounded-xl hover:bg-slate-300 font-medium transition text-sm">
                    View
                </a>
                <a href="{{ asset('storage/'.$cert->image_path) }}"
                   download
                   class="flex-1 text-center px-4 py-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-500 font-medium transition text-sm">
                    Download
                </a>
            </div>
        </div>

        @empty
        <p class="text-slate-400 col-span-full text-center italic text-sm">No certificates available</p>
        @endforelse

    </div>

    <div class="mt-8 sm:mt-12 flex justify-center">
        {{ $certificates->links() }}
    </div>

</div>
@endsection