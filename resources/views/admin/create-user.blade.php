@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 py-8 sm:py-14">
<div class="max-w-2xl mx-auto px-4 sm:px-6">

    <!-- Back Button -->
    <div class="mb-5 sm:mb-6">
        <button onclick="window.history.back()"
            class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-slate-900 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </button>
    </div>

    <div class="bg-white border border-slate-200 rounded-3xl shadow-xl p-6 sm:p-10">

        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">
                Create New User
            </h1>
            <p class="text-slate-500 text-sm mt-2">
                Add a new user and assign their role.
            </p>
        </div>

        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <!-- Name -->
            <div class="mb-5 sm:mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Full Name</label>
                <input type="text" name="name"
                       value="{{ old('name') }}"
                       placeholder="Enter full name"
                       required
                       class="w-full px-4 py-3 rounded-2xl border text-sm
                       @error('name') border-rose-500 @else border-slate-300 @enderror
                       focus:ring-2 focus:ring-slate-900 focus:outline-none transition">
                @error('name')
                    <p class="text-sm text-rose-500 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-5 sm:mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
                <input type="email" name="email"
                       value="{{ old('email') }}"
                       placeholder="example@email.com"
                       required
                       class="w-full px-4 py-3 rounded-2xl border text-sm
                       @error('email') border-rose-500 @else border-slate-300 @enderror
                       focus:ring-2 focus:ring-slate-900 focus:outline-none transition">
                @error('email')
                    <p class="text-sm text-rose-500 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-5 sm:mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password"
                           placeholder="Enter secure password"
                           required
                           class="w-full px-4 py-3 pr-12 rounded-2xl border text-sm
                           @error('password') border-rose-500 @else border-slate-300 @enderror
                           focus:ring-2 focus:ring-slate-900 focus:outline-none transition">
                    <button type="button"
                        onclick="togglePassword('password', this)"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-800 text-lg">
                        👁️
                    </button>
                </div>
                @error('password')
                    <p class="text-sm text-rose-500 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-5 sm:mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Confirm Password</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="confirmPassword"
                           placeholder="Re-enter password"
                           required
                           class="w-full px-4 py-3 pr-12 rounded-2xl border text-sm
                           @error('password_confirmation') border-rose-500 @else border-slate-300 @enderror
                           focus:ring-2 focus:ring-slate-900 focus:outline-none transition">
                    <button type="button"
                        onclick="togglePassword('confirmPassword', this)"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-800 text-lg">
                        👁️
                    </button>
                </div>
                @error('password_confirmation')
                    <p class="text-sm text-rose-500 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role -->
            <div class="mb-5 sm:mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Role</label>
                <select name="role" id="roleSelect" required
                        class="w-full px-4 py-3 rounded-2xl border bg-white text-sm
                        @error('role') border-rose-500 @else border-slate-300 @enderror
                        focus:ring-2 focus:ring-slate-900 focus:outline-none transition">
                    <option value="">-- Select Role --</option>
                    <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                    <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Teacher</option>
                    <option value="caregiver" {{ old('role') == 'caregiver' ? 'selected' : '' }}>Caregiver</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')
                    <p class="text-sm text-rose-500 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Caregiver Dropdown -->
            <div class="mb-6 sm:mb-8 hidden transition-all duration-300" id="caregiverBox">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Assign Caregiver</label>
                <select name="caregiver_id"
                        class="w-full px-4 py-3 rounded-2xl border bg-white text-sm
                        @error('caregiver_id') border-rose-500 @else border-slate-300 @enderror
                        focus:ring-2 focus:ring-slate-900 focus:outline-none transition">
                    <option value="">-- Select Caregiver --</option>
                    @foreach($caregivers as $caregiver)
                        <option value="{{ $caregiver->id }}"
                            {{ old('caregiver_id') == $caregiver->id ? 'selected' : '' }}>
                            {{ $caregiver->name }}
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-slate-500 mt-2">Only required if role is Student.</p>
                @error('caregiver_id')
                    <p class="text-sm text-rose-500 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                <a href="{{ route('admin.users.index') }}"
                   class="text-sm text-slate-500 hover:text-slate-700 transition order-2 sm:order-1">
                    Cancel
                </a>
                <button type="submit"
                        class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-slate-900 text-white font-semibold hover:bg-black transition shadow text-sm order-1 sm:order-2">
                    Create User
                </button>
            </div>

        </form>
    </div>
</div>
</div>

<script>
const roleSelect = document.getElementById('roleSelect');
const caregiverBox = document.getElementById('caregiverBox');

function toggleCaregiver() {
    caregiverBox.classList.toggle("hidden", roleSelect.value !== "student");
}

roleSelect.addEventListener('change', toggleCaregiver);
document.addEventListener("DOMContentLoaded", toggleCaregiver);

function togglePassword(id, btn) {
    const input = document.getElementById(id);
    if (input.type === "password") {
        input.type = "text";
        btn.textContent = "🙈";
    } else {
        input.type = "password";
        btn.textContent = "👁️";
    }
}
</script>

@endsection