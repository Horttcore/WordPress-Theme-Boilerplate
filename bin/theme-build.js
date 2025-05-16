const fs = require("fs");
const path = require("path");

const srcDir = path.join(__dirname, "..", "src/theme");
const outputFile = path.join(__dirname, "..", "theme.json");
const outputBlocksDir = path.join(__dirname, "..", "theme/blocks");

const DEBUG = false;

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
    // Read the base stub file
    const baseFile = path.join(srcDir, "theme.stub.json");
    let themeJson = JSON.parse(fs.readFileSync(baseFile, "utf8"));

    // Read and merge only JSON files matching their parent folder name
    const mergedFiles = [];
    getMatchingJsonFiles(srcDir).forEach((filePath) => {
        if (!filePath.endsWith("theme.stub.json")) {
            try {
                const fileContent = JSON.parse(
                    fs.readFileSync(filePath, "utf8"),
                );
                themeJson = deepMerge(themeJson, fileContent);
                mergedFiles.push(path.relative(srcDir, filePath));
            } catch (error) {
                console.error(`❌ Error parsing JSON in file: ${filePath}`);
                console.error(`💡 Details: ${error.message}`);
                console.error(
                    "🚨 Build process stopped due to JSON parsing error.",
                );
                return; // Stop the build process
            }
        }
    });

    // Log the merged files
    if (DEBUG) {
        console.log("Merged files:", mergedFiles);
    }

    // Write the merged JSON to the output file
    fs.writeFileSync(outputFile, JSON.stringify(themeJson, null, 2));
    console.log("✅ theme.json has been built successfully.");

    // Copy block style files
    const srcBlocksDir = path.join(srcDir, "blocks");
    const destStylesDir = path.join(__dirname, "..", "styles");
    copyBlockStyleFiles(srcBlocksDir, destStylesDir);
    console.log("✅ Block style files copied.");
}

// Watch for changes in the src/theme folder
if (process.argv.includes("--watch")) {
    console.log("👀 Watching for changes in src/theme...");
    fs.watch(srcDir, { recursive: true }, (eventType, filename) => {
        if (filename && filename.endsWith(".json")) {
            console.log(`✏️ File changed: ${filename}`);
            buildTheme();
        }
    });
} else {
    buildTheme();
}
