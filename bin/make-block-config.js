const fs = require("fs");
const path = require("path");

const args = process.argv.slice(2);
if (args.length !== 1 || !args[0].includes("/")) {
    console.error("Usage: npm run make:block <namespace/block>");
    process.exit(1);
}

const [namespace, block] = args[0].split("/");
const blocksBaseDir = path.join(__dirname, "..", "src/theme/blocks");
const namespaceDir = path.join(blocksBaseDir, namespace);
const destDir = path.join(namespaceDir, block);
const destFile = path.join(destDir, `${block}.json`);
const stubFile = path.join(__dirname, "..", "bin/stubs/block-config.stub.json");

if (!fs.existsSync(stubFile)) {
    console.error("Stub file not found:", stubFile);
    process.exit(1);
}

if (!fs.existsSync(namespaceDir)) {
    fs.mkdirSync(namespaceDir, { recursive: true });
}

if (!fs.existsSync(destDir)) {
    fs.mkdirSync(destDir, { recursive: true });
}

if (fs.existsSync(destFile)) {
    console.error(`❌ File already exists: ${destFile}`);
    process.exit(1);
}

let content = fs.readFileSync(stubFile, "utf8");

// Only replace "namespace/block" (with quotes) and not the key "blocks"
content = content.replace(/"namespace\/block"/g, `"${namespace}/${block}"`);

fs.writeFileSync(destFile, content, "utf8");
console.log(`✅ Created ${destFile}`);
