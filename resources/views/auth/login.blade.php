<x-guest-layout>
    <div class="w-full max-w-md mx-auto bg-white p-6 sm:p-10 rounded-3xl shadow-2xl border border-gray-100">

        <!-- Heading -->
        <div class="text-center mb-8 sm:mb-10">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                Welcome Back
            </h1>
            <p class="text-gray-500 mt-3 text-sm">
                Log in to Rang Kala Academy
            </p>
        </div>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-xl text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Deactivated Account Message --}}
        @if(session('error'))
            <div class="mb-6 bg-gray-100 border border-gray-200 text-gray-800 px-4 py-3 rounded-xl text-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Session Expired Message --}}
        @if(session('info'))
            <div class="mb-6 bg-gray-50 border border-gray-200 text-gray-700 px-4 py-3 rounded-xl text-sm">
                {{ session('info') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-5 sm:mb-6">
                <x-input-label for="email" value="Email Address" class="text-gray-800 font-semibold" />

                <x-text-input
                    id="email"
                    class="block mt-2 w-full rounded-xl border
                    {{ $errors->has('email') ? 'border-red-500' : 'border-gray-200' }}
                    bg-white text-gray-900 placeholder-gray-400 focus:border-gray-900 focus:ring-gray-900"
                    type="email"
                    name="email"
                    :value="old('email')"
                    placeholder="you@example.com"
                    required
                    autofocus
                />
            </div>

            <!-- Password -->
            <div class="mb-5 sm:mb-6">
                <div class="flex justify-between items-center mb-2">
                    <x-input-label for="password" value="Password" class="text-gray-800 font-semibold" />

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-sm text-gray-600 hover:text-gray-900 font-medium">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <div class="flex items-center border
                    {{ $errors->has('email') ? 'border-red-500' : 'border-gray-200' }}
                    rounded-xl focus-within:border-gray-900 focus-within:ring-1 focus-within:ring-gray-900 bg-white transition">

                    <input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="••••••••"
                        required
                        class="flex-1 px-4 py-3 rounded-l-xl bg-transparent text-gray-900 placeholder-gray-400 focus:outline-none"
                    >

                    <button
                        type="button"
                        onclick="togglePassword()"
                        class="px-4 text-gray-500 hover:text-gray-900 focus:outline-none transition"
                        aria-label="Toggle password visibility">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600 text-sm" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center mb-6 sm:mb-8">
                <input
                    id="remember_me"
                    type="checkbox"
                    class="rounded border-gray-300 text-gray-900 focus:ring-gray-900"
                    name="remember"
                >
                <label for="remember_me" class="ml-2 text-sm text-gray-600">
                    Remember me
                </label>
            </div>

            <!-- Login Button -->
            <button
                type="submit"
                class="w-full bg-gray-900 hover:bg-black text-white font-semibold py-3 rounded-xl transition duration-200 shadow-sm text-sm sm:text-base"
            >
                Log In
            </button>

            <!-- Register Link -->
            <div class="mt-6 sm:mt-8 text-center">
                <p class="text-sm text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register') }}"
                       class="text-gray-900 font-semibold hover:underline">
                        Join Rang Kala Academy
                    </a>
                </p>
            </div>
        </form>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
</x-guest-layout>