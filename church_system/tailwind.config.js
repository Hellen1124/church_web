/** @type {import('tailwindcss').Config} */
export default {
    
    // 🔑 FIX 1: Add the WireUI preset
    presets: [
        require("./vendor/wireui/wireui/tailwind.config.js")
    ],

   content: [
    // Your existing paths (don't remove these!):
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    // Add these for Lucide:
    './vendor/mallardduck/blade-lucide-icons/resources/views/components/**/*.blade.php',
    // If you published SVGs (optional):
    './resources/svg/lucide/*.svg',
    // Also add for WireUI and Livewire if not already:
    './vendor/wireui/**/*.blade.php',
    './app/Livewire/**/*.php',
  ],
    darkMode: 'class',
    theme: {
        extend: {},
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
}
