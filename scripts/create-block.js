#!/usr/bin/env node

const fs = require('fs');
const path = require('path');
const readline = require('readline');

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

function question(query) {
    return new Promise(resolve => rl.question(query, resolve));
}

function toPascalCase(str) {
    return str
        .split(/[-_\s]+/)
        .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
        .join('');
}

function toKebabCase(str) {
    return str
        .replace(/([a-z])([A-Z])/g, '$1-$2')
        .replace(/[\s_]+/g, '-')
        .toLowerCase();
}

async function createBlock() {
    console.log('\n🎨 Gutenberg Block Creator\n');

    const blockName = await question('Enter block name (e.g., "My Custom Block"): ');
    if (!blockName) {
        console.error('Block name is required!');
        rl.close();
        return;
    }

    const blockDescription = await question('Enter block description: ') || 'A custom Gutenberg block';
    const blockCategory = await question('Enter block category (common/formatting/layout/widgets/embed): ') || 'widgets';
    const blockIcon = await question('Enter block icon (dashicons name, e.g., "star-filled"): ') || 'block-default';

    rl.close();

    const kebabName = toKebabCase(blockName);
    const pascalName = toPascalCase(blockName);
    
    const blockDir = path.join(__dirname, '..', 'themes', 'ai-test-child', 'blocks', kebabName);
    const srcDir = path.join(blockDir, 'src');

    // Create directories
    if (fs.existsSync(blockDir)) {
        console.error(`\n❌ Block "${kebabName}" already exists!`);
        return;
    }

    fs.mkdirSync(srcDir, { recursive: true });

    // Create block.json
    const blockJson = {
        "$schema": "https://schemas.wp.org/trunk/block.json",
        "apiVersion": 3,
        "name": `ai-test/${kebabName}`,
        "version": "1.0.0",
        "title": blockName,
        "category": blockCategory,
        "icon": blockIcon,
        "description": blockDescription,
        "example": {},
        "supports": {
            "html": false,
            "align": true
        },
        "textdomain": "ai-test-child",
        "editorScript": "file:./build/index.js",
        "editorStyle": "file:./build/index.css",
        "style": "file:./build/style-index.css",
        "attributes": {
            "content": {
                "type": "string",
                "default": ""
            }
        }
    };

    fs.writeFileSync(
        path.join(blockDir, 'block.json'),
        JSON.stringify(blockJson, null, 2)
    );

    // Create index.js
    const indexJs = `import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, RichText } from '@wordpress/block-editor';
import './editor.scss';

registerBlockType('ai-test/${kebabName}', {
    edit: ({ attributes, setAttributes }) => {
        const blockProps = useBlockProps();

        return (
            <div {...blockProps}>
                <RichText
                    tagName="div"
                    value={attributes.content}
                    onChange={(content) => setAttributes({ content })}
                    placeholder="Enter your content..."
                />
            </div>
        );
    },
    save: ({ attributes }) => {
        const blockProps = useBlockProps.save();

        return (
            <div {...blockProps}>
                <RichText.Content tagName="div" value={attributes.content} />
            </div>
        );
    },
});
`;

    fs.writeFileSync(path.join(srcDir, 'index.js'), indexJs);

    // Create editor.scss
    const editorScss = `.wp-block-ai-test-${kebabName} {
    padding: 20px;
    border: 1px dashed #ccc;
    background-color: #f9f9f9;

    &:hover {
        border-color: #007cba;
    }
}
`;

    fs.writeFileSync(path.join(srcDir, 'editor.scss'), editorScss);

    // Create style.scss
    const styleScss = `.wp-block-ai-test-${kebabName} {
    padding: 20px;
}
`;

    fs.writeFileSync(path.join(srcDir, 'style.scss'), styleScss);

    console.log(`\n✅ Block "${blockName}" created successfully!`);
    console.log(`\n📁 Location: themes/ai-test-child/blocks/${kebabName}`);
    console.log(`\n📝 Next steps:`);
    console.log(`   1. Update webpack.config.js to include the new block`);
    console.log(`   2. Run "npm run build" to compile the block`);
    console.log(`   3. Activate the theme in WordPress`);
    console.log(`   4. The block will be available in the block inserter\n`);
}

createBlock().catch(console.error);
