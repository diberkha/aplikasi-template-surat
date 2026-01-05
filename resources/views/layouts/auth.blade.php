<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login - E-Office')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            min-height: 100vh;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col items-center justify-center p-4">
    <div class="w-full flex-grow flex items-center justify-center">
        @yield('content')
    </div>

    <footer class="text-center text-white/90 text-sm py-4">
        &copy; 2025 <span class="font-semibold">RSUD dr. Soeratno Gemolong</span>. All rights reserved.
    </footer>
</body>

</html>
