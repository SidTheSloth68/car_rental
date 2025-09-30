import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
    build: {
        chunkSizeWarningLimit: 1000,
    },
    server: {
        hmr: {
            host: 'localhost',
        },
    },
    optimizeDeps: {
        include: ['axios'],
    },
});
