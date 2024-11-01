import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    publicDir: '/var/www/html/keyFood/public',  
    root: '/var/www/html/keyFood',
    outDir: '/var/www/html/keyFood/public/build',  
    server: {
        //PORT DEFAULT

        // host: '0.0.0.0', // Atau 'localhost' jika ingin spesifik ke localhost
        // host: '89.116.187.91', // Atau 'localhost' jika ingin spesifik ke localhost
        // port: 8000, // Pastikan port ini tidak digunakan oleh aplikasi lain`


        // PORT UNTUK TES MELALUI IP WIFI MASING MASING UNTUK LIVE CHAT

        // host: '172.16.16.203',

        // host: 'lapakkbk.online',
        port: 8000,
        // https: true, // Set this to true to enable HTTPS
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
