import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js', 
                'resources/js/auth/login.js',
                'resources/js/auth/register.js',
                'resources/js/index.js',
                'resources/js/addproduct.js',
                'resources/js/manageproduct.js',
                'resources/js/editproduct.js',
                'resources/js/shippingdetail.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: '192.168.81.189', // Replace this with your actual local IP
        port: 5173,             // Ensure it's the same as Vite's output
        strictPort: true,
        hmr: {
          clientPort: 5173,      // Ensures HMR works over network
          host: '192.168.81.189' // Ensures correct WebSocket connection
        },
        cors: {
            origin: '*',
            methods: ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
            allowedHeaders: ['Content-Type', 'Authorization'],
        },
    },
});
