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
            <span x-text="sidebarOpen ? 'Close Panel' : 'Admin Panel'">Admin Panel</span>
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
                    Admin Control Panel
                </h2>

                <div class="space-y-3 sm:space-y-4">

                    <a href="{{ route('admin.users.index') }}"
                       @click="sidebarOpen = false"
                       class="block w-full px-4 py-3 rounded-2xl bg-slate-900 text-white font-semibold text-center hover:bg-black transition shadow text-sm">
                        Manage Users
                    </a>

                    <a href="{{ route('admin.grading.index') }}"
                       @click="sidebarOpen = false"
                       class="block w-full px-4 py-3 rounded-2xl border border-slate-300 text-slate-700 font-semibold text-center hover:bg-slate-100 transition text-sm">
                        Review & Grade
                    </a>

                    <a href="{{ route('admin.templates.index') }}"
                       @click="sidebarOpen = false"
                       class="block w-full px-4 py-3 rounded-2xl border border-slate-300 text-slate-700 font-semibold text-center hover:bg-slate-100 transition text-sm">
                        Certificates
                    </a>

                    <a href="{{ route('admin.deactivation.index') }}"
                       @click="sidebarOpen = false"
                       class="block w-full px-4 py-3 rounded-2xl border border-slate-300 text-slate-700 font-semibold text-center hover:bg-slate-100 transition text-sm">
                        Deactivation Requests
                    </a>

                    <a href="{{ route('admin.competitions.create') }}"
                       @click="sidebarOpen = false"
                       class="block w-full px-4 py-3 rounded-2xl bg-emerald-600 text-white font-semibold text-center hover:bg-emerald-700 transition shadow text-sm">
                        + Create Competition
                    </a>

                </div>
            </div>
        </aside>


        <!-- ================= MAIN CONTENT ================= -->
        <div class="col-span-12 lg:col-span-9">

            <div class="mb-6 sm:mb-10">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-900 tracking-tight">
                    Admin Dashboard
                </h1>
                <p class="text-slate-500 mt-2 text-sm">
                    Manage competitions efficiently.
                </p>
            </div>

            <!-- ALERTS -->
            @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-sm">
                    {{ session('error') }}
                </div>
            @endif


            <!-- FILTER -->
            <div class="bg-white border border-slate-200 rounded-3xl shadow-xl p-5 sm:p-6 mb-6 sm:mb-10">

                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 items-stretch sm:items-center">

                    <input id="searchInput"
                        type="text"
                        placeholder="Search competitions..."
                        class="flex-1 px-5 py-3 rounded-2xl border border-slate-300 focus:ring-2 focus:ring-slate-900 focus:outline-none text-sm">

                    <select id="statusFilter"
                        class="px-5 py-3 rounded-2xl border border-slate-300 focus:ring-2 focus:ring-slate-900 focus:outline-none text-sm sm:w-44">
                        <option value="all">All Status</option>
                        <option value="ongoing">Ongoing</option>
                        <option value="upcoming">Upcoming</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>

                </div>
            </div>


            <!-- TABLE (wrapped for horizontal scroll on mobile) -->
            <div class="bg-white border border-slate-200 rounded-3xl shadow-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left min-w-[600px]">

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
                                $isLocked = in_array($status, ['completed', 'cancelled']);
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
                                        @elseif($status === 'cancelled') bg-gray-200 text-gray-700
                                        @endif">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>

                                <td class="px-5 sm:px-8 py-4 sm:py-6 text-slate-500 text-sm whitespace-nowrap">
                                    {{ $competition->deadline?->format('M d, Y') }}
                                </td>

                                <td class="px-5 sm:px-8 py-4 sm:py-6">
                                    <div class="flex justify-center gap-2 flex-wrap">

                                        <a href="{{ route('admin.competitions.show', $competition->id) }}"
                                           class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold whitespace-nowrap">
                                            View
                                        </a>

                                        @if(!$isLocked)

                                            <a href="{{ route('admin.competitions.edit', $competition->id) }}"
                                               class="px-3 py-1.5 rounded-xl bg-emerald-100 hover:bg-emerald-200 text-emerald-700 text-xs font-semibold whitespace-nowrap">
                                                Edit
                                            </a>

                                            <form method="POST"
                                                  action="{{ route('admin.competitions.cancel', $competition->id) }}"
                                                  onsubmit="return confirm('Are you sure you want to cancel this competition? This action cannot be undone.');">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                    class="px-3 py-1.5 rounded-xl bg-yellow-100 hover:bg-yellow-200 text-yellow-700 text-xs font-semibold whitespace-nowrap">
                                                    Cancel
                                                </button>
                                            </form>

                                        @endif

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

            <div class="mt-6 sm:mt-8">
                {{ $competitions->links() }}
            </div>

        </div>
    </div>
</div>
</div>

<!-- FILTER SCRIPT -->
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