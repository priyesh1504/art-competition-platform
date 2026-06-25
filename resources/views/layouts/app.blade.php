<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100 text-gray-800">

    <!-- Wrapper -->
    <div class="min-h-screen flex flex-col">

        <!-- Navbar -->
        @include('layouts.navigation')

        <!-- Page Content -->
        <main id="main-content" class="flex-1 w-full px-4 sm:px-6 py-6 sm:py-8">

            <!-- Optional Header -->
            @hasSection('header')
                <div class="mb-6 sm:mb-8">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-800">
                        @yield('header')
                    </h2>
                </div>
            @endif

            <!-- Main Page Content -->
            <div class="w-full">
                @yield('content')
            </div>

        </main>

        <!-- Footer -->
        <footer class="bg-white border-t py-4 text-center text-sm text-gray-500 px-4">
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </footer>

    </div>

    <!-- Read Aloud Script -->
    <script>
        let speechActive = false;
        let utterance = null;

        function toggleSpeech() {
            // Handle both desktop and mobile buttons
            const btnDesktop = document.getElementById('speech-btn');
            const btnMobile = document.getElementById('speech-btn-mobile');

            if (speechActive) {
                window.speechSynthesis.cancel();
                speechActive = false;

                if (btnDesktop) btnDesktop.textContent = 'Read Aloud';
                if (btnMobile) btnMobile.childNodes[btnMobile.childNodes.length - 1].textContent = ' Read Aloud';

                return;
            }

            const main = document.getElementById('main-content');

            if (!main) return;

            const text = main.innerText.trim();

            if (!text) return;

            utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = document.documentElement.lang || 'en-US';

            utterance.onend = () => {
                speechActive = false;
                if (btnDesktop) btnDesktop.textContent = 'Read Aloud';
            };

            speechActive = true;

            if (btnDesktop) btnDesktop.textContent = 'Stop Reading';

            window.speechSynthesis.cancel();
            window.speechSynthesis.speak(utterance);
        }
    </script>

</body>
</html>