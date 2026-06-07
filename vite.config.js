import { fileURLToPath } from 'node:url';
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from "@vitejs/plugin-vue";
import { quasar, transformAssetUrls } from '@quasar/vite-plugin';

// Project root, so Sass can resolve @quasar/vite-plugin's injected
// `@import 'resources/css/quasar-variables.sass'` (root-relative) under the
// modern Sass compiler API used by @quasar/vite-plugin >= 1.8.
const projectRoot = fileURLToPath(new URL('.', import.meta.url));

export default defineConfig({
    css: {
        preprocessorOptions: {
            sass: { loadPaths: [projectRoot] },
            scss: { loadPaths: [projectRoot] },
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: { transformAssetUrls }
        }),
        quasar({
            sassVariables: 'resources/css/quasar-variables.sass'
        })
    ],
});
