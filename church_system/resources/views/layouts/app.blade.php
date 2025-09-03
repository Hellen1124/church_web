<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'MyApp' }}</title>

    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
   
     
    @livewireStyles
    

 @wireUiScripts
  </head>
  <body class="antialiased bg-gray-50 min-h-screen">
    <main class="container mx-auto p-6">
      {{ $slot ?? '' }}
      {{-- or: @yield('content') if using @section --}}
    </main>

     @livewireScripts


    @wireUiScripts
  </body>
</html>
