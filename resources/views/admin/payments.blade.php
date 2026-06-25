@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-6 sm:mt-12 px-4 sm:px-6">

    <!-- Back Button -->
    <div class="mb-5 sm:mb-6">
        <button onclick="window.history.back()"
            class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-black transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </button>
    </div>

    <!-- Page Header -->
    <div class="mb-6 sm:mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
            Financial Records
        </h1>
        <p class="text-gray-500 text-sm mt-2">
            Manage competition payments and transaction history.
        </p>
    </div>

    <!-- Table Card -->
    <div class="bg-white shadow-xl rounded-3xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-sm text-left border-collapse">

                <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-semibold tracking-wide whitespace-nowrap">
                    <tr>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4">Student</th>
                        <th class="px-6 py-4">Competition</th>
                        <th class="px-6 py-4">Amount</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Receipt</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">

                    @forelse($payments as $payment)
                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-6 py-4 whitespace-nowrap min-w-[120px] text-gray-700">
                            {{ $payment->created_at->format('M d, Y') }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap min-w-[170px] font-medium text-gray-900">
                            {{ $payment->user->name }}
                        </td>

                        <td class="px-6 py-4 min-w-[240px] text-gray-800">
                            {{ $payment->competition->title }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap min-w-[120px] font-semibold text-gray-900">
                            ₹{{ number_format($payment->amount, 2) }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap min-w-[120px]">
                            <span class="inline-flex px-3 py-1 rounded-full bg-gray-900 text-white text-xs font-semibold uppercase">
                                {{ $payment->status }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-center whitespace-nowrap min-w-[100px]">
                            @if($payment->receipt_path)
                                <a href="{{ Storage::url($payment->receipt_path) }}"
                                   target="_blank"
                                   class="text-gray-900 font-semibold hover:underline text-sm">
                                    Download
                                </a>
                            @else
                                <span class="text-gray-400 text-sm">N/A</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center whitespace-nowrap min-w-[120px]">
                            <form action="{{ route('admin.payments.destroy', $payment->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Archive this record?');">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-900 text-xs font-semibold transition whitespace-nowrap">
                                    Archive
                                </button>
                            </form>
                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-16">
                            <div class="flex flex-col items-center gap-3">
                                <div class="text-4xl text-gray-300">💳</div>
                                <p class="text-gray-600 font-semibold text-base sm:text-lg">
                                    No transactions found
                                </p>
                                <p class="text-gray-400 text-sm">
                                    Payment records will appear here once submitted.
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