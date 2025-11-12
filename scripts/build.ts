#!/usr/bin/env tsx

/**
 * Master Build Script for CloudStudio WordPress Stack v2
 * 
 * Builds both plugin and theme, then creates production-ready ZIPs
 */

import { exec } from 'child_process';
import { promisify } from 'util';
import { existsSync } from 'fs';
import { join } from 'path';

const execAsync = promisify(exec);

const PACKAGES = ['plugin', 'theme'];
const BUILDS_DIR = join(process.cwd(), 'builds');

interface BuildResult {
    package: string;
    success: boolean;
    error?: string;
    duration: number;
}

async function runCommand(command: string, cwd: string): Promise<void> {
    console.log(`  $ ${command}`);
    const { stdout, stderr } = await execAsync(command, { cwd });
    if (stdout) console.log(stdout);
    if (stderr) console.error(stderr);
}

async function buildPackage(packageName: string): Promise<BuildResult> {
    const startTime = Date.now();
    const packageDir = join(process.cwd(), 'packages', packageName);

    try {
        console.log(`\n${'='.repeat(60)}`);
        console.log(`📦 Building ${packageName}...`);
        console.log('='.repeat(60));

        // Step 1: Build assets with Vite
        console.log('\n1️⃣ Building assets with Vite...');
        await runCommand('pnpm build', packageDir);

        // Step 2: Create ZIP
        console.log('\n2️⃣ Creating ZIP file...');
        await runCommand('pnpm build:zip', packageDir);

        const duration = Date.now() - startTime;
        console.log(`\n✅ ${packageName} built successfully in ${(duration / 1000).toFixed(2)}s`);

        return { package: packageName, success: true, duration };
    } catch (error) {
        const duration = Date.now() - startTime;
        console.error(`\n❌ ${packageName} build failed:`, error);
        return {
            package: packageName,
            success: false,
            error: error instanceof Error ? error.message : String(error),
            duration,
        };
    }
}

async function verifyBuilds(): Promise<boolean> {
    console.log('\n📋 Verifying builds...');

    const expectedFiles = [
        'cloudstudio-elementor-widgets-v2.0.0.zip',
        'cloudstudio-hello-child-v2.0.0.zip',
    ];

    let allExist = true;

    for (const file of expectedFiles) {
        const filePath = join(BUILDS_DIR, file);
        const exists = existsSync(filePath);

        if (exists) {
            console.log(`  ✅ ${file}`);
        } else {
            console.log(`  ❌ ${file} - NOT FOUND`);
            allExist = false;
        }
    }

    return allExist;
}

async function main(): Promise<void> {
    console.log('╔════════════════════════════════════════════════════════════╗');
    console.log('║   CloudStudio WordPress Stack v2 - Master Build Script    ║');
    console.log('╚════════════════════════════════════════════════════════════╝');

    const startTime = Date.now();
    const results: BuildResult[] = [];

    // Build all packages
    for (const packageName of PACKAGES) {
        const result = await buildPackage(packageName);
        results.push(result);
    }

    // Verify all builds
    const allVerified = await verifyBuilds();

    // Summary
    console.log('\n' + '='.repeat(60));
    console.log('📊 BUILD SUMMARY');
    console.log('='.repeat(60));

    const totalDuration = Date.now() - startTime;
    const successCount = results.filter((r) => r.success).length;
    const failCount = results.length - successCount;

    for (const result of results) {
        const status = result.success ? '✅' : '❌';
        const time = (result.duration / 1000).toFixed(2);
        console.log(`${status} ${result.package.padEnd(20)} ${time}s`);
        if (result.error) {
            console.log(`   Error: ${result.error}`);
        }
    }

    console.log('');
    console.log(`Total packages: ${results.length}`);
    console.log(`✅ Successful:   ${successCount}`);
    console.log(`❌ Failed:       ${failCount}`);
    console.log(`⏱️  Total time:   ${(totalDuration / 1000).toFixed(2)}s`);
    console.log('');

    if (failCount > 0 || !allVerified) {
        console.error('❌ Build completed with errors.');
        process.exit(1);
    }

    console.log('✨ All builds completed successfully!');
    console.log('📦 ZIPs ready in builds/');
    console.log('');
}

main().catch((error) => {
    console.error('💥 Build script failed:', error);
    process.exit(1);
});
