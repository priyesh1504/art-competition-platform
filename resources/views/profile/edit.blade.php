@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto mt-6 sm:mt-10 px-4 sm:px-6">
    <div class="bg-white p-6 sm:p-10 rounded-3xl shadow-xl border border-gray-100">

        <h2 class="text-xl sm:text-2xl font-bold text-indigo-700 mb-5 sm:mb-6">
            Edit Profile
        </h2>

        @if (session('status'))
            <div class="mb-6 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-xl text-sm">
                @if (session('status') === 'verification-link-sent')
                    A new verification link has been sent to your email address.
                @elseif (session('status') === 'profile-updated')
                    Profile updated successfully.
                @else
                    {{ session('status') }}
                @endif
            </div>
        @endif

        <div id="no-change-message"
             class="hidden mb-6 bg-yellow-100 border border-yellow-300 text-yellow-800 px-4 py-3 rounded-xl text-sm">
            No changes were made.
        </div>

        @if (session('info'))
            <div class="mb-6 bg-blue-100 border border-blue-300 text-blue-800 px-4 py-3 rounded-xl text-sm">
                {{ session('info') }}
            </div>
        @endif

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="mb-4 text-sm text-yellow-700 bg-yellow-100 border border-yellow-300 p-4 rounded-xl flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <span>Your email address is not verified.</span>

                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                            class="text-indigo-600 hover:text-indigo-800 font-semibold text-sm">
                        Resend Verification
                    </button>
                </form>
            </div>
        @endif

        <!-- Profile Form -->
        <form method="POST" action="{{ route('profile.update') }}" id="profile-form">
            @csrf
            @method('PATCH')

            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Name
                </label>

                <input type="text"
                       name="name"
                       id="name"
                       value="{{ old('name', $user->name) }}"
                       class="w-full rounded-xl border text-sm {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }} focus:border-indigo-500 focus:ring-indigo-200 p-3"
                       required>

                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @if($user->role === 'student')
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Age
                    </label>

                    <input type="number"
                           name="age"
                           id="age"
                           min="5"
                           max="15"
                           value="{{ old('age', $user->age) }}"
                           class="w-full rounded-xl border text-sm {{ $errors->has('age') ? 'border-red-500' : 'border-gray-300' }} focus:border-indigo-500 focus:ring-indigo-200 p-3"
                           required>

                    @if (!$errors->has('age'))
                        <p class="mt-1 text-sm text-gray-500">
                            Age must be between 5 and 15.
                        </p>
                    @endif

                    @error('age')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <p id="age-live-error" class="mt-1 text-sm text-red-600 hidden">
                        Age must be between 5 and 15.
                    </p>
                </div>
            @endif

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Email
                </label>

                <input type="email"
                       value="{{ $user->email }}"
                       class="w-full rounded-xl bg-gray-100 border border-gray-200 p-3 cursor-not-allowed text-sm"
                       disabled>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 mt-5 sm:mt-6">
                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-xl transition text-sm">
                    Save Changes
                </button>

                <a href="{{ route('profile.password.edit') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-6 py-3 rounded-xl transition text-sm text-center">
                    Change Password
                </a>
            </div>
        </form>

        <hr class="my-6 sm:my-8 border-gray-100">

        <!-- Account Deactivation -->
        <h3 class="text-lg sm:text-xl font-bold text-red-600 mb-3">
            Account Deactivation
        </h3>

        <p class="text-gray-600 mb-4 text-sm">
            If you want to deactivate your account, you may submit a request.
            The administrator must approve it before your account is disabled.
        </p>

        @if(auth()->user()->deactivation_requested)
            <div class="mb-4 bg-yellow-100 border border-yellow-300 text-yellow-800 px-4 py-3 rounded-xl text-sm">
                Your deactivation request is currently pending admin approval.
            </div>
        @else
            <form method="POST" action="{{ route('request.deactivation') }}">
                @csrf
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-3 rounded-xl transition text-sm">
                    Request Deactivation
                </button>
            </form>
        @endif

    </div>
</div>

<script>
    const profileForm = document.getElementById('profile-form');
    const originalName = @json($user->name);
    const originalAge = @json($user->role === 'student' ? $user->age : null);

    const nameInput = document.getElementById('name');
    const ageInput = document.getElementById('age');
    const noChangeMessage = document.getElementById('no-change-message');
    const ageLiveError = document.getElementById('age-live-error');

    if (ageInput) {
        ageInput.addEventListener('input', function () {
            const age = parseInt(this.value);
            ageLiveError &&
                ageLiveError.classList.toggle(
                    'hidden',
                    !(this.value !== '' && (age < 5 || age > 15))
                );
        });
    }

    profileForm.addEventListener('submit', function (e) {
        const currentName = nameInput.value.trim();
        const currentAge = ageInput ? ageInput.value : null;

        const nameChanged = currentName !== originalName;
        const ageChanged = ageInput
            ? String(currentAge) !== String(originalAge)
            : false;

        if (!nameChanged && !ageChanged) {
            e.preventDefault();
            noChangeMessage.classList.remove('hidden');
            noChangeMessage.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
            return;
        }

        if (ageInput) {
            const age = parseInt(currentAge);

            if (currentAge !== '' && (age < 5 || age > 15)) {
                e.preventDefault();
                ageLiveError && ageLiveError.classList.remove('hidden');
                ageInput.focus();
            }
        }
    });
</script>

@endsection