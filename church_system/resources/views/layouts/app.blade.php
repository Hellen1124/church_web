<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? config('app.name', 'MyApp') }}</title>

    {{-- ❌ REMOVED: @wireUiScripts (Should be at the end of the body) --}}

    {{-- ✅ Livewire Styles (Must be in head) --}}
    @livewireStyles

    {{-- ✅ Vite Assets (Must be in head, loads CSS and app.js/Alpine) --}}
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

    {{-- ❌ REMOVED: The two @livewireScripts and the one @wireUiScripts from the middle of the body --}}
    {{-- ❌ REMOVED: The @livewireScripts at the bottom --}}

    {{-- ✅ Bootstrap 5 JS (Load first) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{--
        ✅ WIREUI SCRIPTS (The ONLY required Livewire/Alpine boot script)
        WireUI includes and boots both Livewire and Alpine correctly.
        It MUST be placed AFTER Bootstrap and BEFORE any other custom script.
    --}}
    @wireUiScripts

    {{-- ✅ Notifications & Dialog Components (Must be before custom scripts) --}}
  

    

    {{-- ✅ Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            lucide.createIcons();
        });
    </script>

    {{-- ✅ Redirect handler (Custom scripts can go here) --}}
    <script>
        window.addEventListener('redirect', function (event) {
            if (! event.detail) return;
            const url = event.detail.url || null;
            if (url) {
                window.location.href = url;
            }
        });

        // Use Livewire.hook for v3 compatibility, though Livewire.on may still work
        document.addEventListener('livewire:initialized', function () { 
            if (window.Livewire) {
                Livewire.on('redirect', function(url) {
                    if (url) window.location.href = url;
                });
            }
        });
    </script>
</body>
</html>


