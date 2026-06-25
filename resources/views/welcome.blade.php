<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rang Kala Academy | Professional Art Competition Platform</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900">

<!-- ================= NAVBAR ================= -->
<header class="bg-white/90 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-5 flex justify-between items-center">
        <h1 class="text-xl font-bold tracking-wide">
            Rang Kala Academy
        </h1>

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

<!-- ================= HERO ================= -->
<section class="bg-white">
    <div class="max-w-7xl mx-auto px-6 py-28 grid md:grid-cols-2 gap-16 items-center">

        <div>
            <h1 class="text-5xl font-bold leading-tight mb-8">
                A Professional Platform for
                <span class="block text-gray-500 mt-2">
                    Art Competitions & Creative Excellence
                </span>
            </h1>

            <p class="text-lg text-gray-600 mb-10 max-w-xl leading-relaxed">
                Rang Kala Academy provides a structured digital ecosystem for
                managing art competitions, student submissions, jury evaluations,
                and results — built for institutions, educators, and emerging artists.
            </p>

            <div class="flex gap-4">
                <a href="{{ route('register') }}"
                   class="bg-black text-white px-8 py-4 rounded-2xl font-semibold hover:bg-gray-800 transition shadow-sm">
                    Start Competing
                </a>
                <a href="{{ route('login') }}"
                   class="border border-gray-300 text-gray-900 px-8 py-4 rounded-2xl font-semibold hover:bg-gray-100 transition">
                    Access Dashboard
                </a>
            </div>
        </div>

        <div>
            <img
                src="https://images.unsplash.com/photo-1513364776144-60967b0f800f"
                alt="Professional Art Studio"
                class="rounded-3xl shadow-2xl w-full object-cover h-[450px]"
            >
        </div>

    </div>
</section>

<!-- ================= PLATFORM FEATURES ================= -->
<section class="py-28">
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-20">
            <h2 class="text-4xl font-bold mb-4">
                Built for Structured Art Competitions
            </h2>
            <p class="text-gray-500 max-w-2xl mx-auto">
                A complete digital workflow for organizing, evaluating,
                and showcasing creative talent.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-10">

            <div class="bg-white p-10 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition">
                <h3 class="text-xl font-bold mb-4">Digital Submissions</h3>
                <p class="text-gray-600 leading-relaxed">
                    Secure artwork uploads with structured details,
                    categories, and competition tracking.
                </p>
            </div>

            <div class="bg-white p-10 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition">
                <h3 class="text-xl font-bold mb-4">Competition Management</h3>
                <p class="text-gray-600 leading-relaxed">
                    Create competitions, define eligibility, set deadlines,
                    and monitor participation in real-time.
                </p>
            </div>

            <div class="bg-white p-10 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition">
                <h3 class="text-xl font-bold mb-4">Evaluation & Scoring</h3>
                <p class="text-gray-600 leading-relaxed">
                    Jury members evaluate submissions with scores,
                    structured rubrics, and professional feedback.
                </p>
            </div>

        </div>
    </div>
</section>

<!-- ================= PROCESS ================= -->
<section class="bg-white py-28 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-20">
            <h2 class="text-4xl font-bold mb-4">How It Works</h2>
        </div>

        <div class="grid md:grid-cols-4 gap-8 text-center">

            <div class="p-8">
                <div class="text-4xl font-bold text-gray-300 mb-4">01</div>
                <p class="text-gray-700 font-medium">Register Account</p>
            </div>

            <div class="p-8">
                <div class="text-4xl font-bold text-gray-300 mb-4">02</div>
                <p class="text-gray-700 font-medium">Join Competition</p>
            </div>

            <div class="p-8">
                <div class="text-4xl font-bold text-gray-300 mb-4">03</div>
                <p class="text-gray-700 font-medium">Submit Artwork</p>
            </div>

            <div class="p-8">
                <div class="text-4xl font-bold text-gray-300 mb-4">04</div>
                <p class="text-gray-700 font-medium">Receive Results & Feedback</p>
            </div>

        </div>
    </div>
</section>

<!-- ================= USER MANUAL TEASER ================= -->
{{-- Full infographic lives at resources/views/manual.blade.php (route: 'manual') --}}
<section class="py-24 bg-gray-50 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-6">
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm px-12 py-14 flex flex-col md:flex-row items-center justify-between gap-8">

            <div class="max-w-xl">
                <span class="inline-block text-xs font-bold tracking-widest uppercase text-gray-400 mb-3">
                    Getting Started
                </span>
                <h2 class="text-3xl font-bold mb-3">New here? Read the User Manual.</h2>
                <p class="text-gray-500 leading-relaxed">
                    A step-by-step visual guide covering account creation,
                    joining competitions, submitting artwork, and collecting
                    your results and certificates.
                </p>
            </div>

            <a href="{{ route('manual') }}"
               class="flex-shrink-0 inline-flex items-center gap-3 bg-black text-white px-8 py-4 rounded-2xl font-semibold hover:bg-gray-800 transition whitespace-nowrap">
                View User Manual
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>

        </div>
    </div>
</section>

<!-- ================= FAQ ================= -->
<section id="faq" class="bg-white py-28 border-t border-gray-100">
    <div class="max-w-5xl mx-auto px-6">

        <div class="text-center mb-16">
            <span class="inline-block text-sm font-semibold tracking-widest uppercase text-gray-400 mb-4">
                Support
            </span>
            <h2 class="text-4xl md:text-5xl font-bold mb-5">
                Frequently Asked Questions
            </h2>
            <p class="text-lg text-gray-500 max-w-2xl mx-auto leading-relaxed">
                Quick answers to the most common questions about competitions,
                submissions, payments, and certificates.
            </p>
        </div>

        <div class="space-y-5">

            <details class="group bg-gray-50 border border-gray-100 rounded-3xl p-6 hover:shadow-md transition">
                <summary class="list-none cursor-pointer flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Who can participate in competitions?</h3>
                    <span class="text-2xl text-gray-300 transition duration-300 group-open:rotate-45">+</span>
                </summary>
                <p class="mt-4 text-gray-600 leading-relaxed">
                    Students, teachers, and caregivers can create accounts.
                    Participation depends on the eligibility requirements of each competition.
                </p>
            </details>

            <details class="group bg-gray-50 border border-gray-100 rounded-3xl p-6 hover:shadow-md transition">
                <summary class="list-none cursor-pointer flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">What file formats are allowed for artwork submissions?</h3>
                    <span class="text-2xl text-gray-300 transition duration-300 group-open:rotate-45">+</span>
                </summary>
                <p class="mt-4 text-gray-600 leading-relaxed">
                    Most competitions accept JPG and PNG files.
                    The maximum file size allowed is <strong>5 MB</strong>.
                </p>
            </details>

            <details class="group bg-gray-50 border border-gray-100 rounded-3xl p-6 hover:shadow-md transition">
                <summary class="list-none cursor-pointer flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Can I edit my artwork after submitting?</h3>
                    <span class="text-2xl text-gray-300 transition duration-300 group-open:rotate-45">+</span>
                </summary>
                <p class="mt-4 text-gray-600 leading-relaxed">
                    Usually no. Once your submission has been confirmed,
                    it becomes locked to ensure fairness during evaluation.
                </p>
            </details>

            <details class="group bg-gray-50 border border-gray-100 rounded-3xl p-6 hover:shadow-md transition">
                <summary class="list-none cursor-pointer flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">How do I know if my payment was successful?</h3>
                    <span class="text-2xl text-gray-300 transition duration-300 group-open:rotate-45">+</span>
                </summary>
                <p class="mt-4 text-gray-600 leading-relaxed">
                    Your payment status updates automatically, and a confirmation
                    receipt will be sent to your registered email.
                </p>
            </details>

            <details class="group bg-gray-50 border border-gray-100 rounded-3xl p-6 hover:shadow-md transition">
                <summary class="list-none cursor-pointer flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">How are certificates generated?</h3>
                    <span class="text-2xl text-gray-300 transition duration-300 group-open:rotate-45">+</span>
                </summary>
                <p class="mt-4 text-gray-600 leading-relaxed">
                    Certificates are generated by your teachers after
                    competition results or workshop completion has been finalised.
                </p>
            </details>

        </div>
    </div>
</section>

<!-- ================= CATEGORIES ================= -->
<section class="py-28">
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-20">
            <h2 class="text-4xl font-bold mb-4">Competition Categories</h2>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white p-10 rounded-3xl border shadow-sm">
                <h3 class="text-xl font-semibold mb-3">Fine Arts</h3>
                <p class="text-gray-600">Painting, sketching, illustration</p>
            </div>
            <div class="bg-white p-10 rounded-3xl border shadow-sm">
                <h3 class="text-xl font-semibold mb-3">Digital Art</h3>
                <p class="text-gray-600">Digital painting, graphic design</p>
            </div>
            <div class="bg-white p-10 rounded-3xl border shadow-sm">
                <h3 class="text-xl font-semibold mb-3">Creative Concepts</h3>
                <p class="text-gray-600">Posters, branding, visual storytelling</p>
            </div>
        </div>
    </div>
</section>

<!-- ================= CTA ================= -->
<section class="bg-black py-24 text-center text-white">
    <h2 class="text-4xl font-bold mb-6">Elevate Your Creative Journey</h2>
    <p class="text-gray-300 mb-10 text-lg">
        Join a structured, transparent, and professional art competition ecosystem.
    </p>
    <a href="{{ route('register') }}"
       class="bg-white text-black px-12 py-4 rounded-2xl font-semibold hover:bg-gray-200 transition">
        Create Your Account
    </a>
</section>

<!-- ================= FOOTER ================= -->
<footer class="bg-gray-100 text-gray-500 py-10 text-center text-sm border-t">
    © {{ date('Y') }} Rang Kala Academy. All rights reserved.
</footer>

</body>
</html>