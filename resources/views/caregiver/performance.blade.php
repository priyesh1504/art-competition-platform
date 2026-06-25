@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto py-10 px-6">

    <!-- Header with Back Button -->
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-slate-900">
            Performance - {{ $child->name }}
        </h1>
        <a href="{{ route('caregiver.children.show', $child->id) }}"
           class="px-4 py-2 bg-indigo-100 text-indigo-700 rounded-lg font-medium hover:bg-indigo-200 transition">
            ← Back to Dashboard
        </a>
    </div>

    <!-- Chart Card -->
    <div class="bg-white/70 backdrop-blur-xl border border-white/30 rounded-3xl shadow-lg p-8">
        <h2 class="text-xl font-semibold text-slate-800 mb-6">
            Score Trend
        </h2>
        <canvas id="chart" height="150"></canvas>
    </div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('chart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'Scores',
            data: @json($scores),
            borderWidth: 1,
            backgroundColor: 'rgba(99,102,241,0.6)',
            borderColor: 'rgba(99,102,241,1)',
            borderRadius: 8,
            maxBarThickness: 40
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: { mode: 'index', intersect: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                max: 100,
                ticks: { stepSize: 10, color: '#4B5563' },
                grid: { color: 'rgba(0,0,0,0.05)', borderDash: [5,5] }
            },
            x: {
                ticks: { color: '#4B5563' },
                grid: { display: false }
            }
        }
    }
});
</script>

@endsection