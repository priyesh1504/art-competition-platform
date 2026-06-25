@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-6 sm:mt-10 px-4 sm:px-6">

    <!-- Back Button -->
    <div class="mb-5 sm:mb-6">
        <a href="{{ route('admin.dashboard') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-black transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Dashboard
        </a>
    </div>

    <!-- Header -->
    <div class="mb-8 sm:mb-10">

        <div class="mb-5">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">All Submissions</h1>
            <p class="text-gray-500 mt-2 text-sm">
                Review, grade, and manage all student artworks in one place.
            </p>
        </div>

        <!-- Financial + Stats -->
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-start gap-4">

            <a href="{{ route('admin.payments.index') }}"
               class="inline-flex items-center justify-center bg-green-500 hover:bg-green-600 text-white font-semibold px-5 py-2.5 rounded-xl shadow-md transition text-sm w-full sm:w-auto">
                View Financial Records
            </a>

            <div class="grid grid-cols-2 gap-3 sm:gap-4 w-full sm:w-auto">
                <div class="bg-gray-50 border border-gray-200 rounded-2xl px-5 sm:px-6 py-4 shadow-sm text-left">
                    <p class="text-xs uppercase text-gray-500 font-semibold">Pending</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $pendingCount }}</p>
                </div>

                <div class="bg-gray-900 rounded-2xl px-5 sm:px-6 py-4 shadow-sm text-left">
                    <p class="text-xs uppercase text-gray-300 font-semibold">Reviewed</p>
                    <p class="text-2xl sm:text-3xl font-bold text-white">{{ $reviewedCount }}</p>
                </div>
            </div>

        </div>
    </div>

    <!-- Search + Filter -->
    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mb-5 sm:mb-6">
        <input
            type="text"
            id="searchInput"
            placeholder="Search by student or artwork..."
            class="w-full sm:w-1/2 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none text-sm"
        >

        <select
            id="competitionFilter"
            class="w-full sm:flex-1 border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none text-sm">
            <option value="">All Competitions</option>
            @foreach($competitions as $title)
                <option value="{{ strtolower($title) }}">{{ $title }}</option>
            @endforeach
        </select>

        <select
            id="statusFilter"
            class="w-full sm:w-40 border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none text-sm">
            <option value="">All Status</option>
            <option value="pending">Pending</option>
            <option value="reviewed">Reviewed</option>
        </select>
    </div>

    <!-- Table -->
    <div class="bg-white shadow-xl rounded-3xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[950px] text-sm text-left border-collapse">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-semibold whitespace-nowrap">
                    <tr>
                        <th class="px-6 py-4">Artwork</th>
                        <th class="px-6 py-4">Student</th>
                        <th class="px-6 py-4">Competition</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Score</th>
                        <th class="px-6 py-4">Graded By</th>
                        <th class="px-6 py-4 text-center">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">

                @forelse($artworks as $artwork)
                    <tr class="table-row hover:bg-gray-50 transition"
                        data-student="{{ strtolower($artwork->student?->name ?? '') }}"
                        data-artwork="{{ strtolower($artwork->title ?? '') }}"
                        data-competition="{{ strtolower($artwork->competition?->title ?? '') }}"
                        data-status="{{ strtolower($artwork->status) }}"
                    >
                        <td class="px-6 py-4 min-w-[220px]">
                            <div class="flex items-center gap-4">
                                <img src="{{ asset('storage/' . $artwork->image_path) }}"
                                     class="h-14 w-14 rounded-2xl object-cover border flex-shrink-0">

                                <div class="min-w-0">
                                    <p class="font-semibold text-sm text-gray-900 truncate">
                                        {{ $artwork->title }}
                                    </p>
                                    <p class="text-xs text-gray-400">
                                        {{ $artwork->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $artwork->student?->name ?? 'Unknown' }}
                        </td>

                        <td class="px-6 py-4 min-w-[180px]">
                            {{ $artwork->competition?->title ?? '—' }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($artwork->status === 'reviewed')
                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                    Reviewed
                                </span>
                            @else
                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                    Pending
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            {{ $artwork->score ?? '—' }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $artwork->grader?->name ?? '—' }}
                        </td>

                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <a href="{{ route(auth()->user()->role === 'teacher'
                                ? 'teacher.grading.edit'
                                : 'admin.grading.edit', $artwork->id) }}"
                               class="inline-flex items-center justify-center bg-gray-900 text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-black transition">
                                {{ $artwork->status === 'reviewed' ? 'Edit Grade' : 'Grade Now' }}
                            </a>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="7" class="text-center py-10 text-gray-500 text-sm">
                            No submissions yet
                        </td>
                    </tr>
                @endforelse

                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 sm:p-6 border-t bg-gray-50">
            {{ $artworks->links() }}
        </div>
    </div>

</div>

<script>
const searchInput = document.getElementById('searchInput');
const competitionFilter = document.getElementById('competitionFilter');
const statusFilter = document.getElementById('statusFilter');

function filterTable() {
    const rows = document.querySelectorAll('.table-row');
    const search = searchInput.value.toLowerCase();
    const comp = competitionFilter.value;
    const status = statusFilter.value;

    rows.forEach(row => {
        const student = row.dataset.student || '';
        const artwork = row.dataset.artwork || '';
        const competition = row.dataset.competition || '';
        const rowStatus = row.dataset.status || '';

        const matchSearch = student.includes(search) || artwork.includes(search);
        const matchCompetition = !comp || competition.includes(comp);
        const matchStatus = !status || rowStatus === status;

        row.style.display = (matchSearch && matchCompetition && matchStatus) ? '' : 'none';
    });
}

searchInput.addEventListener('input', filterTable);
competitionFilter.addEventListener('change', filterTable);
statusFilter.addEventListener('change', filterTable);
</script>

@endsection