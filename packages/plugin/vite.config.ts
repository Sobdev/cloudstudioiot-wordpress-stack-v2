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
            entry: {
                'editor': resolve(__dirname, 'src/assets/editor.ts'),
                'frontend': resolve(__dirname, 'src/assets/frontend.ts'),
                'admin': resolve(__dirname, 'src/assets/admin.ts'),
            },
            formats: ['es'],
            fileName: (_format: string, entryName: string) => `${entryName}.js`,
        },
        rollupOptions: {
            external: ['jquery', 'elementor'],
            output: {
                globals: {
                    jquery: 'jQuery',
                    elementor: 'elementor',
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
