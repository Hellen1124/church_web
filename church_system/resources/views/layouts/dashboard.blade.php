<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title ?? 'Admin Dashboard - ' . config('app.name') }}</title>

    {{-- ✅ WireUI core scripts must load first --}}
    @wireUiScripts

    {{-- ✅ Livewire styles --}}
    @livewireStyles

    {{-- ✅ Vite assets (Tailwind, JS, etc.) --}}
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
/* === WIREUI NOTIFICATION FIX: BUTTON SPACING & WIDTH === */
.wireui-notification {
    max-width: 460px !important; /* widen notification box */
    word-wrap: break-word !important;
    white-space: normal !important;
}

/* Force action buttons to display as flex (WireUI confirm buttons) */
.wireui-notification button + button {
    margin-left: 1.5rem !important; /* adds space between Yes and No */
}

/* OPTIONAL: give all buttons consistent styling */
.wireui-notification button {
    min-width: 130px !important;
    padding: 0.6rem 1rem !important;
    border-radius: 0.5rem !important;
    font-weight: 500 !important;
    text-align: center !important;
}

/* Make Cancel button secondary */
.wireui-notification button:last-child {
    background-color: #f3f4f6 !important;
    color: #374151 !important;
    border: 1px solid #e5e7eb !important;
}

.wireui-notification button:last-child:hover {
    background-color: #e5e7eb !important;
}





        /* Ensure stacking order */
        .max-w-4xl { position: relative !important; z-index: 1 !important; }
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

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .page-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #374151;
        }

        .content-card {
            background-color: #fff;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            padding: 1.5rem;
        }

        table thead { background-color: #f3f4f6; }
        table th { font-weight: 600; color: #4b5563; }
        table td { vertical-align: middle; color: #374151; }

        .btn-primary-custom {
            background-color: #d97706;
            color: #fff;
            font-weight: 500;
            border: none;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            transition: all 0.2s ease;
        }

        .btn-primary-custom:hover { background-color: #b45309; }

        footer {
            text-align: center;
            font-size: 0.875rem;
            color: #6b7280;
            margin-top: 2rem;
        }
    </style>

    {{-- ✅ Allow child views to add extra styles --}}
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
            <footer>&copy; {{ date('Y') }} {{ config('app.name') }} — Church Management System</footer>
        </main>
    @else
        <div class="d-flex justify-content-center align-items-center vh-100">
            <div class="text-center">
                <h3>Unauthorized Access</h3>
                <p>Please <a href="{{ route('login') }}">login</a> to continue.</p>
            </div>
        </div>
    @endauth

    {{-- ✅ Core scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
    @wireUiScripts

    {{-- ✅ Global notifications --}}
    <div style="position: fixed; top: 0; left: 0; z-index: 100000;">
        <x-notifications />
    </div>

    {{-- ✅ Allow child views to inject scripts --}}
    @stack('scripts')
</body>
</html>




