<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Manual | Rang Kala Academy</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900">

<!-- ================= NAVBAR ================= -->
<header class="bg-white/90 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-5 flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-xl font-bold tracking-wide hover:text-gray-600 transition">
            Rang Kala Academy
        </a>

        <div class="flex items-center gap-6">
            <a href="{{ route('login') }}" class="text-gray-600 hover:text-black font-medium transition">
                Login
            </a>
            <a href="{{ route('register') }}"
               class="bg-black text-white px-6 py-2 rounded-xl font-semibold hover:bg-gray-800 transition">
                Register
            </a>
        </div>
    </div>
</header>

<!-- ================= BREADCRUMB ================= -->
<div class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-6 py-3 flex items-center gap-2 text-sm text-gray-500">
        <a href="{{ route('home') }}" class="hover:text-black transition">Home</a>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M9 18l6-6-6-6"/>
        </svg>
        <span class="text-gray-900 font-medium">User Manual</span>
    </div>
</div>

<!-- ================= MANUAL INFOGRAPHIC ================= -->
@include('partials.manual-infographic')

<!-- ================= FAQ TEASER ================= -->
<section class="bg-white border-t border-gray-100 py-20">
    <div class="max-w-2xl mx-auto px-6 text-center">
        <h2 class="text-2xl font-bold mb-3">Still have questions?</h2>
        <p class="text-gray-500 mb-8 leading-relaxed">
            Check the FAQ on our homepage for quick answers about
            competitions, payments, submissions, and certificates.
        </p>
        <a href="{{ route('home') }}#faq"
           class="inline-flex items-center gap-2 bg-black text-white px-8 py-3 rounded-2xl font-semibold hover:bg-gray-800 transition">
            View FAQ
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</section>

<!-- ================= FOOTER ================= -->
<footer class="bg-gray-100 text-gray-500 py-10 text-center text-sm border-t">
    © {{ date('Y') }} Rang Kala Academy. All rights reserved.
</footer>

</body>
</html>