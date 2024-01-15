import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/js/common.js',
                'resources/js/modules/utilization.js',
            ],
            refresh: true,
        }),
    ],
});
