import { defineConfig } from 'vite';
import { fileURLToPath } from 'node:url';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import { svelte } from '@sveltejs/vite-plugin-svelte';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/animotion.css',
                'resources/js/app.js',
                'resources/js/inertia.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
        svelte(),
    ],
    resolve: {
        alias: {
            // @animotion/core ships a SvelteKit `$app/environment` import;
            // map it to a shim so it works outside SvelteKit.
            '$app/environment': fileURLToPath(
                new URL('./resources/js/shims/app-environment.js', import.meta.url),
            ),
        },
    },
});
