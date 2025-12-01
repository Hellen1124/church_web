<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login • Church Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Fonts: Inter + Playfair Display for that elegant church vibe -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3 { font-family: 'Playfair Display', serif; }
        
        .gradient-bg {
            background: linear-gradient(135deg, #fff8e1 0%, #fef3c7 50%, #fdf2e0 100%);
        }
        .card-glow {
            box-shadow: 0 20px 40px rgba(180, 120, 50, 0.12);
        }
        .btn-primary {
            background: linear-gradient(to right, #d97706, #f59e0b);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(245, 158, 11, 0.3);
        }
        .input-focus:focus {
            ring-color: #f59e0b;
            border-color: #f59e0b;
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-5">

    <div class="w-full max-w-2xl">
        
        <!-- Success Notification -->
        @if (session('status'))
            <div class="mb-8 bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl flex items-center gap-3 shadow-lg">
                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="font-semibold">Verification Complete!</p>
                    <p class="text-sm opacity-90">{{ session('status') }}</p>
                </div>
            </div>
        @endif

        <!-- Main Card -->
        <div class="bg-white rounded-3xl card-glow overflow-hidden border-t-8 border-amber-500">
            
            <!-- Header Section -->
            <div class="bg-gradient-to-br from-amber-50 to-yellow-50 px-10 py-12 text-center">
                <div class="mx-auto w-24 h-24 bg-amber-100 rounded-full flex items-center justify-center mb-6 shadow-inner">
                    <svg class="w-14 h-14 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>

                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Welcome Back
                </h1>
                <p class="text-lg text-gray-700 max-w-md mx-auto leading-relaxed">
                    Your account is verified and ready. Please log in to access your church management dashboard.
                </p>
            </div>

            <!-- Login Form Section (Livewire) -->
            <div class="px-10 pb-12 pt-8">
                <div class="mb-8">
                    <livewire:auth.login-form />
                </div>

                <!-- Alternative Actions -->
                <div class="mt-10 pt-8 border-t border-gray-200 text-center space-y-4">
                    <p class="text-sm text-gray-600">
                        New to the system? 
                        <a href="{{ route('register') }}" class="font-semibold text-amber-600 hover:text-amber-700 underline-offset-4 hover:underline">
                            Create an account →
                        </a>
                    </p>
                    
                    <p class="text-xs text-gray-500">
                        Need help? 
                        <a href="{{ route('home') }}" class="text-amber-600 hover:text-amber-800 font-medium">
                            Visit the main church website
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer Trust -->
        <div class="text-center mt-10 text-gray-600 text-sm">
            <p>© {{ date('Y') }}  Gods Product • Secure & Confidential System</p>
        </div>
    </div>

    <!-- Optional: Add a subtle floating cross in background (purely decorative) -->
    <div class="fixed top-10 right-10 opacity-5 pointer-events-none">
        <svg class="w-64 h-64 text-amber-600" fill="currentColor" viewBox="0 0 24 24">
            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
        </svg>
    </div>
</body>
</html>