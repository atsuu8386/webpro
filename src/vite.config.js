import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';
import { glob } from 'glob';

// Auto-discover all page JS files
const pageFiles = glob.sync('resources/js/pages/**/*.js').map(file => file);

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/web.css',
                'resources/js/app.js',
                'resources/js/admin.js',
                'resources/js/web.js',
                ...pageFiles
            ],
            refresh: true,
        }),
        vue({
            include: [/\.vue$/, /\.js$/],
            exclude: [/node_modules/, /resources\/js\/web\.js$/],
            template: {
                compilerOptions: {
                    // Treat all tags starting with 'x-' as custom elements for AlpineJS
                    isCustomElement: (tag) => tag.startsWith('x-')
                }
            }
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
            'vue': 'vue/dist/vue.esm-bundler.js',
            'jquery': 'jquery/dist/jquery.min.js',
        }
    },
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    'vue': ['vue'],
                    'vendor': ['axios'],
                    'apexcharts': ['apexcharts']
                }
            }
        },
        chunkSizeWarningLimit: 600
    }
});
