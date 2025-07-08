import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/assets/css/slick.css',
                'resources/assets/css/aos.css',
                'resources/assets/css/flatpickr.min.css',
                'resources/assets/css/output.css',
                'resources/assets/css/layout.css',
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/sensitive-actions.js',
            ],
            
            refresh: true,
        }),
    ],
    css: {
        preprocessorOptions: {
            scss: {
                api: 'modern'
            }
        }
    }
});


