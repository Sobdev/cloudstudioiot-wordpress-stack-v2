import { defineConfig } from 'vite';
import { resolve, dirname } from 'path';
import { fileURLToPath } from 'url';
import autoprefixer from 'autoprefixer';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

export default defineConfig({
    build: {
        outDir: 'dist',
        emptyOutDir: true,
        lib: {
            entry: resolve(__dirname, 'src/main.ts'),
            formats: ['es'],
            fileName: () => 'main.js',
        },
        rollupOptions: {
            external: ['jquery'],
            output: {
                globals: {
                    jquery: 'jQuery',
                },
                assetFileNames: (assetInfo: any) => {
                    if (assetInfo.name?.endsWith('.css')) {
                        return 'css/[name][extname]';
                    }
                    return 'assets/[name][extname]';
                },
            },
        },
        sourcemap: process.env.NODE_ENV === 'development',
        minify: process.env.NODE_ENV === 'production' ? 'terser' : false,
    },
    css: {
        postcss: {
            plugins: [autoprefixer],
        },
    },
    resolve: {
        alias: {
            '@': resolve(__dirname, 'src'),
            '@cloudstudio/shared': resolve(__dirname, '../shared/src'),
        },
    },
});
