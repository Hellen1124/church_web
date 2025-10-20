{{-- resources/views/layouts/dashboard.blade.php --}}
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Dashboard - ' . config('app.name') }}</title>

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Livewire Styles --}}
    @livewireStyles

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

    <style>
        body {
            overflow-x: hidden;
            background-color: #f8fafc;
        }
        .sidebar-wrapper {
            width: 260px;
            flex-shrink: 0;
            background-color: #fff;
            border-right: 1px solid #dee2e6;
            min-height: 100vh;
        }
        .main-wrapper {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .content-area {
            flex-grow: 1;
            padding: 1.5rem;
        }
        .navbar {
            z-index: 1050;
        }
    </style>
</head>
<body>

    {{-- ✅ Navbar (shared across all dashboard pages) --}}
    @include('components.navbar')

    {{-- ✅ Main Layout Wrapper --}}
    <div class="d-flex">
        {{-- Sidebar --}}
        <div class="sidebar-wrapper">
            @include('components.sidebar')
        </div>

        {{-- Main Content Area --}}
        <div class="main-wrapper">
            <div class="content-area">
                {{ $slot ?? '' }}
            </div>

            {{-- Footer --}}
            <footer class="bg-white border-top py-2 text-center text-muted small">
                &copy; {{ date('Y') }} {{ config('app.name') }} | Church Management System
            </footer>
        </div>
    </div>

    {{-- Livewire Scripts --}}
    @livewireScripts

    {{-- WireUI Scripts (if using) --}}
    @wireUiScripts

    {{-- Bootstrap Bundle --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Lucide Icons (optional) --}}
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            lucide.createIcons();
        });
    </script>

    {{-- Redirect + Notifications --}}
    <script>
        window.addEventListener('redirect', function (event) {
            if (event.detail?.url) window.location.href = event.detail.url;
        });
    </script>

    <x-notifications />
</body>
</html>


