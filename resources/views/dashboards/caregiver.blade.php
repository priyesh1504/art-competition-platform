@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-slate-100 via-white to-slate-200 py-6 sm:py-10">

    <div class="max-w-7xl mx-auto px-4 sm:px-6" x-data="{ sidebarOpen: false }">

        <!-- ================= MOBILE SIDEBAR TOGGLE ================= -->
        <div class="flex lg:hidden mb-4">
            <button @click="sidebarOpen = !sidebarOpen"
                    class="flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-slate-900 text-white text-sm font-semibold shadow-lg transition hover:bg-black">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <span x-text="sidebarOpen ? 'Close Panel' : 'Caregiver Panel'">Caregiver Panel</span>
            </button>
        </div>

        <div class="flex flex-col lg:flex-row gap-6 lg:gap-10">

            <!-- ================= SIDEBAR ================= -->
            <aside class="w-full lg:w-72 h-fit">
                <div
                    x-show="sidebarOpen || window.innerWidth >= 1024"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2"
                    class="bg-white/70 backdrop-blur-xl border border-slate-200 shadow-sm rounded-3xl p-5 sm:p-6 lg:block">

                    <div class="mb-6 sm:mb-8">
                        <h2 class="text-base sm:text-lg font-bold text-slate-800">Caregiver Panel</h2>
                        <p class="text-sm text-slate-500 mt-1">Monitor students easily</p>
                    </div>

                    <nav class="space-y-2 text-sm font-medium">

                        <a href="{{ route('caregiver.dashboard') }}"
                           @click="sidebarOpen = false"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                           {{ request()->routeIs('caregiver.dashboard')
                                ? 'bg-slate-900 text-white'
                                : 'text-slate-700 hover:bg-slate-900 hover:text-white' }}">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Dashboard
                        </a>

                        <a href="{{ route('caregiver.children') }}"
                           @click="sidebarOpen = false"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                           {{ request()->routeIs('caregiver.children*')
                                ? 'bg-slate-900 text-white'
                                : 'text-slate-700 hover:bg-slate-900 hover:text-white' }}">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Children
                        </a>

                    </nav>
                </div>
            </aside>

            <!-- ================= MAIN CONTENT ================= -->
            <main class="flex-1 min-w-0 space-y-6 sm:space-y-10">

                <!-- Header -->
                <div>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-900 tracking-tight">
                        Caregiver Dashboard
                    </h1>
                    <p class="text-slate-500 mt-2 text-sm sm:text-base">
                        Overview of students, competitions, and progress
                    </p>
                </div>

                <!-- ================= STATS ================= -->
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">

                    <div class="bg-white/70 backdrop-blur border border-slate-200 rounded-2xl p-5 sm:p-6 shadow-sm">
                        <p class="text-slate-500 text-xs sm:text-sm">Children</p>
                        <h2 class="text-xl sm:text-2xl font-bold mt-2">{{ $childrenCount }}</h2>
                    </div>

                    <div class="bg-white/70 backdrop-blur border border-slate-200 rounded-2xl p-5 sm:p-6 shadow-sm">
                        <p class="text-slate-500 text-xs sm:text-sm">Competitions</p>
                        <h2 class="text-xl sm:text-2xl font-bold text-indigo-600 mt-2">{{ $competitionsCount }}</h2>
                    </div>

                    <div class="bg-white/70 backdrop-blur border border-slate-200 rounded-2xl p-5 sm:p-6 shadow-sm">
                        <p class="text-slate-500 text-xs sm:text-sm">Submissions</p>
                        <h2 class="text-xl sm:text-2xl font-bold text-emerald-600 mt-2">{{ $submissionsCount }}</h2>
                    </div>

                    <div class="bg-white/70 backdrop-blur border border-slate-200 rounded-2xl p-5 sm:p-6 shadow-sm">
                        <p class="text-slate-500 text-xs sm:text-sm">Awards</p>
                        <h2 class="text-xl sm:text-2xl font-bold text-amber-600 mt-2">{{ $awardsCount }}</h2>
                    </div>

                </div>

                <!-- ================= COMPETITIONS ================= -->
                <section class="bg-white/70 backdrop-blur border border-slate-200 rounded-3xl p-5 sm:p-6 shadow-sm">

                    <h2 class="text-base sm:text-lg font-semibold text-slate-800 mb-5 sm:mb-6">
                        Competitions
                    </h2>

                    <!-- FILTER BUTTONS -->
                    <div class="flex flex-wrap gap-2 sm:gap-3 mb-5 sm:mb-6">
                        <button onclick="filterComp(event,'all')" class="filter-btn active">All</button>
                        <button onclick="filterComp(event,'upcoming')" class="filter-btn">Upcoming</button>
                        <button onclick="filterComp(event,'ongoing')" class="filter-btn">Ongoing</button>
                        <button onclick="filterComp(event,'completed')" class="filter-btn">Completed</button>
                    </div>

                    <!-- COMPETITION GRID -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">

                        @forelse($upcomingCompetitions as $comp)

                            @php
                                $now = \Carbon\Carbon::now();
                                $start = \Carbon\Carbon::parse($comp->start_date);
                                $end = \Carbon\Carbon::parse($comp->deadline);

                                if ($now->lt($start)) {
                                    $status = 'upcoming';
                                } elseif ($now->between($start, $end)) {
                                    $status = 'ongoing';
                                } else {
                                    $status = 'completed';
                                }
                            @endphp

                            <div class="competition-card rounded-2xl border border-slate-100 bg-white
                                        p-5 sm:p-6 shadow-sm hover:shadow-md hover:-translate-y-1
                                        transition duration-300"
                                 data-status="{{ $status }}">

                                <h3 class="font-semibold text-slate-900 text-base sm:text-lg mb-3">
                                    {{ $comp->title }}
                                </h3>

                                <div class="text-sm text-slate-500 space-y-1">
                                    <p>📅 {{ $start->format('M d, Y') }}</p>
                                    <p>⏰ {{ $end->format('M d, Y') }}</p>
                                </div>

                                <!-- STATUS BADGE -->
                                @if($status === 'upcoming')
                                    <span class="mt-4 inline-block text-xs font-medium bg-indigo-50 text-indigo-600 px-3 py-1 rounded-full">
                                        Upcoming
                                    </span>
                                @elseif($status === 'ongoing')
                                    <span class="mt-4 inline-block text-xs font-medium bg-emerald-50 text-emerald-600 px-3 py-1 rounded-full">
                                        Ongoing
                                    </span>
                                @else
                                    <span class="mt-4 inline-block text-xs font-medium bg-slate-200 text-slate-600 px-3 py-1 rounded-full">
                                        Completed
                                    </span>
                                @endif

                            </div>

                        @empty
                            <p class="text-slate-400 col-span-full text-sm">No competitions available</p>
                        @endforelse

                    </div>
                </section>

                <!-- ================= CHILDREN ================= -->
                <section class="bg-white/70 backdrop-blur border border-slate-200 rounded-3xl p-5 sm:p-6 shadow-sm">

                    <h2 class="text-base sm:text-lg font-semibold text-slate-800 mb-5 sm:mb-6">
                        Your Children
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">

                        @forelse($students as $student)

                            <a href="{{ route('caregiver.children.show', $student->id) }}"
                               class="group p-5 rounded-2xl border border-slate-100
                                      bg-white hover:shadow-md hover:-translate-y-1
                                      transition duration-300">

                                <h3 class="font-semibold text-slate-900 group-hover:text-indigo-600 transition text-sm sm:text-base">
                                    {{ $student->name }}
                                </h3>

                                <p class="text-sm text-slate-500 mt-1">
                                    View dashboard →
                                </p>

                            </a>

                        @empty
                            <p class="text-slate-400 text-sm">No students assigned</p>
                        @endforelse

                    </div>

                </section>

            </main>
        </div>
    </div>
</div>

<!-- ================= STYLES ================= -->
<style>
.filter-btn {
    padding: 7px 14px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 500;
    background: white;
    color: #334155;
    border: 1px solid #e2e8f0;
    transition: 0.2s;
    white-space: nowrap;
}
.filter-btn:hover {
    background: #0f172a;
    color: white;
}
.filter-btn.active {
    background: #0f172a;
    color: white;
}
</style>

<!-- ================= SCRIPT ================= -->
<script>
function filterComp(event, type) {
    let cards = document.querySelectorAll('.competition-card');

    cards.forEach(card => {
        if (type === 'all' || card.dataset.status === type) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });

    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
    });

    event.target.classList.add('active');
}
</script>

@endsection