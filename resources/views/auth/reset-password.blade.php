@extends('layouts.auth')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-100 via-gray-200 to-gray-300 px-4 py-8">

    <div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-6 sm:p-8 border border-gray-100">

        <div class="text-center mb-6">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-800">
                Reset Your Password
            </h2>
            <p class="text-sm text-gray-500 mt-2">
                Enter your email and choose a new password.
            </p>
        </div>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">
                    Email Address
                </label>
                <input
                    id="email" type="email" name="email"
                    value="{{ old('email', $request->email) }}"
                    required autofocus autocomplete="username"
                    class="mt-1 w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none text-sm"
                >
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">
                    New Password
                </label>
                <div class="relative">
                    <input
                        id="password" type="password" name="password"
                        required autocomplete="new-password"
                        class="mt-1 w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none text-sm pr-16"
                    >
                    <button type="button"
                            onclick="togglePassword('password', this)"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-sm text-indigo-600">
                        Show
                    </button>
                </div>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                    Confirm Password
                </label>
                <div class="relative">
                    <input
                        id="password_confirmation" type="password" name="password_confirmation"
                        required autocomplete="new-password"
                        class="mt-1 w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none text-sm pr-16"
                    >
                    <button type="button"
                            onclick="togglePassword('password_confirmation', this)"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-sm text-indigo-600">
                        Show
                    </button>
                </div>
                @error('password_confirmation')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg transition duration-200 shadow-md text-sm sm:text-base">
                Reset Password
            </button>

        </form>
    </div>
</div>

<script>
function togglePassword(fieldId, btn) {
    const field = document.getElementById(fieldId);
    if (field.type === "password") {
        field.type = "text";
        btn.innerText = "Hide";
    } else {
        field.type = "password";
        btn.innerText = "Show";
    }
}
</script>

@endsection