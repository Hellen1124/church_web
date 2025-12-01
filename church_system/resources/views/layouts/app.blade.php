<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? config('app.name', 'MyApp') }}</title>

    <!-- ============================================================
         LIVEWIRE & WIREUI STYLES/ASSETS
         ============================================================ -->

    <!-- Livewire Styles: Required CSS for Livewire components.
         Must be placed inside the <head> section. -->
    @livewireStyles

    <!-- Vite Assets: Loads compiled Tailwind CSS and JavaScript (Alpine/app.js)
         from the resources folder. -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- ============================================================
         EXTERNAL STYLES
         ============================================================ -->

    <!-- Bootstrap 5 CSS: Provides layout utilities (e.g., d-flex, container).
         WireUI uses Tailwind, but Bootstrap can help with page structure. -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts: Import 'Inter' typeface for clean, modern text rendering. -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Removed: Font Awesome CSS (to avoid conflicts with WireUI/Lucide icons). -->
</head>
<body class="bg-light min-vh-100 d-flex flex-column">

    <!-- ============================================================
         PAGE CONTENT SLOTS
         ============================================================ -->

    <!-- Main Content Area: Primary section of the page.
         The $slot will inject content from Livewire components or Blade views. -->
    <main class="flex-grow-1 py-4">
        <div class="container">
            {{ $slot ?? '' }}
        </div>
    </main>

    <!-- Footer: Standard footer element with app name and year. -->
    <footer class="bg-white border-top py-3 text-center text-muted small">
        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </footer>

    <!-- ============================================================
         EXTERNAL SCRIPTS
         ============================================================ -->

    <!-- Bootstrap 5 JS: Enables Bootstrap features (modals, dropdowns, etc.).
         Placed before Livewire/WireUI scripts so they can override if needed. -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ============================================================
         WIREUI & LIVEWIRE CORE SCRIPTS
         ============================================================ -->

    <!-- CRITICAL WireUI Component (v2.4.0):
         - Loads Alpine.js
         - Loads Livewire's JavaScript
         - Converts Lucide <i icon="..."> tags into SVGs
         Must be placed just before closing </body>. -->
    <wireui:scripts />

    <!-- Note: In older versions, this was done with @livewireScripts and @wireUiScripts. -->

    <!-- Removed: Standalone Lucide JS and custom script calls (WireUI handles automatically). -->

    <!-- ============================================================
         WIREUI NOTIFICATIONS
         ============================================================ -->

    <!-- Notifications Component: Renders area for WireUI alerts and toast messages. -->
    <x-notifications />

    <!-- Dialog Component: Renders area for WireUI confirmation dialogs. -->
    <x-dialog />

    <!-- ============================================================
         CUSTOM JAVASCRIPT
         ============================================================ -->

    <!-- Redirect Handler:
         Listens for 'redirect' events fired from Livewire components.
         When triggered, it changes the browser’s current page to the given URL. -->
    <script>
        // Listener for general 'redirect' browser event
        window.addEventListener('redirect', function (event) {
            if (! event.detail) return;
            const url = event.detail.url || null;
            if (url) {
                window.location.href = url;
            }
        });

        // Listener for Livewire V3 compatibility (after Livewire initialization)
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


