@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-100 py-6 sm:py-10">
<div class="max-w-7xl mx-auto px-4 sm:px-6">

    <!-- Back Button -->
    <div class="mb-5 sm:mb-6">
        <a href="{{ route('teacher.dashboard') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-slate-900 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Dashboard
        </a>
    </div>

    <!-- Header + Stats -->
    <div class="flex flex-col gap-5 sm:gap-8 mb-8 sm:mb-10">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Student Submissions</h1>
            <p class="text-slate-500 mt-2 text-sm">Review artworks, assign grades, and manage certificates.</p>
        </div>
        <div class="flex gap-3 sm:gap-6">
            <div class="bg-white px-5 sm:px-6 py-4 rounded-2xl shadow-sm border border-slate-200 flex-1 sm:flex-none">
                <p class="text-xs uppercase font-semibold text-amber-600 tracking-wide">Pending</p>
                <p class="text-xl sm:text-2xl font-bold text-amber-700 mt-1">{{ $pendingCount }}</p>
            </div>
            <div class="bg-white px-5 sm:px-6 py-4 rounded-2xl shadow-sm border border-slate-200 flex-1 sm:flex-none">
                <p class="text-xs uppercase font-semibold text-emerald-600 tracking-wide">Reviewed</p>
                <p class="text-xl sm:text-2xl font-bold text-emerald-700 mt-1">{{ $reviewedCount }}</p>
            </div>
        </div>
    </div>

    <!-- Search + Filter -->
    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mb-5 sm:mb-6">
        <input type="text" id="searchInput"
               placeholder="Search by student or artwork..."
               class="w-full sm:w-1/2 border border-slate-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-slate-900 focus:outline-none text-sm">
        <select id="competitionFilter"
                class="w-full sm:flex-1 border border-slate-300 rounded-xl px-4 py-2.5 focus:outline-none text-sm">
            <option value="">All Competitions</option>
            @foreach($competitions as $title)
                <option value="{{ strtolower($title) }}">{{ $title }}</option>
            @endforeach
        </select>
        <select id="statusFilter"
                class="w-full sm:w-36 border border-slate-300 rounded-xl px-4 py-2.5 focus:outline-none text-sm">
            <option value="">All Status</option>
            <option value="pending">Pending</option>
            <option value="reviewed">Reviewed</option>
        </select>
    </div>

    @if(session('success'))
        <div class="mb-5 sm:mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 shadow-sm text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
        <div class="flex justify-between items-center px-5 sm:px-8 py-5 sm:py-6 border-b border-slate-200 bg-slate-50">
            <h2 class="font-semibold text-slate-800 text-base sm:text-lg">Submissions</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm" style="min-width: 700px;">
                <thead class="bg-slate-100 text-slate-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="py-4 px-5 sm:px-8 text-left">Artwork</th>
                        <th class="py-4 px-5 sm:px-8 text-left">Student</th>
                        <th class="py-4 px-5 sm:px-8 text-left">Competition</th>
                        <th class="py-4 px-5 sm:px-8 text-left">Status</th>
                        <th class="py-4 px-5 sm:px-8 text-center">Score</th>
                        <th class="py-4 px-5 sm:px-8 text-center">Graded By</th>
                        <th class="py-4 px-5 sm:px-8 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">

                    @forelse($artworks as $artwork)
                    <tr class="table-row hover:bg-slate-50 transition"
                        data-student="{{ strtolower(optional($artwork->student)->name ?? '') }}"
                        data-artwork="{{ strtolower($artwork->title ?? '') }}"
                        data-competition="{{ strtolower(optional($artwork->competition)->title ?? '') }}"
                        data-status="{{ strtolower($artwork->status) }}"
                    >
                        <td class="py-5 sm:py-6 px-5 sm:px-8">
                            <div class="flex items-center gap-3 sm:gap-4">
                                <img src="{{ asset('storage/' . $artwork->image_path) }}"
                                     class="h-12 w-12 sm:h-16 sm:w-16 rounded-2xl object-cover shadow-sm border border-slate-200 flex-shrink-0">
                                <div>
                                    <p class="font-semibold text-slate-900 text-xs sm:text-sm">{{ $artwork->title }}</p>
                                    <p class="text-xs text-slate-500 mt-1">{{ $artwork->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-5 sm:py-6 px-5 sm:px-8 font-medium text-slate-700 text-xs sm:text-sm whitespace-nowrap">
                            {{ optional($artwork->student)->name ?? 'Unknown Student' }}
                        </td>
                        <td class="py-5 sm:py-6 px-5 sm:px-8 text-slate-600 text-xs sm:text-sm">
                            {{ optional($artwork->competition)->title ?? 'No Competition' }}
                        </td>
                        <td class="py-5 sm:py-6 px-5 sm:px-8">
                            @if($artwork->status === 'reviewed')
                                <span class="px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 whitespace-nowrap">Reviewed</span>
                            @else
                                <span class="px-3 py-1.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 whitespace-nowrap">Pending</span>
                            @endif
                        </td>
                        <td class="py-5 sm:py-6 px-5 sm:px-8 text-center font-semibold text-xs sm:text-sm">
                            @if(!is_null($artwork->score)) {{ $artwork->score }}/100
                            @else <span class="text-slate-400">—</span>
                            @endif
                        </td>
                        <td class="py-5 sm:py-6 px-5 sm:px-8 text-center text-slate-700 text-xs sm:text-sm">
                            {{ $artwork->grader?->name ?? '—' }}
                        </td>
                        <td class="py-5 sm:py-6 px-5 sm:px-8 text-center">
                            <a href="{{ route(auth()->user()->role === 'teacher' ? 'teacher.grading.edit' : 'admin.grading.edit', $artwork->id) }}"
                               class="px-4 sm:px-5 py-2 sm:py-2.5 rounded-2xl text-xs sm:text-sm font-semibold
                                      bg-slate-900 text-white hover:bg-black transition shadow-sm whitespace-nowrap">
                                {{ $artwork->status === 'reviewed' ? 'Edit Grade' : 'Grade Now' }}
                            </a>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="7" class="py-16 sm:py-20 text-center text-slate-500 text-sm">No submissions yet</td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        <div class="p-4 sm:p-6 border-t border-slate-200 bg-slate-50">
            {{ $artworks->links() }}
        </div>
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