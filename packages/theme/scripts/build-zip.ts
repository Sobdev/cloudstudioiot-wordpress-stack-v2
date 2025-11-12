import { createWriteStream, createReadStream, existsSync } from 'fs';
import { readdir, stat, mkdir } from 'fs/promises';
import { join, relative, dirname } from 'path';
import { fileURLToPath } from 'url';
import archiver from 'archiver';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

const THEME_DIR = join(__dirname, '..');
const BUILDS_DIR = join(dirname(dirname(THEME_DIR)), 'builds');
const VERSION = '2.0.0';
const THEME_SLUG = 'cloudstudio-hello-child';

// Files and folders to exclude
const EXCLUDE_PATTERNS = [
    'node_modules',
    'src',
    'tests',
    'scripts',
    '.git',
    '.DS_Store',
    '*.map',
    'vite.config.ts',
    'tsconfig.json',
    'package.json',
    'pnpm-lock.yaml',
];

async function shouldInclude(filePath: string): Promise<boolean> {
    const relativePath = relative(THEME_DIR, filePath);

    // Check exclude patterns
    for (const pattern of EXCLUDE_PATTERNS) {
        if (relativePath.includes(pattern)) {
            return false;
        }
    }

    return true;
}

async function addFilesToArchive(
    archive: archiver.Archiver,
    dirPath: string,
    baseDir: string = ''
): Promise<void> {
    if (!existsSync(dirPath)) {
        console.warn(`⚠️  Directory not found: ${dirPath}`);
        return;
    }

    const entries = await readdir(dirPath);

    for (const entry of entries) {
        const fullPath = join(dirPath, entry);
        const archivePath = join(baseDir, entry);

        if (!(await shouldInclude(fullPath))) {
            continue;
        }

        const stats = await stat(fullPath);

        if (stats.isDirectory()) {
            await addFilesToArchive(archive, fullPath, archivePath);
        } else if (stats.isFile()) {
            archive.append(createReadStream(fullPath), { name: archivePath });
            console.log(`  ✓ ${archivePath}`);
        }
    }
}

async function buildTheme(): Promise<void> {
    console.log('🚀 Building CloudStudio Hello Child Theme v' + VERSION);
    console.log('');

    // Check if dist exists
    const distPath = join(THEME_DIR, 'dist');
    if (!existsSync(distPath)) {
        console.error('❌ Error: dist/ folder not found. Run "pnpm build" first.');
        process.exit(1);
    }

    // Ensure builds directory exists
    await mkdir(BUILDS_DIR, { recursive: true });

    const zipPath = join(BUILDS_DIR, `${THEME_SLUG}-v${VERSION}.zip`);
    const output = createWriteStream(zipPath);
    const archive = archiver('zip', { zlib: { level: 9 } });

    archive.on('warning', (err: any) => {
        if (err.code === 'ENOENT') {
            console.warn('⚠️  Warning:', err.message);
        } else {
            throw err;
        }
    });

    archive.on('error', (err: any) => {
        throw err;
    });

    output.on('close', () => {
        const sizeInMB = (archive.pointer() / 1024 / 1024).toFixed(2);
        console.log('');
        console.log('✅ Build complete!');
        console.log('📦 File:', zipPath);
        console.log('📊 Size:', sizeInMB, 'MB');
        console.log('');
    });

    archive.pipe(output);

    console.log('📁 Adding files to archive...');
    await addFilesToArchive(archive, THEME_DIR, THEME_SLUG);

    await archive.finalize();
}

buildTheme().catch((err) => {
    console.error('❌ Build failed:', err);
    process.exit(1);
});
