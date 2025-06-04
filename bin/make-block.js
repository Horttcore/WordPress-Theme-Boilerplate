const fs = require("fs");
const path = require("path");
const readline = require("readline");

const stubsDir = path.join(__dirname, "stubs");
const blocksDir = path.join(__dirname, "..", "src/block");

function prompt(question) {
    const rl = readline.createInterface({
        input: process.stdin,
        output: process.stdout,
    });
    return new Promise((resolve) =>
        rl.question(question, (ans) => {
            rl.close();
            resolve(ans.trim());
        })
    );
}

async function main() {
    const blockName = (await prompt("Block name (e.g. my-block): ")).replace(/[^a-z0-9\-]/g, "");
    if (!blockName) {
        console.error("❌ Invalid block name.");
        process.exit(1);
    }

    const blockDir = path.join(blocksDir, blockName);
    if (fs.existsSync(blockDir)) {
        console.error("❌ Block already exists:", blockDir);
        process.exit(1);
    }
    fs.mkdirSync(blockDir, { recursive: true });

    // Copy block.json stub
    const blockJsonStub = fs.readFileSync(path.join(stubsDir, "block.stub.json"), "utf8");
    const blockJson = blockJsonStub.replace(/__BLOCK_NAME__/g, blockName);
    fs.writeFileSync(path.join(blockDir, "block.json"), blockJson);

    // Create edit.tsx, index.tsx, save.tsx from stubs
    [
        { stub: "block-edit.stub.tsx", out: "edit.tsx" },
        { stub: "block-index.stub.tsx", out: "index.tsx" },
        { stub: "block-save.stub.tsx", out: "save.tsx" },
    ].forEach(({ stub, out }) => {
        const stubPath = path.join(stubsDir, stub);
        const stubContent = fs.readFileSync(stubPath, "utf8").replace(/__BLOCK_NAME__/g, blockName);
        fs.writeFileSync(path.join(blockDir, out), stubContent);
    });

    console.log(`✅ Block "${blockName}" created in ${blockDir}`);
}

main();
