import { defineConfig } from 'vite'
import laravel, { refreshPaths } from 'laravel-vite-plugin'

export default defineConfig({
    server: {
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        hmr: {
            host: 'localhost',
            port: 5173,
            protocol: 'ws'
        },
        cors: true
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', "resources/js/filter.js", "resources/js/maps.js", "resources/js/zoom.js"],
            refresh: [
                ...refreshPaths,
                'app/Livewire/**',
            ],
        }),
    ],
})
