import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            // 💡 FIX: Explicitly specify paths, including WireUI vendor files.
            refresh: [
                'resources/views/**',
                'app/Livewire/**',
                'app/Forms/Components/**',
                // CRITICAL LINE 1: Watches WireUI Blade files for component updates
                'vendor/wireui/wireui/src/View/**/*.php',
                // CRITICAL LINE 2: Watches WireUI component PHP classes
                'vendor/wireui/wireui/src/WireUi/**/*.php',
            ],
        }),
    ],
});
