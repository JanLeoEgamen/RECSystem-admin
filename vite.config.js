import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 
                    'resources/css/login.css', 
                    'resources/css/register.css',
                    'resources/css/verify-email.css',
                    'resources/css/forgot-password.css',
                    'resources/css/welcome.css',
                    'resources/js/login.js',
                    'resources/js/welcome.js',
                    'resources/js/register.js',
                    'resources/js/verify-email.js',
                    'resources/js/forgot-password.js',
                    'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
