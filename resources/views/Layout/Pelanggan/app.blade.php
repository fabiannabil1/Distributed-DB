<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reponik | @yield('title')</title>
    <link rel="icon" type="image/png" href="{{ asset('img/reponik-icon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>

<body class="font-sans bg-white min-h-screen flex flex-col">

    @include('layout.Pelanggan.components.navbar')

    <main class="flex-grow p-8">
        @yield('content')
    </main>

    @include('layout.Pelanggan.components.footer')

    <script>
        function toggleDropdown() {
        const dropdown = document.getElementById('dropdownMenu');
        dropdown.classList.toggle('hidden');
        }
        document.addEventListener('click', function (event) {
        const dropdown = document.getElementById('dropdownMenu');
        const button = event.target.closest('button');
        if (!dropdown.contains(event.target) && !button) {
            dropdown.classList.add('hidden');
        }
        });
    </script>

    <script>
        feather.replace();
    </script>
</body>
</html>
