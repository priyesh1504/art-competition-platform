@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-6 sm:mt-10 px-4 max-w-6xl">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 sm:gap-6 mb-6 sm:mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">
                Deactivation Requests
            </h1>
            <p class="text-gray-500 mt-1 text-sm">
                Review and approve user account deactivation requests.
            </p>
        </div>

        <a href="{{ route('admin.users.index') }}"
           class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-4 sm:px-5 py-2.5 rounded-xl transition shadow-sm text-sm self-start sm:self-auto">
            ← Back to Manage Users
        </a>
    </div>

    <!-- Stats Card -->
    <div class="mb-5 sm:mb-6">
        <div class="bg-red-50 border border-red-200 rounded-2xl p-5 sm:p-6 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm text-red-600 font-semibold uppercase tracking-wide">
                    Pending Requests
                </p>
                <h2 class="text-2xl sm:text-3xl font-bold text-red-700 mt-1">
                    {{ $requests->count() }}
                </h2>
            </div>
            <div class="text-red-300 text-4xl sm:text-5xl font-bold">🔒</div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-5 sm:mb-6 p-4 rounded-2xl bg-green-50 text-green-700 border border-green-200 shadow-sm text-sm">
            <div class="flex items-center gap-2">
                <span class="text-lg">✔</span>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Requests Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[720px] text-sm text-left border-collapse">

                <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider whitespace-nowrap">
                    <tr>
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4 text-center">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">

                    @forelse($requests as $user)
                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-6 py-4 min-w-[180px]">
                            <div class="font-semibold text-gray-800 text-sm whitespace-nowrap">
                                {{ $user->name }}
                            </div>
                            <div class="text-xs text-gray-400">
                                ID: #{{ $user->id }}
                            </div>
                        </td>

                        <td class="px-6 py-4 min-w-[260px] text-gray-600 text-sm">
                            {{ $user->email }}
                        </td>

                        <td class="px-6 py-4 text-center whitespace-nowrap min-w-[180px]">
                            <form method="POST"
                                  action="{{ route('admin.deactivation.approve', $user->id) }}"
                                  onsubmit="return confirm('Are you sure you want to permanently deactivate this account?')">
                                @csrf

                                <button type="submit"
                                    class="inline-flex items-center justify-center bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-xl font-semibold shadow-sm transition text-sm whitespace-nowrap">
                                    Approve Deactivation
                                </button>
                            </form>
                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-16">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <div class="text-4xl sm:text-5xl text-gray-300">🎉</div>
                                <p class="text-gray-500 text-base sm:text-lg font-semibold">
                                    No pending deactivation requests
                                </p>
                                <p class="text-gray-400 text-sm">
                                    All user accounts are currently active.
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection