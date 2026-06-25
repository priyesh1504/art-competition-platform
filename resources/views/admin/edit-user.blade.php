@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-6 sm:mt-10 px-4 max-w-3xl">

    <!-- Back Button -->
    <div class="mb-5 sm:mb-6">
        <a href="{{ route('admin.users.index') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-black transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Users
        </a>
    </div>

    <div class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">

        <!-- Header -->
        <div class="px-6 sm:px-8 py-5 sm:py-6 border-b border-gray-100">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800">
                Edit User
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Update user details, role, and caregiver assignment.
            </p>
        </div>

        <div class="p-6 sm:p-8">

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700">
                    <p class="font-semibold mb-2 text-sm">Please fix the following:</p>
                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-5 sm:mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                    <input type="text" name="name"
                        value="{{ old('name', $user->name) }}"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 px-4 py-2.5 text-gray-700 shadow-sm text-sm"
                        required>
                </div>

                <!-- Email -->
                <div class="mb-5 sm:mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                    <input type="email" name="email"
                        value="{{ old('email', $user->email) }}"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 px-4 py-2.5 text-gray-700 shadow-sm text-sm"
                        required>
                </div>

                <!-- Role -->
                <div class="mb-5 sm:mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Role</label>
                    <select name="role" id="roleSelect"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 px-4 py-2.5 text-gray-700 shadow-sm text-sm">
                        <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Student</option>
                        <option value="teacher" {{ $user->role === 'teacher' ? 'selected' : '' }}>Teacher</option>
                        <option value="caregiver" {{ $user->role === 'caregiver' ? 'selected' : '' }}>Caregiver</option>
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <!-- Caregiver Dropdown -->
                <div class="mb-6 sm:mb-8 {{ $user->role === 'student' ? '' : 'hidden' }}" id="caregiverBox">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Assign Caregiver</label>
                    <select name="caregiver_id"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 px-4 py-2.5 text-gray-700 shadow-sm text-sm">
                        <option value="">-- Select Caregiver --</option>
                        @foreach($caregivers as $caregiver)
                            <option value="{{ $caregiver->id }}"
                                {{ old('caregiver_id', optional($currentCaregiver)->id) == $caregiver->id ? 'selected' : '' }}>
                                {{ $caregiver->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-400 mt-2">
                        Only applicable if the user role is set to Student.
                    </p>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row justify-between items-center gap-3 border-t pt-5 sm:pt-6">
                    <a href="{{ route('admin.users.index') }}"
                        class="text-gray-500 hover:text-gray-700 font-medium transition text-sm order-2 sm:order-1">
                        Cancel
                    </a>
                    <button type="submit"
                        class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-sm transition text-sm order-1 sm:order-2">
                        Update User
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('roleSelect').addEventListener('change', function () {
    const caregiverBox = document.getElementById('caregiverBox');
    caregiverBox.classList.toggle('hidden', this.value !== 'student');
});
</script>

@endsection