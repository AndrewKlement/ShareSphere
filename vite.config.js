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
                'resources/js/productview.js',
                'resources/js/cart.js',
                'resources/js/checkout.js',
                'resources/js/transaction.js',
                'resources/js/return.js',
                'resources/js/returndue.js',
                'resources/js/returnrequest.js',
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
        host: '127.0.0.1', // Replace this with your actual local IP
        port: 5173,             // Ensure it's the same as Vite's output
        strictPort: true,
        hmr: {
          clientPort: 5173,      // Ensures HMR works over network
          host: '127.0.0.1' // Ensures correct WebSocket connection
        },
        cors: {
            origin: '*',
            methods: ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
            allowedHeaders: ['Content-Type', 'Authorization'],
        },
    },
});
