import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js', 
                'resources/js/auth/login.js',
                'resources/js/auth/register.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
