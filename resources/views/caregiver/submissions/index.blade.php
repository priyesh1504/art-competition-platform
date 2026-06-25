@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-slate-100 py-10">
<div class="max-w-6xl mx-auto px-6">

    <h1 class="text-3xl font-bold mb-6">
        Select Student
    </h1>

    <div class="grid md:grid-cols-3 gap-6">

        @foreach($students as $student)

        <a href="{{ route('caregiver.submissions.student', $student->id) }}"
           class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">

            <h2 class="text-lg font-semibold">
                {{ $student->name }}
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                View submissions →
            </p>

        </a>

        @endforeach

    </div>

</div>
</div>

@endsection