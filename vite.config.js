import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import Components from 'unplugin-vue-components/vite';
import {AntDesignVueResolver} from "unplugin-vue-components/resolvers";

export default defineConfig({
    // server: {
    //     host: '0.0.0.0',
    //     port: 5173,  // ou tout autre port que vous utilisez
    //     strictPort: true,
    //     hmr: {
    //         // host: '192.168.1.163',  // Remplacez par l'adresse IP de votre machine
    //         host: '192.168.1.113',  // Remplacez par l'adresse IP de votre machine
    //         port: 5173,
    //     }
    // },
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            ssr: 'resources/js/ssr.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        Components({
            resolvers: [
                AntDesignVueResolver({
                    importStyle: false, // css in js
                }),
            ],
        }),
    ],
});
