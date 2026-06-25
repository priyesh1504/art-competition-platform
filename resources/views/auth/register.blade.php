<x-guest-layout>
    <div class="w-full max-w-md mx-auto bg-white p-6 sm:p-8 rounded-2xl shadow-xl">

        <!-- Heading -->
        <div class="text-center mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-black">
                Create an account
            </h1>
            <p class="mt-2 text-black/70 text-sm sm:text-base">
                Join Rang Kala Academy
            </p>
        </div>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <p class="font-semibold text-sm">Please fix the following errors:</p>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Full Name -->
            <div class="mb-4">
                <label for="name" class="block font-semibold text-black text-sm">
                    Name
                </label>
                <input
                    id="name" name="name" type="text"
                    value="{{ old('name') }}"
                    placeholder="Enter your full name"
                    required autofocus
                    class="mt-1 block w-full rounded-lg border text-sm
                    {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }}
                    text-black placeholder-gray-400
                    focus:border-indigo-600 focus:ring-indigo-600 py-2.5 px-3"
                >
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-600 text-sm" />
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block font-semibold text-black text-sm">
                    Email Address
                </label>
                <input
                    id="email" name="email" type="email"
                    value="{{ old('email') }}"
                    placeholder="Enter your email address"
                    required
                    class="mt-1 block w-full rounded-lg border text-sm
                    {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }}
                    text-black placeholder-gray-400
                    focus:border-indigo-600 focus:ring-indigo-600 py-2.5 px-3"
                >
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600 text-sm" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block font-semibold text-black text-sm">
                    Password
                </label>
                <div class="relative">
                    <input
                        id="password" name="password" type="password"
                        placeholder="Create a password"
                        required
                        class="mt-1 block w-full rounded-lg border pr-16 text-sm
                        {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }}
                        text-black placeholder-gray-400
                        focus:border-indigo-600 focus:ring-indigo-600 py-2.5 px-3"
                    >
                    <button
                        type="button"
                        onclick="togglePassword('password', this)"
                        class="absolute inset-y-0 right-0 px-3 text-sm text-gray-600 hover:text-black">
                        Show
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600 text-sm" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block font-semibold text-black text-sm">
                    Confirm Password
                </label>
                <div class="relative">
                    <input
                        id="password_confirmation" name="password_confirmation" type="password"
                        placeholder="Confirm your password"
                        required
                        class="mt-1 block w-full rounded-lg border pr-16 text-sm
                        {{ $errors->has('password_confirmation') ? 'border-red-500' : 'border-gray-300' }}
                        text-black placeholder-gray-400
                        focus:border-indigo-600 focus:ring-indigo-600 py-2.5 px-3"
                    >
                    <button
                        type="button"
                        onclick="togglePassword('password_confirmation', this)"
                        class="absolute inset-y-0 right-0 px-3 text-sm text-gray-600 hover:text-black">
                        Show
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600 text-sm" />
            </div>

            <!-- Role -->
            <div class="mb-4">
                <label for="role" class="block font-semibold text-black text-sm">
                    Registering as
                </label>
                <select
                    id="role" name="role" required
                    class="mt-1 block w-full rounded-lg border text-sm
                    {{ $errors->has('role') ? 'border-red-500' : 'border-gray-300' }}
                    text-black focus:border-indigo-600 focus:ring-indigo-600 py-2.5 px-3"
                >
                    <option value="student" {{ old('role', 'student') == 'student' ? 'selected' : '' }}>Student</option>
                    <option value="caregiver" {{ old('role') == 'caregiver' ? 'selected' : '' }}>Caregiver</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2 text-red-600 text-sm" />
            </div>

            <!-- Age -->
            <div id="age-field" class="mb-5 {{ old('role', 'student') === 'student' ? '' : 'hidden' }}">
                <label for="age" class="block font-semibold text-black text-sm">
                    Age
                </label>
                <input
                    id="age" name="age" type="number"
                    min="5" max="15"
                    value="{{ old('age') }}"
                    placeholder="Enter age (5 - 15)"
                    class="mt-1 block w-full rounded-lg border text-sm
                    {{ $errors->has('age') ? 'border-red-500' : 'border-gray-300' }}
                    text-black placeholder-gray-400
                    focus:border-indigo-600 focus:ring-indigo-600 py-2.5 px-3"
                >
                @if (!$errors->has('age'))
                    <p class="mt-2 text-sm text-gray-500">Student age must be between 5 and 15.</p>
                @endif
                <x-input-error :messages="$errors->get('age')" class="mt-2 text-red-600 text-sm" />
            </div>

            <!-- Submit -->
            <button
                type="submit"
                class="w-full bg-indigo-700 hover:bg-indigo-800
                       text-white font-bold py-3 rounded-lg transition text-sm sm:text-base"
            >
                Register
            </button>

            <!-- Login -->
            <p class="mt-5 sm:mt-6 text-center text-sm text-black">
                Already registered?
                <a href="{{ route('login') }}" class="font-semibold text-indigo-700 hover:underline">
                    Sign in
                </a>
            </p>
        </form>
    </div>

    <script>
        function togglePassword(fieldId, btn) {
            const input = document.getElementById(fieldId);
            if (input.type === "password") {
                input.type = "text";
                btn.textContent = "Hide";
            } else {
                input.type = "password";
                btn.textContent = "Show";
            }
        }

        const roleSelect = document.getElementById('role');
        const ageField = document.getElementById('age-field');
        const ageInput = document.getElementById('age');

        function toggleAgeField() {
            if (roleSelect.value === 'student') {
                ageField.classList.remove('hidden');
                ageInput.setAttribute('required', 'required');
                ageInput.setAttribute('min', '5');
                ageInput.setAttribute('max', '15');
            } else {
                ageField.classList.add('hidden');
                ageInput.removeAttribute('required');
                ageInput.value = '';
            }
        }

        roleSelect.addEventListener('change', toggleAgeField);
        toggleAgeField();
    </script>
</x-guest-layout>