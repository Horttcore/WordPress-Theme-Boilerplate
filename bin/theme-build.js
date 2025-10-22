const fs = require("fs");
const path = require("path");

const srcDir = path.join(__dirname, "..", "src/theme");
const outputFile = path.join(__dirname, "..", "theme.json");
const outputBlocksDir = path.join(__dirname, "..", "theme/blocks");

const DEBUG = false;

// ANSI color codes for beautiful console output
const colors = {
    reset: '\x1b[0m',
    bright: '\x1b[1m',
    dim: '\x1b[2m',
    red: '\x1b[31m',
    green: '\x1b[32m',
    yellow: '\x1b[33m',
    blue: '\x1b[34m',
    magenta: '\x1b[35m',
    cyan: '\x1b[36m',
    white: '\x1b[37m',
    gray: '\x1b[90m'
};

// Helper function to format console output with colors and styling
function log(message, color = 'white', style = '') {
    const colorCode = colors[color] || colors.white;
    const styleCode = colors[style] || '';
    console.log(`${styleCode}${colorCode}${message}${colors.reset}`);
}

// Helper function to create a divider line
function divider(char = '─', length = 50) {
    log(char.repeat(length), 'gray', 'dim');
}

// Helper function to format time duration
function formatDuration(ms) {
    if (ms < 1000) return `${ms}ms`;
    return `${(ms / 1000).toFixed(2)}s`;
}

// Helper function to display a banner
function showBanner() {
    console.log();
    log('┌' + '─'.repeat(48) + '┐', 'cyan', 'bright');
    log('│' + '          🎨 Theme Build Tool v1.0          '.padEnd(48) + '│', 'cyan', 'bright');
    log('└' + '─'.repeat(48) + '┘', 'cyan', 'bright');
    console.log();
}

// Helper function to deep merge objects
function deepMerge(target, source) {
    for (const key of Object.keys(source)) {
        if (source[key] instanceof Object && key in target) {
            Object.assign(source[key], deepMerge(target[key], source[key]));
        }
    }
    return { ...target, ...source };
}

// Helper function to get JSON files that match their parent folder name
function getMatchingJsonFiles(dir) {
    let files = [];
    fs.readdirSync(dir).forEach((file) => {
        const filePath = path.join(dir, file);
        if (fs.statSync(filePath).isDirectory()) {
            const folderName = path.basename(filePath);
            const jsonFile = path.join(filePath, `${folderName}.json`);
            if (fs.existsSync(jsonFile)) {
                files.push(jsonFile);
            }
            // Recursively check subfolders
            files = files.concat(getMatchingJsonFiles(filePath));
        }
    });
    return files;
}

// Helper to copy style files (<block>.<slug>.json) to styles/<block>.<slug>.json (flat, no subfolders)
function copyBlockStyleFiles(srcBlocksDir, destStylesDir) {
    if (!fs.existsSync(srcBlocksDir)) return;
    // Ensure the destination directory is ./styles (not ./theme/blocks)
    if (!fs.existsSync(destStylesDir)) {
        fs.mkdirSync(destStylesDir, { recursive: true });
    }
    // Recursively walk all subfolders and copy matching files flat to destStylesDir
    function walk(dir) {
        fs.readdirSync(dir).forEach((item) => {
            const itemPath = path.join(dir, item);
            if (fs.statSync(itemPath).isDirectory()) {
                walk(itemPath);
            } else if (/^[^.]+?\.[^.]+\.json$/.test(item)) {
                const destFile = path.join(destStylesDir, item);
                fs.copyFileSync(itemPath, destFile);
            }
        });
    }
    walk(srcBlocksDir);
}

function buildTheme() {
    const buildStartTime = Date.now();
    showBanner();

    log('🚀 Starting theme build process...', 'cyan', 'bright');
    divider();

    // Read the base stub file
    const baseFile = path.join(srcDir, "theme.stub.json");
    log(`📖 Reading base theme file: ${path.basename(baseFile)}`, 'blue');
    let themeJson = JSON.parse(fs.readFileSync(baseFile, "utf8"));

    // Read and merge only JSON files matching their parent folder name
    const mergedFiles = [];
    log('🔍 Scanning for matching JSON files...', 'yellow');

    getMatchingJsonFiles(srcDir).forEach((filePath) => {
        if (!filePath.endsWith("theme.stub.json")) {
            try {
                const fileContent = JSON.parse(
                    fs.readFileSync(filePath, "utf8"),
                );
                themeJson = deepMerge(themeJson, fileContent);
                const relativePath = path.relative(srcDir, filePath);
                mergedFiles.push(relativePath);
                log(`  ✓ Merged: ${relativePath}`, 'green');
            } catch (error) {
                log(`❌ Error parsing JSON in file: ${filePath}`, 'red', 'bright');
                log(`💡 Details: ${error.message}`, 'yellow');
                log('🚨 Build process stopped due to JSON parsing error.', 'red', 'bright');
                return; // Stop the build process
            }
        }
    });

    // Merge all JSON files from src/theme/settings
    const settingsDir = path.join(srcDir, "settings");
    if (fs.existsSync(settingsDir)) {
        log('⚙️  Processing settings files...', 'magenta');
        const settingsFiles = fs.readdirSync(settingsDir).filter(file => file.endsWith('.json'));

        settingsFiles.forEach((file) => {
            const filePath = path.join(settingsDir, file);
            try {
                const fileContent = JSON.parse(
                    fs.readFileSync(filePath, "utf8"),
                );
                themeJson = deepMerge(themeJson, fileContent);
                const relativePath = path.relative(srcDir, filePath);
                mergedFiles.push(relativePath);
                log(`  ✓ Merged: ${relativePath}`, 'green');
            } catch (error) {
                log(`❌ Error parsing JSON in file: ${filePath}`, 'red', 'bright');
                log(`💡 Details: ${error.message}`, 'yellow');
                log('🚨 Build process stopped due to JSON parsing error.', 'red', 'bright');
                return; // Stop the build process
            }
        });

        log(`  📊 Processed ${settingsFiles.length} settings file(s)`, 'gray', 'dim');
    }

    // Merge all JSON files from src/theme/tokens
    const tokensDir = path.join(srcDir, "tokens");
    if (fs.existsSync(tokensDir)) {
        log('🎨 Processing design tokens...', 'magenta');
        const tokenFiles = fs.readdirSync(tokensDir).filter(file => file.endsWith('.json'));

        tokenFiles.forEach((file) => {
            const filePath = path.join(tokensDir, file);
            try {
                const fileContent = JSON.parse(
                    fs.readFileSync(filePath, "utf8"),
                );
                themeJson = deepMerge(themeJson, fileContent);
                const relativePath = path.relative(srcDir, filePath);
                mergedFiles.push(relativePath);
                log(`  ✓ Merged: ${relativePath}`, 'green');
            } catch (error) {
                log(`❌ Error parsing JSON in file: ${filePath}`, 'red', 'bright');
                log(`💡 Details: ${error.message}`, 'yellow');
                log('🚨 Build process stopped due to JSON parsing error.', 'red', 'bright');
                return; // Stop the build process
            }
        });

        log(`  📊 Processed ${tokenFiles.length} token file(s)`, 'gray', 'dim');
    }

    // Log the merged files in debug mode
    if (DEBUG) {
        divider();
        log("📝 Debug: Merged files list", 'yellow');
        mergedFiles.forEach(file => log(`  - ${file}`, 'gray'));
    }

    divider();
    log('📝 Writing theme.json file...', 'blue');

    // Write the merged JSON to the output file
    fs.writeFileSync(outputFile, JSON.stringify(themeJson, null, 2));
    const outputSize = (fs.statSync(outputFile).size / 1024).toFixed(2);
    log(`✅ theme.json created successfully (${outputSize} KB)`, 'green', 'bright');

    // Copy block style files
    log('📁 Copying block style files...', 'blue');
    const srcBlocksDir = path.join(srcDir, "blocks");
    const destStylesDir = path.join(__dirname, "..", "styles");
    copyBlockStyleFiles(srcBlocksDir, destStylesDir);
    log('✅ Block style files copied successfully', 'green', 'bright');

    // Build completion summary
    const buildEndTime = Date.now();
    const buildDuration = buildEndTime - buildStartTime;

    divider();
    log('🎉 Build completed successfully!', 'green', 'bright');
    log(`⏱️  Total time: ${formatDuration(buildDuration)}`, 'cyan');
    log(`📦 Files processed: ${mergedFiles.length + 1}`, 'cyan'); // +1 for theme.stub.json
    console.log();
}

// Watch for changes in the src/theme folder
if (process.argv.includes("--watch")) {
    log("👀 Watching for changes in src/theme...", 'cyan', 'bright');
    log("Press Ctrl+C to stop watching", 'gray', 'dim');
    console.log();

    fs.watch(srcDir, { recursive: true }, (eventType, filename) => {
        if (filename && filename.endsWith(".json")) {
            log(`✏️  File changed: ${filename}`, 'yellow');
            log("🔄 Rebuilding theme...", 'cyan');
            buildTheme();
        }
    });
} else {
    buildTheme();
}
