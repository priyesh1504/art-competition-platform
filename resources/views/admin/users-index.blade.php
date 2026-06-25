@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 py-8 sm:py-14">
<div class="max-w-7xl mx-auto px-4 sm:px-6">

    <!-- Back Button -->
    <div class="mb-5 sm:mb-6">
        <a href="{{ route('admin.dashboard') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-slate-900 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Dashboard
        </a>
    </div>

    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-4 sm:gap-6 mb-8 sm:mb-10">
        <div>
            <h1 class="text-2xl sm:text-4xl font-bold text-slate-900 tracking-tight">
                Manage Users
            </h1>
            <p class="text-slate-500 text-sm mt-2">
                View, edit, activate/deactivate, unlock accounts, and manage caregiver assignments.
            </p>
        </div>

        <div class="flex flex-wrap gap-2 sm:gap-3">
            <a href="{{ route('admin.deactivation.index') }}"
               class="px-4 sm:px-5 py-2.5 sm:py-3 rounded-2xl bg-rose-600 text-white font-semibold hover:bg-rose-700 transition shadow text-sm">
                Deactivation Requests
            </a>

            <a href="{{ route('admin.users.create') }}"
               class="px-4 sm:px-5 py-2.5 sm:py-3 rounded-2xl bg-slate-900 text-white font-semibold hover:bg-black transition shadow text-sm">
                + Create User
            </a>
        </div>
    </div>

    <!-- Search + Filter -->
    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mb-5 sm:mb-6">
        <input
            type="text"
            id="searchInput"
            placeholder="Search by name or email..."
            class="w-full sm:w-1/2 border border-slate-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-slate-900 focus:outline-none text-sm"
        >

        <select
            id="roleFilter"
            class="w-full sm:w-1/3 border border-slate-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-slate-900 focus:outline-none text-sm">
            <option value="">All Roles</option>
            <option value="admin">Admin</option>
            <option value="teacher">Teacher</option>
            <option value="caregiver">Caregiver</option>
            <option value="student">Student</option>
        </select>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-sm text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Users Table -->
    <div class="bg-white border border-slate-200 rounded-3xl shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1100px] text-sm text-left border-collapse">

                <thead class="bg-slate-50 text-slate-600 uppercase text-xs tracking-wide whitespace-nowrap">
                    <tr>
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Assigned</th>
                        <th class="px-6 py-4">Assigned Names</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200 bg-white">

                @forelse($users as $user)
                <tr class="table-row hover:bg-slate-50 transition"
                    data-name="{{ strtolower($user->name) }}"
                    data-email="{{ strtolower($user->email) }}"
                    data-role="{{ strtolower($user->role) }}"
                >
                    <td class="px-6 py-4 font-semibold text-slate-900 whitespace-nowrap min-w-[160px]">
                        {{ $user->name }}
                    </td>

                    <td class="px-6 py-4 text-slate-600 min-w-[230px]">
                        {{ $user->email }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap min-w-[110px]">
                        @php
                            $roleColors = [
                                'admin' => 'bg-rose-100 text-rose-700',
                                'teacher' => 'bg-amber-100 text-amber-700',
                                'caregiver' => 'bg-blue-100 text-blue-700',
                                'student' => 'bg-emerald-100 text-emerald-700',
                            ];
                        @endphp

                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $roleColors[$user->role] ?? '' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap min-w-[110px]">
                        @if(!$user->is_active)
                            <span class="px-3 py-1 rounded-full text-xs bg-rose-100 text-rose-700">
                                Deactivated
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs bg-emerald-100 text-emerald-700">
                                Active
                            </span>
                        @endif
                    </td>

                    <td class="px-6 py-4 text-center whitespace-nowrap min-w-[90px]">
                        @if($user->role === 'student')
                            {{ $user->caregivers->count() }}
                        @elseif($user->role === 'caregiver')
                            {{ $user->students->count() }}
                        @else
                            —
                        @endif
                    </td>

                    <td class="px-6 py-4 min-w-[280px]">
                        @if($user->role === 'student')

                            @foreach($user->caregivers as $cg)
                                <p class="whitespace-nowrap text-sm">
                                    • {{ $cg->name }}
                                    @if(!$cg->is_active)
                                        <span class="text-xs text-rose-600">(inactive)</span>
                                    @endif
                                </p>
                            @endforeach

                            @if($user->is_active)
                                <form method="POST" action="{{ route('admin.users.assignCaregiver', $user->id) }}">
                                    @csrf
                                    @method('PUT')

                                    <select name="caregiver_id"
                                            onchange="this.form.submit()"
                                            class="w-full mt-2 rounded-xl border border-slate-300 text-sm px-3 py-2">
                                        <option value="">+ Assign Caregiver</option>
                                        @foreach($caregivers->where('is_active', true) as $caregiver)
                                            <option value="{{ $caregiver->id }}">{{ $caregiver->name }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            @endif

                        @elseif($user->role === 'caregiver')

                            @foreach($user->students as $student)
                                <p class="whitespace-nowrap text-sm">• {{ $student->name }}</p>
                            @endforeach

                        @else
                            <span class="text-slate-400 italic">—</span>
                        @endif
                    </td>

                    <td class="px-6 py-4 text-center whitespace-nowrap min-w-[180px]">
                        <div class="flex justify-center gap-2 flex-wrap">
                            <a href="{{ route('admin.users.edit', $user->id) }}"
                               class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-xs font-semibold whitespace-nowrap">
                                Edit
                            </a>

                            @if($user->is_active)
                                <form method="POST" action="{{ route('admin.deactivation.approve', $user->id) }}">
                                    @csrf
                                    <button class="px-3 py-1.5 rounded-xl bg-rose-100 text-rose-700 text-xs font-semibold whitespace-nowrap">
                                        Deactivate
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('admin.deactivation.reactivate', $user->id) }}">
                                    @csrf
                                    <button class="px-3 py-1.5 rounded-xl bg-emerald-100 text-emerald-700 text-xs font-semibold whitespace-nowrap">
                                        Reactivate
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="7" class="text-center py-12 text-slate-400 italic text-sm">
                        No users found.
                    </td>
                </tr>
                @endforelse

                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6 sm:mt-8">
        {{ $users->links() }}
    </div>

</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const roleFilter = document.getElementById('roleFilter');

    function filterTable() {
        const rows = document.querySelectorAll('.table-row');
        const search = (searchInput.value || '').toLowerCase().trim();
        const role = (roleFilter.value || '').toLowerCase().trim();

        rows.forEach(row => {
            const name = (row.dataset.name || '').toLowerCase().trim();
            const email = (row.dataset.email || '').toLowerCase().trim();
            const userRole = (row.dataset.role || '').toLowerCase().trim();

            const matchSearch = name.includes(search) || email.includes(search);
            const matchRole = !role || userRole === role;

            row.style.display = (matchSearch && matchRole) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterTable);
    roleFilter.addEventListener('change', filterTable);
});
</script>

@endsection