@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 py-6 sm:py-10">
<div class="max-w-7xl mx-auto px-4 sm:px-6" x-data="{ sidebarOpen: false }">

    <!-- ================= MOBILE SIDEBAR TOGGLE ================= -->
    <div class="flex lg:hidden mb-4">
        <button @click="sidebarOpen = !sidebarOpen"
                class="flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-slate-900 text-white text-sm font-semibold shadow-lg transition hover:bg-black">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <span x-text="sidebarOpen ? 'Close Panel' : 'Teacher Panel'">Teacher Panel</span>
        </button>
    </div>

    <div class="grid grid-cols-12 gap-6 lg:gap-8">

        <!-- ================= SIDEBAR ================= -->
        <aside class="col-span-12 lg:col-span-3">
            <div
                x-show="sidebarOpen || window.innerWidth >= 1024"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-2"
                class="bg-white border border-slate-200 rounded-3xl shadow-xl p-5 sm:p-6 lg:sticky lg:top-8 lg:block">

                <h2 class="text-base sm:text-lg font-bold text-slate-900 mb-5 sm:mb-6 tracking-wide">
                    Teacher Control Panel
                </h2>

                <div class="space-y-3 sm:space-y-4">

                    <a href="{{ route('teacher.competitions.create') }}"
                       @click="sidebarOpen = false"
                       class="block w-full px-4 py-3 rounded-2xl bg-slate-900 text-white font-semibold text-center hover:bg-black transition shadow text-sm">
                        + Create Competition
                    </a>

                    <a href="{{ route('teacher.grading.index') }}"
                       @click="sidebarOpen = false"
                       class="block w-full px-4 py-3 rounded-2xl border border-slate-300 text-slate-700 font-semibold text-center hover:bg-slate-100 transition text-sm">
                        Review & Grade
                    </a>

                </div>
            </div>
        </aside>


        <!-- ================= MAIN CONTENT ================= -->
        <div class="col-span-12 lg:col-span-9">

            <!-- Header -->
            <div class="mb-6 sm:mb-10">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-900 tracking-tight">
                    Teacher Dashboard
                </h1>
                <p class="text-slate-500 mt-2 text-sm">
                    Manage competitions, evaluate submissions, and monitor activity.
                </p>
            </div>

            <!-- Success -->
            @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-sm text-sm">
                    {{ session('success') }}
                </div>
            @endif


            <!-- ================= SEARCH + FILTER ================= -->
            <div class="bg-white border border-slate-200 rounded-3xl shadow-xl p-5 sm:p-6 mb-6 sm:mb-10">

                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 items-stretch sm:items-center">

                    <input
                        id="searchInput"
                        type="text"
                        placeholder="Search competitions..."
                        class="flex-1 px-5 py-3 rounded-2xl border border-slate-300 focus:ring-2 focus:ring-slate-900 focus:outline-none text-sm"
                    >

                    <select
                        id="statusFilter"
                        class="px-5 py-3 rounded-2xl border border-slate-300 focus:ring-2 focus:ring-slate-900 focus:outline-none text-sm sm:w-44"
                    >
                        <option value="all">All Status</option>
                        <option value="ongoing">Ongoing</option>
                        <option value="upcoming">Upcoming</option>
                        <option value="completed">Completed</option>
                    </select>

                </div>

            </div>


            <!-- ================= TABLE ================= -->
            <div class="bg-white border border-slate-200 rounded-3xl shadow-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left min-w-[580px]">

                        <thead class="bg-slate-50 text-slate-600 text-xs uppercase tracking-wide">
                            <tr>
                                <th class="px-5 sm:px-8 py-4 sm:py-5">Competition</th>
                                <th class="px-5 sm:px-8 py-4 sm:py-5">Status</th>
                                <th class="px-5 sm:px-8 py-4 sm:py-5">Deadline</th>
                                <th class="px-5 sm:px-8 py-4 sm:py-5 text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody id="competitionTable" class="divide-y divide-slate-200">

                            @forelse($competitions as $competition)

                            @php
                                $status = $competition->computed_status;
                            @endphp

                            <tr class="competitionRow hover:bg-slate-50 transition"
                                data-title="{{ strtolower($competition->title) }}"
                                data-status="{{ $status }}">

                                <td class="px-5 sm:px-8 py-4 sm:py-6 font-semibold text-slate-900 text-sm">
                                    {{ $competition->title }}
                                </td>

                                <td class="px-5 sm:px-8 py-4 sm:py-6">
                                    <span class="px-3 py-1.5 rounded-full text-xs font-semibold whitespace-nowrap
                                        @if($status === 'ongoing') bg-emerald-100 text-emerald-700
                                        @elseif($status === 'upcoming') bg-blue-100 text-blue-700
                                        @elseif($status === 'completed') bg-rose-100 text-rose-700
                                        @else bg-slate-200 text-slate-700
                                        @endif">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>

                                <td class="px-5 sm:px-8 py-4 sm:py-6 text-slate-500 text-sm whitespace-nowrap">
                                    {{ $competition->deadline?->format('M d, Y') }}
                                </td>

                                <td class="px-5 sm:px-8 py-4 sm:py-6">
                                    <div class="flex justify-center gap-3 sm:gap-6 text-sm font-semibold flex-wrap">

                                        <a href="{{ route('teacher.competitions.show', $competition->id) }}"
                                           class="text-slate-700 hover:text-black transition whitespace-nowrap">
                                            View
                                        </a>

                                        <a href="{{ route('teacher.competitions.edit', $competition->id) }}"
                                           class="text-emerald-600 hover:text-emerald-800 transition whitespace-nowrap">
                                            Edit
                                        </a>

                                        <a href="{{ route('teacher.grading.index', ['competition_id' => $competition->id]) }}"
                                           class="text-amber-600 hover:text-amber-800 transition whitespace-nowrap">
                                            Grade
                                        </a>

                                    </div>
                                </td>

                            </tr>

                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-16 text-center text-slate-400 text-sm">
                                    No competitions available.
                                </td>
                            </tr>
                            @endforelse

                        </tbody>

                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6 sm:mt-8">
                {{ $competitions->links() }}
            </div>

        </div>
    </div>
</div>
</div>


<!-- ================= SEARCH + FILTER SCRIPT ================= -->
<script>
const searchInput = document.getElementById("searchInput");
const statusFilter = document.getElementById("statusFilter");
const rows = document.querySelectorAll(".competitionRow");

function filterTable() {

    let searchValue = searchInput.value.toLowerCase();
    let statusValue = statusFilter.value;

    rows.forEach(row => {

        let title = row.dataset.title;
        let status = row.dataset.status;

        let matchesSearch = title.includes(searchValue);
        let matchesStatus = (statusValue === "all" || status === statusValue);

        row.style.display = (matchesSearch && matchesStatus) ? "" : "none";

    });
}

searchInput.addEventListener("keyup", filterTable);
statusFilter.addEventListener("change", filterTable);
</script>

@endsection