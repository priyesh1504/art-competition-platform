@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto mt-10 px-6">

    <div class="grid grid-cols-12 gap-8">

        <!-- Sidebar -->
        <div class="col-span-12 md:col-span-3">

            <div class="bg-white rounded-xl shadow-sm border p-5">

                <h2 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">
                    Settings
                </h2>

                <nav class="space-y-2">

                    <a href="{{ route('profile.edit') }}"
                       class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                        Profile
                    </a>

                    <a href="{{ route('profile.password.edit') }}"
                       class="block px-4 py-2 rounded-lg bg-indigo-50 text-indigo-700 font-semibold">
                        Password
                    </a>

                </nav>

            </div>

        </div>


        <!-- Content -->
        <div class="col-span-12 md:col-span-9">

            <div class="bg-white rounded-xl shadow-sm border p-8">

                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800">
                        Update Password
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Use a strong password to keep your account secure.
                    </p>
                </div>

                <form method="POST" action="{{ route('profile.password.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Current Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Current Password
                        </label>

                        <div class="relative">
                            <input
                                id="current_password"
                                name="current_password"
                                type="password"
                                required
                                class="w-full border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            >

                            <button
                                type="button"
                                onclick="togglePassword('current_password', this)"
                                class="absolute right-3 top-2 text-sm text-gray-500 hover:text-gray-700"
                            >
                                Show
                            </button>
                        </div>

                        @error('current_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- New Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            New Password
                        </label>

                        <div class="relative">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                required
                                class="w-full border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            >

                            <button
                                type="button"
                                onclick="togglePassword('password', this)"
                                class="absolute right-3 top-2 text-sm text-gray-500 hover:text-gray-700"
                            >
                                Show
                            </button>
                        </div>

                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Confirm Password
                        </label>

                        <div class="relative">
                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                required
                                class="w-full border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            >

                            <button
                                type="button"
                                onclick="togglePassword('password_confirmation', this)"
                                class="absolute right-3 top-2 text-sm text-gray-500 hover:text-gray-700"
                            >
                                Show
                            </button>
                        </div>
                    </div>


                    <!-- Save Button -->
                    <div class="pt-2">
                        <button
                            type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-lg transition"
                        >
                            Update Password
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>

</div>


<script>
function togglePassword(fieldId, btn) {
    const input = document.getElementById(fieldId);

    if (input.type === "password") {
        input.type = "text";
        btn.innerText = "Hide";
    } else {
        input.type = "password";
        btn.innerText = "Show";
    }
}
</script>

@endsection