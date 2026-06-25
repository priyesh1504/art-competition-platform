@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-6 sm:py-10 px-4 sm:px-6">

    <div class="mb-5 sm:mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold">Select a Child</h1>
        <p class="text-slate-500 text-sm mt-2">Choose a student to view their dashboard.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
        @forelse($students as $student)
        <a href="{{ route('caregiver.children.show', $student->id) }}"
           class="bg-white p-5 sm:p-6 rounded-3xl shadow hover:shadow-xl transition hover:-translate-y-1 duration-300">
            <h2 class="text-base sm:text-lg font-semibold text-slate-900">{{ $student->name }}</h2>
            <p class="text-sm text-slate-500 mt-2">View Dashboard →</p>
        </a>
        @empty
        <p class="text-slate-400 col-span-full text-center italic text-sm">No children assigned.</p>
        @endforelse
    </div>

</div>
@endsection