<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title ?? 'Admin Dashboard - ' . config('app.name') }}</title>

    {{-- ✅ Livewire Styles (Must be in head) --}}
    @livewireStyles
    
    {{-- ✅ Vite (bundles Alpine, Tailwind CSS, app.js, etc.) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ✅ External libraries --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    {{-- ✅ Custom layout styles --}}
    <style>
        body {
            background-color: #f9fafb;
            color: #1f2937;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .sidebar-wrapper {
            z-index: 10 !important;
            position: fixed !important;
            top: 0 !important;
            bottom: 0 !important;
            left: 0 !important;
            width: 250px !important;
        }

        .navbar {
            z-index: 900 !important;
            position: fixed !important;
            top: 0 !important;
            left: 250px !important;
            right: 0 !important;
        }

        main {
            z-index: 1 !important;
            margin-left: 250px !important;
            padding: 5rem 2rem 2rem 2rem !important;
            flex: 1;
            display: flex;
            flex-direction: column;
            position: relative !important;
        }

        .content-wrapper, main { overflow: visible !important; }

        footer {
            text-align: center;
            font-size: 0.875rem;
            color: #6b7280;
            margin-top: 2rem;
        }
    </style>

    @stack('styles')
</head>

<body>
    @auth
        {{-- Navbar --}}
        @include('components.navbar', [
            'user' => Auth::user(),
            'tenant' => Auth::user()->tenant ?? null,
        ])

        {{-- Sidebar --}}
        <div class="sidebar-wrapper">
            @include('components.sidebar', [
                'role' => Auth::user()->getRoleNames()->first(),
            ])
        </div>

        {{-- Main Content --}}
        <main>
            <div class="content-wrapper container-fluid">
                @yield('content')
            </div>
        </main>

        <footer>&copy; {{ date('Y') }} {{ config('app.name') }} — Church Management System</footer>
    @else
        {{-- Guest (Login/Register) --}}
        <div class="d-flex justify-content-center align-items-center vh-100">
            @yield('content')
        </div>
    @endauth

    {{-- ✅ External Scripts (Bootstrap) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- ✅ WireUI Scripts (boots Livewire + Alpine automatically) --}}
    @wireUiScripts

    {{-- ✅ Notifications & Dialog (only for authenticated users) --}}
    @auth
        <x-notifications />
        <x-dialog />
    @endauth

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    });

    // Re-init after Livewire updates
    document.addEventListener('livewire:load', () => {
        lucide.createIcons();
    });
</script>

    {{-- ✅ Redirect handler --}}
    <script>
        window.addEventListener('redirect', function (event) {
            if (!event.detail) return;
            const url = event.detail.url || null;
            if (url) window.location.href = url;
        });

        document.addEventListener('livewire:initialized', function () {
            if (window.Livewire) {
                Livewire.on('redirect', function (url) {
                    if (url) window.location.href = url;
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>


