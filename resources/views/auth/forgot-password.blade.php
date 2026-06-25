@extends('layouts.auth')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-100 via-gray-200 to-gray-300 px-4 py-8">

    <div class="w-full max-w-md">

        <div class="bg-white shadow-xl rounded-2xl p-6 sm:p-8 border border-gray-100">

            <div class="text-center mb-6">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-800">
                    Forgot Your Password?
                </h2>
                <p class="text-gray-500 text-sm mt-2 leading-relaxed">
                    Enter your email address and we'll send you a secure link to reset your password.
                </p>
            </div>

            @if (session('status'))
                <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-700 text-sm border border-green-200">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email Address
                    </label>
                    <input
                        id="email" type="email" name="email"
                        value="{{ old('email') }}"
                        required autofocus
                        placeholder="Enter your email"
                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm
                        @error('email') border-red-500 @enderror"
                    >
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg transition duration-200 shadow-md text-sm sm:text-base">
                    Send Password Reset Link
                </button>
            </form>

            <div class="my-5 sm:my-6 border-t border-gray-200"></div>

            <div class="text-center text-sm text-gray-600">
                Remember your password?
                <a href="{{ route('login') }}"
                   class="text-indigo-600 hover:text-indigo-800 font-medium">
                    Return to login
                </a>
            </div>

        </div>
    </div>
</div>
@endsection