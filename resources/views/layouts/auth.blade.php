<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-gray-100 via-gray-200 to-gray-300">

    @yield('content')

</body>
</html>