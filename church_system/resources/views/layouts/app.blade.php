<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? config('app.name', 'MyApp') }}</title>

    {{-- ✅ WireUI Scripts must come first --}}
    @wireUiScripts

    {{-- ✅ Livewire Styles --}}
    @livewireStyles

    {{-- ✅ Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ✅ Bootstrap & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light min-vh-100 d-flex flex-column">

    

    {{-- ✅ Main Content Area --}}
    <main class="flex-grow-1 py-4">
        <div class="container">
            {{ $slot ?? '' }}
        </div>
    </main>

    {{-- ✅ Footer --}}
    <footer class="bg-white border-top py-3 text-center text-muted small">
        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </footer>

    {{-- ✅ Livewire + WireUI --}}
    @livewireScripts
    @wireUiScripts

    {{-- ✅ Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            lucide.createIcons();
        });
    </script>

    {{-- ✅ Redirect handler --}}
    <script>
        window.addEventListener('redirect', function (event) {
            if (! event.detail) return;
            const url = event.detail.url || null;
            if (url) {
                window.location.href = url;
            }
        });

        document.addEventListener('livewire:load', function () {
            if (window.Livewire) {
                Livewire.on('redirect', function(url) {
                    if (url) window.location.href = url;
                });
            }
        });
    </script>

   {{-- ✅ Livewire Scripts (must come after all content) --}}
    @livewireScripts

    {{-- ✅ WireUI Notifications & Dialog Components --}}
    <x-notifications />
    <x-dialog />

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


