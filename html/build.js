const fs = require('fs');
const path = require('path');

const partialsDir = path.join(__dirname, 'partials');
const templatesDir = path.join(__dirname, 'templates');
const outputDir = __dirname;

// Đọc template chính
const templatePath = path.join(templatesDir, 'index.template.html');
if (!fs.existsSync(templatePath)) {
    console.error('❌ Template file not found:', templatePath);
    process.exit(1);
}

let html = fs.readFileSync(templatePath, 'utf-8');

// Tìm và thay thế các include tags: <!-- include:partials/header.html -->
const includeRegex = /<!--\s*include:\s*([^\s]+)\s*-->/g;
let match;
const includedFiles = [];

while ((match = includeRegex.exec(html)) !== null) {
    const partialPath = match[1];
    const fullPath = path.join(partialsDir, partialPath);

    if (fs.existsSync(fullPath)) {
        const partialContent = fs.readFileSync(fullPath, 'utf-8');
        html = html.replace(match[0], partialContent);
        includedFiles.push(partialPath);
        console.log(`✓ Included: ${partialPath}`);
    } else {
        console.warn(`⚠ Partial not found: ${partialPath}`);
    }
}

// Ghi file output
const outputPath = path.join(outputDir, 'index.html');
fs.writeFileSync(outputPath, html, 'utf-8');
console.log(`\n✅ Built ${outputPath} successfully!`);
console.log(`   Included ${includedFiles.length} partial(s)`);
