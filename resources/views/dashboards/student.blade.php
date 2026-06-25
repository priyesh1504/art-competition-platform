@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-100 via-white to-slate-200 py-6 sm:py-12">

    <div class="max-w-7xl mx-auto px-4 sm:px-6" x-data="{ sidebarOpen: false }">

        <!-- ================= MOBILE SIDEBAR TOGGLE ================= -->
        <div class="flex lg:hidden mb-4">
            <button @click="sidebarOpen = !sidebarOpen"
                    class="flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-slate-900 text-white text-sm font-semibold shadow-lg transition hover:bg-black">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <span x-text="sidebarOpen ? 'Close Panel' : 'Student Panel'">Student Panel</span>
            </button>
        </div>

        <div class="flex flex-col lg:flex-row gap-6 lg:gap-10">

            <!-- ================= SIDEBAR ================= -->
            <aside
                x-show="sidebarOpen || window.innerWidth >= 1024"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-2"
                class="w-full lg:w-72 backdrop-blur-xl bg-white/70 border border-white/40 shadow-2xl rounded-3xl p-6 lg:p-8 lg:block">

                <div class="mb-6 lg:mb-8">
                    <h2 class="text-xl lg:text-2xl font-bold text-slate-800">
                        Student Panel
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">
                        Creative Dashboard
                    </p>
                </div>

                <nav class="space-y-2 text-sm font-medium">
                    <a href="{{ route('student.artworks.create') }}"
                       @click="sidebarOpen = false"
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-700 hover:bg-slate-900 hover:text-white transition">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Submit Artwork
                    </a>

                    <a href="{{ route('student.artworks.index') }}"
                       @click="sidebarOpen = false"
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-700 hover:bg-slate-900 hover:text-white transition">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        My Submissions
                    </a>

                    <a href="{{ route('student.portfolio.index') }}"
                       @click="sidebarOpen = false"
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-700 hover:bg-slate-900 hover:text-white transition">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Portfolio
                    </a>

                    <a href="{{ route('student.certificates.index') }}"
                       @click="sidebarOpen = false"
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-700 hover:bg-slate-900 hover:text-white transition">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                        Certificates
                    </a>
                </nav>
            </aside>


            <!-- ================= MAIN CONTENT ================= -->
            <main class="flex-1 min-w-0">

                <!-- HEADER -->
                <div class="mb-6 lg:mb-10">
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-900">
                        Dashboard
                    </h1>
                    <p class="text-slate-500 mt-2 text-sm sm:text-base">
                        Discover competitions and track your participation.
                    </p>
                </div>

                @php
                    $paginatedIds = $competitions->pluck('id')->toArray();

                    $ongoingDisplay = $ongoing->whereIn('id', $paginatedIds);
                    $upcomingDisplay = $upcoming->whereIn('id', $paginatedIds);
                    $completedDisplay = $completed->whereIn('id', $paginatedIds);
                @endphp


                <!-- STATS -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mb-6 lg:mb-10">

                    <div class="bg-white rounded-3xl p-5 sm:p-6 shadow-xl">
                        <p class="text-sm text-slate-500">Total Competitions</p>
                        <h3 class="text-2xl font-bold mt-2">
                            {{ $totalCompetitions }}
                        </h3>
                    </div>

                    <div class="bg-white rounded-3xl p-5 sm:p-6 shadow-xl">
                        <p class="text-sm text-slate-500">Registered</p>
                        <h3 class="text-2xl font-bold text-emerald-600 mt-2">
                            {{ $registeredCount }}
                        </h3>
                    </div>

                    <div class="bg-white rounded-3xl p-5 sm:p-6 shadow-xl">
                        <p class="text-sm text-slate-500">Available</p>
                        <h3 class="text-2xl font-bold text-indigo-600 mt-2">
                            {{ $availableCount }}
                        </h3>
                    </div>

                </div>


                <!-- SEARCH -->
                <div class="bg-white rounded-3xl p-5 sm:p-6 shadow-xl mb-6 lg:mb-10">

                    <form method="GET" class="flex flex-col sm:flex-row gap-3 sm:gap-4">

                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Search competitions..."
                               class="flex-1 px-5 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-900 text-sm">

                        <select name="filter"
                                class="px-5 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-900 text-sm sm:w-40">
                            <option value="">All</option>
                            <option value="registered" {{ request('filter') == 'registered' ? 'selected' : '' }}>
                                Registered
                            </option>
                            <option value="not_registered" {{ request('filter') == 'not_registered' ? 'selected' : '' }}>
                                Not Registered
                            </option>
                        </select>

                        <button class="px-6 py-3 bg-slate-900 text-white rounded-2xl text-sm font-semibold hover:bg-black transition">
                            Apply
                        </button>

                    </form>
                </div>


                <!-- COLLAPSIBLE SECTIONS -->
                @foreach([
                    'Ongoing' => [
                        'data' => $ongoingDisplay,
                        'count' => $ongoing->count(),
                        'color' => 'emerald'
                    ],
                    'Upcoming' => [
                        'data' => $upcomingDisplay,
                        'count' => $upcoming->count(),
                        'color' => 'blue'
                    ],
                    'Closed' => [
                        'data' => $completedDisplay,
                        'count' => $completed->count(),
                        'color' => 'rose'
                    ]
                ] as $label => $section)

                @php
                    $list = $section['data'];
                    $color = $section['color'];
                @endphp

                <div x-data="{ open: false }" class="mb-6 sm:mb-8">

                    <!-- SECTION HEADER BUTTON -->
                    <button
                        @click="open = !open"
                        class="w-full flex justify-between items-center p-4 sm:p-5 rounded-2xl shadow transition

                           @if($color === 'emerald') bg-emerald-50 hover:bg-emerald-100
                           @elseif($color === 'blue') bg-blue-50 hover:bg-blue-100
                           @elseif($color === 'rose') bg-rose-50 hover:bg-rose-100
                           @endif
                    ">

                        <span class="text-base sm:text-lg font-semibold text-slate-800">
                            {{ $label }} ({{ $section['count'] }})
                        </span>

                        <svg
                            class="w-5 h-5 text-slate-600 transform transition duration-300"
                            :class="{ 'rotate-180': open }"
                            fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M19 9l-7 7-7-7"/>
                        </svg>

                    </button>


                    <!-- SECTION CONTENT -->
                    <div x-show="open" x-transition
                         class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mt-4 sm:mt-6">

                        @forelse($list as $competition)

                            @php
                                $isRegistered = in_array($competition->id, $registeredCompetitionIds ?? []);
                            @endphp

                            <div class="bg-white p-5 sm:p-6 rounded-2xl shadow hover:shadow-lg transition">

                                <h3 class="text-base sm:text-lg font-semibold text-slate-900">
                                    {{ $competition->title }}
                                </h3>

                                <p class="text-sm text-slate-500 mt-1">
                                    Deadline: {{ $competition->deadline?->format('d M Y') }}
                                </p>

                                <p class="text-sm text-slate-600 mt-3 sm:mt-4 leading-relaxed break-words whitespace-normal">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($competition->description), 120) }}
                                </p>

                                <div class="mt-4 sm:mt-5">

                                    @if($label === 'Closed')
                                        <button disabled
                                            class="w-full bg-rose-100 text-rose-600 py-2 rounded-xl font-medium text-sm">
                                            Closed
                                        </button>

                                    @elseif($label === 'Upcoming')
                                        <button disabled
                                            class="w-full bg-blue-100 text-blue-600 py-2 rounded-xl font-medium text-sm">
                                            Not Started
                                        </button>

                                    @elseif($isRegistered)
                                        <button disabled
                                            class="w-full bg-gray-200 text-gray-600 py-2 rounded-xl font-medium text-sm">
                                            Joined
                                        </button>

                                    @else
                                        <a href="{{ route('student.artworks.create', ['competition_id' => $competition->id]) }}"
                                           class="block text-center bg-slate-900 text-white py-2 rounded-xl hover:bg-black transition text-sm font-medium">
                                            Join
                                        </a>
                                    @endif

                                </div>

                            </div>

                        @empty
                            <p class="text-slate-400 col-span-2 text-center py-6 text-sm">
                                No {{ strtolower($label) }} competitions on this page
                            </p>
                        @endforelse

                    </div>

                </div>

                @endforeach


                <!-- PAGINATION -->
                <div class="mt-8 sm:mt-10">
                    {{ $competitions->links() }}
                </div>

            </main>
        </div>
    </div>
</div>
@endsection