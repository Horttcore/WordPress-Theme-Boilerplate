#!/usr/bin/env node

const { spawn } = require("child_process");

const args = process.argv.slice(2);
const suppressedLine = 'No entry file discovered in the "src/blocks/" directory.';

// These prefixes indicate webpack noise that doesn't affect dev experience
const noisyPrefixes = [
    "assets by path",
    "assets by status",
    "asset ",
    "Entrypoint",
    "runtime modules",
    "orphan modules",
    "cacheable modules",
    "cached modules",
    "javascript modules",
    "css modules",
    "modules by path",
    "css ./",
    "./src/",
    "> ", // Dependencies tree
    "at ", // Stack trace lines
    "Generated code for", // Generated code metadata
];

// Patterns that match noise lines (partial matches anywhere in line)
const noisyPatterns = [
    /\[built\].*\[code generated\]/, // Webpack [built] [code generated] metadata
    /\d+ bytes \[built\]/, // Byte counts
    /modules with errors|true errors/, // Error count metadata
    /\(\d+ bytes\)/, // Size indicators
    /\(runtime\)/, // Runtime markers
    /^\s+\.\/src\/.+\d+ bytes/, // Module path with bytes (metadata, not actual errors)
    /\d+\s*\|\s*throw new Error/, // Generated code throw statements (line numbers + throw)
    /^Generated code for/, // Generated code header
    /^-- inner error --/, // Inner error separator (shows error again)
];

// Error patterns that should be preserved
const errorPatterns = [
    /^error\s|error\s*:/i, // Starts with "error" or has "error:"
    /failed|failure/i,
    /cannot find|module not found|no such file/i,
    /syntax\s*error|type\s*error/i,
    /✖|×|⚠️/,
];

const isErrorLine = (line) => errorPatterns.some((pattern) => pattern.test(line));
const isNoisyLine = (line) => noisyPatterns.some((pattern) => pattern.test(line));

const child = spawn("wp-scripts", args, {
    stdio: ["inherit", "pipe", "pipe"],
    shell: true,
});

const filterStream = (stream, write) => {
    let buffer = "";
    stream.on("data", (chunk) => {
        buffer += chunk.toString();
        const lines = buffer.split(/\r?\n/);
        buffer = lines.pop() || "";
        for (const line of lines) {
            if (line === suppressedLine) {
                continue;
            }
            const trimmed = line.trim();

            // Skip empty lines
            if (!trimmed) {
                continue;
            }

            // Filter webpack noise by prefix (check first to catch generated code)
            if (noisyPrefixes.some((prefix) => trimmed.startsWith(prefix))) {
                continue;
            }

            // Filter webpack noise by patterns (check before error lines to exclude generated code)
            if (isNoisyLine(trimmed)) {
                continue;
            }

            // Preserve error lines (after filtering generated code)
            if (isErrorLine(line)) {
                write(line + "\n");
                continue;
            }

            write(line + "\n");
        }
    });
    stream.on("end", () => {
        if (buffer && buffer !== suppressedLine) {
            write(buffer + "\n");
        }
    });
};

filterStream(child.stdout, (text) => process.stdout.write(text));
filterStream(child.stderr, (text) => process.stderr.write(text));

child.on("exit", (code) => process.exit(code ?? 1));
