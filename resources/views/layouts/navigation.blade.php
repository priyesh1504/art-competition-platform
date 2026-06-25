<nav aria-label="Main navigation"
     x-data="{ mobileOpen: false }"
     class="sticky top-0 z-50 backdrop-blur-xl bg-white/70 border-b border-white/40 shadow-sm w-full">

    <div class="w-full px-4 sm:px-6 lg:px-10">
        <div class="flex justify-between items-center h-16">

            <!-- ================= LEFT SIDE ================= -->
            <div class="flex items-center gap-4 lg:gap-8">

                <!-- App Name -->
                <a href="{{ route('dashboard') }}"
                   class="text-xl font-bold tracking-tight text-slate-900
                          focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-lg">
                    {{ config('app.name', 'Laravel') }}
                </a>

                <!-- Dashboard Link (desktop only) -->
                <a href="{{ route('dashboard') }}"
                   class="hidden lg:block text-sm font-medium text-slate-600 hover:text-slate-900 transition
                          focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-lg px-1 py-1">
                    Dashboard
                </a>

            </div>

            <!-- ================= RIGHT SIDE (desktop) ================= -->
            @auth
            <div class="hidden lg:flex items-center gap-6">

                <!-- 🔊 Read Aloud -->
                <button onclick="toggleSpeech()"
                        id="speech-btn"
                        aria-label="Read page aloud"
                        class="px-3 py-2 rounded-xl text-sm font-medium text-slate-600
                               hover:bg-slate-100 transition
                               focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Read Aloud
                </button>

                <!-- 🔔 Notifications -->
                <div x-data="{ notifOpen: false }"
                     @keydown.escape.window="notifOpen = false"
                     class="relative">

                    <button
                        @click="notifOpen = !notifOpen"
                        :aria-expanded="notifOpen.toString()"
                        aria-haspopup="true"
                        aria-controls="notifications-menu"
                        aria-label="Open notifications"
                        class="relative p-2 rounded-xl hover:bg-slate-100 transition
                               focus:outline-none focus:ring-2 focus:ring-blue-500">

                        <svg class="w-6 h-6 text-slate-600"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11
                                     a6 6 0 00-4-5.7V5a2 2 0 10-4 0v.3
                                     C7.7 6.2 6 8.4 6 11v3.2
                                     c0 .5-.2 1-.6 1.4L4 17h5m6 0
                                     a3 3 0 11-6 0h6z"/>
                        </svg>

                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1
                                         flex items-center justify-center text-[10px]
                                         font-bold text-white bg-slate-900 rounded-full">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </button>

                    <!-- Notifications Dropdown -->
                    <div id="notifications-menu"
                         x-show="notifOpen"
                         @click.outside="notifOpen = false"
                         x-transition
                         class="absolute right-0 mt-4 w-80 backdrop-blur-xl
                                bg-white/90 border border-slate-200
                                rounded-2xl shadow-xl z-50 overflow-hidden">

                        <div class="px-5 py-3 border-b border-slate-200">
                            <p class="text-sm font-semibold text-slate-800">Notifications</p>
                        </div>

                        <ul class="max-h-72 overflow-y-auto">
                            @forelse(auth()->user()->notifications->take(5) as $notification)
                                <li class="border-b border-slate-100 hover:bg-slate-50 transition">
                                    <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                        @csrf
                                        <button type="submit"
                                                class="w-full text-left px-5 py-4">
                                            <p class="text-sm font-medium
                                                {{ $notification->read_at ? 'text-slate-700' : 'text-slate-900' }}">
                                                {{ $notification->data['message'] ?? 'New notification' }}
                                            </p>
                                            <p class="text-xs text-slate-400 mt-1">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </p>
                                        </button>
                                    </form>
                                </li>
                            @empty
                                <li class="px-5 py-6 text-sm text-slate-500 text-center">
                                    No notifications yet
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- 👤 Profile -->
                <div x-data="{ open: false }"
                     @keydown.escape.window="open = false"
                     class="relative">

                    <button
                        @click="open = !open"
                        :aria-expanded="open.toString()"
                        aria-haspopup="true"
                        aria-controls="profile-menu"
                        class="flex items-center gap-2 px-4 py-2 rounded-2xl
                               bg-white/70 backdrop-blur border border-slate-200
                               hover:bg-white transition
                               focus:outline-none focus:ring-2 focus:ring-blue-500">

                        <span class="text-sm font-semibold text-slate-800">
                            {{ Auth::user()->name }}
                        </span>

                        <svg class="w-4 h-4 text-slate-500 transition-transform duration-200"
                             :class="{ 'rotate-180': open }"
                             fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- Profile Dropdown -->
                    <div id="profile-menu"
                         x-show="open"
                         @click.outside="open = false"
                         x-transition
                         class="absolute right-0 mt-4 w-56
                                backdrop-blur-xl bg-white/90 border border-slate-200
                                rounded-2xl shadow-xl overflow-hidden z-50">

                        <a href="{{ route('profile.edit') }}"
                           class="block px-5 py-3 text-sm text-slate-700 hover:bg-slate-50 transition">
                            Edit Profile
                        </a>

                        <div class="border-t border-slate-200"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left px-5 py-3 text-sm font-semibold
                                           text-red-600 hover:bg-red-50 transition">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>

            </div>

            <!-- ================= MOBILE RIGHT ================= -->
            <div class="flex lg:hidden items-center gap-3">

                <!-- Mobile Notification Bell -->
                <div x-data="{ notifOpen: false }" class="relative">
                    <button
                        @click="notifOpen = !notifOpen"
                        class="relative p-2 rounded-xl hover:bg-slate-100 transition">
                        <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11
                                     a6 6 0 00-4-5.7V5a2 2 0 10-4 0v.3
                                     C7.7 6.2 6 8.4 6 11v3.2
                                     c0 .5-.2 1-.6 1.4L4 17h5m6 0
                                     a3 3 0 11-6 0h6z"/>
                        </svg>
                    </button>
                </div>

                <!-- Hamburger -->
                <button @click="mobileOpen = !mobileOpen"
                        class="p-2 rounded-xl hover:bg-slate-100 transition">
                    <svg x-show="!mobileOpen" class="w-6 h-6 text-slate-700"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>

                    <svg x-show="mobileOpen" class="w-6 h-6 text-slate-700"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            @endauth

        </div>
    </div>

    <!-- ================= MOBILE MENU PANEL ================= -->
    @auth
    <div x-show="mobileOpen"
         x-transition
         class="lg:hidden border-t border-slate-200 bg-white/95 backdrop-blur-xl">

        <div class="px-4 py-4 space-y-1">

            <div class="px-4 py-3 mb-2 border-b border-slate-100">
                <p class="text-xs text-slate-400 uppercase tracking-wide font-medium">Signed in as</p>
                <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ Auth::user()->name }}</p>
            </div>

            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium
                      text-slate-700 hover:bg-slate-100 transition">
                Dashboard
            </a>

            <button onclick="toggleSpeech()" id="speech-btn-mobile"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium
                           text-slate-700 hover:bg-slate-100 transition text-left">
                Read Aloud
            </button>

            <a href="{{ route('profile.edit') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium
                      text-slate-700 hover:bg-slate-100 transition">
                Edit Profile
            </a>

            <div class="border-t border-slate-100 pt-2 mt-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold
                                   text-red-600 hover:bg-red-50 transition text-left">
                        Logout
                    </button>
                </form>
            </div>

        </div>
    </div>
    @endauth

</nav>