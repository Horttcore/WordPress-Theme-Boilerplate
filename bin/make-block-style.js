const fs = require("fs");
const path = require("path");

function slugify(str) {
    return str
        .toString()
        .toLowerCase()
        .replace(/\s+/g, "-")
        .replace(/[^\w-]+/g, "")
        .replace(/--+/g, "-")
        .replace(/^-+/, "")
        .replace(/-+$/, "");
}

const args = process.argv.slice(2);
if (args.length !== 2 || !args[0].includes("/")) {
    console.error("Usage: npm run make:style <namespace/block> <Style Name>");
    process.exit(1);
}

const [namespace, block] = args[0].split("/");
const styleName = args[1];
const slug = slugify(styleName);

const blocksBaseDir = path.join(__dirname, "..", "src/theme/blocks");
const blockDir = path.join(blocksBaseDir, namespace, block);
// Change: filename is <block>.<slug>.json
const destFile = path.join(blockDir, `${block}.${slug}.json`);
const stubFile = path.join(__dirname, "..", "bin/stubs/block-style.stub.json");

if (!fs.existsSync(stubFile)) {
    console.error("❌ Stub file not found:", stubFile);
    process.exit(1);
}

if (!fs.existsSync(blockDir)) {
    fs.mkdirSync(blockDir, { recursive: true });
}

if (fs.existsSync(destFile)) {
    console.error(`❌ File already exists: ${destFile}`);
    process.exit(1);
}

let content = fs.readFileSync(stubFile, "utf8");
content = content
    .replace(/namespace\/block/g, `${namespace}/${block}`)
    .replace(/"title":\s*"[^"]*"/, `"title": "${styleName}"`)
    .replace(/"slug":\s*"[^"]*"/, `"slug": "${slug}"`);

fs.writeFileSync(destFile, content, "utf8");
console.log(`✅ Created ${destFile}`);
