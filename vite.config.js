import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import { fileURLToPath, URL } from 'node:url'

/**
 * =====================================================
 * AUROSUNRISE RECORDS — Vite Configuration
 * =====================================================
 *
 * 📚 LEARNING NOTE: Vite is the build tool that:
 * 1. Bundles your Vue components and JS into browser-ready files
 * 2. Provides a dev server with Hot Module Replacement (HMR)
 *    — when you save a .vue file, the browser updates INSTANTLY
 *    without a full page reload!
 * 3. Handles CSS, PostCSS, and asset optimization
 *
 * Commands:
 *   npm run dev   → Start dev server (http://localhost:5173)
 *   npm run build → Build for production (outputs to public/build/)
 */

export default defineConfig({
    plugins: [
        // Laravel plugin handles the @vite() blade directive
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js'
            ],
            refresh: true, // Auto-refresh on blade file changes
        }),

        // Vue plugin enables .vue Single File Component support
        vue({
            template: {
                transformAssetUrls: {
                    // Automatically resolve asset URLs in templates
                    base: null,
                    includeAbsolute: false,
                }
            }
        }),
    ],

    resolve: {
        alias: {
            // @ = resources/js — use instead of long relative paths
            // e.g. import Comp from '@/components/Comp.vue'
            '@': fileURLToPath(new URL('./resources/js', import.meta.url)),
        }
    },

    server: {
        // Port 5174 — avoids conflict with Auromax Digital on 5173
        host: 'localhost',
        port: 5174,
    }
})
