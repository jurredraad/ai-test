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

// AI-inspired block templates based on common patterns
const blockTemplates = {
    'call-to-action': {
        description: 'A call-to-action block with button',
        category: 'common',
        icon: 'megaphone',
        attributes: {
            title: { type: 'string', default: 'Take Action Now!' },
            description: { type: 'string', default: 'Join us today and make a difference.' },
            buttonText: { type: 'string', default: 'Get Started' },
            buttonUrl: { type: 'string', default: '#' }
        },
        editTemplate: `import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, RichText, URLInput } from '@wordpress/block-editor';
import { TextControl } from '@wordpress/components';
import './editor.scss';

registerBlockType('ai-test/{{kebabName}}', {
    edit: ({ attributes, setAttributes }) => {
        const blockProps = useBlockProps();

        return (
            <div {...blockProps}>
                <RichText
                    tagName="h2"
                    value={attributes.title}
                    onChange={(title) => setAttributes({ title })}
                    placeholder="Enter title..."
                />
                <RichText
                    tagName="p"
                    value={attributes.description}
                    onChange={(description) => setAttributes({ description })}
                    placeholder="Enter description..."
                />
                <div className="cta-button-wrapper">
                    <TextControl
                        label="Button Text"
                        value={attributes.buttonText}
                        onChange={(buttonText) => setAttributes({ buttonText })}
                    />
                    <TextControl
                        label="Button URL"
                        value={attributes.buttonUrl}
                        onChange={(buttonUrl) => setAttributes({ buttonUrl })}
                    />
                </div>
            </div>
        );
    },
    save: ({ attributes }) => {
        const blockProps = useBlockProps.save();

        return (
            <div {...blockProps}>
                <RichText.Content tagName="h2" value={attributes.title} />
                <RichText.Content tagName="p" value={attributes.description} />
                <a href={attributes.buttonUrl} className="cta-button">
                    {attributes.buttonText}
                </a>
            </div>
        );
    },
});`,
        editorStyle: `.wp-block-ai-test-{{kebabName}} {
    padding: 30px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 8px;
    text-align: center;

    h2 {
        color: white;
        margin-bottom: 10px;
    }

    p {
        margin-bottom: 20px;
    }

    .cta-button-wrapper {
        margin-top: 20px;
        padding: 15px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 4px;
    }
}`,
        frontendStyle: `.wp-block-ai-test-{{kebabName}} {
    padding: 40px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 8px;
    text-align: center;
}

.wp-block-ai-test-{{kebabName}} h2 {
    color: white;
    margin-bottom: 15px;
    font-size: 2em;
}

.wp-block-ai-test-{{kebabName}} p {
    margin-bottom: 25px;
    font-size: 1.1em;
}

.wp-block-ai-test-{{kebabName}} .cta-button {
    display: inline-block;
    padding: 12px 30px;
    background: white;
    color: #667eea;
    text-decoration: none;
    border-radius: 25px;
    font-weight: bold;
    transition: transform 0.2s;
}

.wp-block-ai-test-{{kebabName}} .cta-button:hover {
    transform: scale(1.05);
}`
    },
    'testimonial': {
        description: 'A testimonial block with quote and author',
        category: 'widgets',
        icon: 'format-quote',
        attributes: {
            quote: { type: 'string', default: 'This product changed my life!' },
            author: { type: 'string', default: 'John Doe' },
            role: { type: 'string', default: 'CEO, Company' }
        },
        editTemplate: `import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, RichText } from '@wordpress/block-editor';
import './editor.scss';

registerBlockType('ai-test/{{kebabName}}', {
    edit: ({ attributes, setAttributes }) => {
        const blockProps = useBlockProps();

        return (
            <div {...blockProps}>
                <div className="quote-mark">"</div>
                <RichText
                    tagName="blockquote"
                    value={attributes.quote}
                    onChange={(quote) => setAttributes({ quote })}
                    placeholder="Enter testimonial quote..."
                />
                <RichText
                    tagName="cite"
                    className="author"
                    value={attributes.author}
                    onChange={(author) => setAttributes({ author })}
                    placeholder="Author name..."
                />
                <RichText
                    tagName="p"
                    className="role"
                    value={attributes.role}
                    onChange={(role) => setAttributes({ role })}
                    placeholder="Role/Company..."
                />
            </div>
        );
    },
    save: ({ attributes }) => {
        const blockProps = useBlockProps.save();

        return (
            <div {...blockProps}>
                <div className="quote-mark">"</div>
                <RichText.Content tagName="blockquote" value={attributes.quote} />
                <RichText.Content tagName="cite" className="author" value={attributes.author} />
                <RichText.Content tagName="p" className="role" value={attributes.role} />
            </div>
        );
    },
});`,
        editorStyle: `.wp-block-ai-test-{{kebabName}} {
    padding: 30px;
    background: #f8f9fa;
    border-left: 5px solid #007cba;
    position: relative;

    .quote-mark {
        font-size: 80px;
        color: #007cba;
        opacity: 0.3;
        position: absolute;
        top: -10px;
        left: 10px;
    }

    blockquote {
        font-style: italic;
        font-size: 1.2em;
        margin: 0 0 20px 0;
    }

    .author {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }

    .role {
        color: #666;
        font-size: 0.9em;
    }
}`,
        frontendStyle: `.wp-block-ai-test-{{kebabName}} {
    padding: 30px;
    background: #f8f9fa;
    border-left: 5px solid #007cba;
    position: relative;
    margin: 20px 0;
}

.wp-block-ai-test-{{kebabName}} .quote-mark {
    font-size: 80px;
    color: #007cba;
    opacity: 0.3;
    position: absolute;
    top: -10px;
    left: 10px;
    font-family: Georgia, serif;
}

.wp-block-ai-test-{{kebabName}} blockquote {
    font-style: italic;
    font-size: 1.2em;
    margin: 0 0 20px 0;
    position: relative;
    z-index: 1;
}

.wp-block-ai-test-{{kebabName}} .author {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
    font-style: normal;
}

.wp-block-ai-test-{{kebabName}} .role {
    color: #666;
    font-size: 0.9em;
}`
    },
    'feature-box': {
        description: 'A feature box with icon, title, and description',
        category: 'widgets',
        icon: 'star-filled',
        attributes: {
            icon: { type: 'string', default: '⭐' },
            title: { type: 'string', default: 'Amazing Feature' },
            description: { type: 'string', default: 'This feature will help you achieve your goals.' }
        },
        editTemplate: `import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, RichText } from '@wordpress/block-editor';
import { TextControl } from '@wordpress/components';
import './editor.scss';

registerBlockType('ai-test/{{kebabName}}', {
    edit: ({ attributes, setAttributes }) => {
        const blockProps = useBlockProps();

        return (
            <div {...blockProps}>
                <TextControl
                    label="Icon (emoji or text)"
                    value={attributes.icon}
                    onChange={(icon) => setAttributes({ icon })}
                />
                <RichText
                    tagName="h3"
                    value={attributes.title}
                    onChange={(title) => setAttributes({ title })}
                    placeholder="Feature title..."
                />
                <RichText
                    tagName="p"
                    value={attributes.description}
                    onChange={(description) => setAttributes({ description })}
                    placeholder="Feature description..."
                />
            </div>
        );
    },
    save: ({ attributes }) => {
        const blockProps = useBlockProps.save();

        return (
            <div {...blockProps}>
                <div className="feature-icon">{attributes.icon}</div>
                <RichText.Content tagName="h3" value={attributes.title} />
                <RichText.Content tagName="p" value={attributes.description} />
            </div>
        );
    },
});`,
        editorStyle: `.wp-block-ai-test-{{kebabName}} {
    padding: 25px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    text-align: center;

    .feature-icon {
        font-size: 3em;
        margin-bottom: 15px;
    }

    h3 {
        margin-bottom: 10px;
        color: #333;
    }

    p {
        color: #666;
        line-height: 1.6;
    }
}`,
        frontendStyle: `.wp-block-ai-test-{{kebabName}} {
    padding: 30px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    text-align: center;
    transition: all 0.3s ease;
    background: white;
}

.wp-block-ai-test-{{kebabName}}:hover {
    border-color: #007cba;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transform: translateY(-5px);
}

.wp-block-ai-test-{{kebabName}} .feature-icon {
    font-size: 3em;
    margin-bottom: 15px;
}

.wp-block-ai-test-{{kebabName}} h3 {
    margin-bottom: 15px;
    color: #333;
    font-size: 1.5em;
}

.wp-block-ai-test-{{kebabName}} p {
    color: #666;
    line-height: 1.6;
    margin: 0;
}`
    }
};

async function createAIBlock() {
    console.log('\n🤖 AI-Assisted Block Creator\n');
    console.log('Choose a block template:\n');
    
    const templates = Object.keys(blockTemplates);
    templates.forEach((template, index) => {
        console.log(`${index + 1}. ${template} - ${blockTemplates[template].description}`);
    });
    console.log(`${templates.length + 1}. Custom block (basic template)\n`);

    const choice = await question(`Select option (1-${templates.length + 1}): `);
    const choiceNum = parseInt(choice);

    let templateKey = null;
    let blockName = '';
    
    if (choiceNum > 0 && choiceNum <= templates.length) {
        templateKey = templates[choiceNum - 1];
        blockName = await question(`Enter block name (default: "${templateKey}"): `) || templateKey;
    } else {
        blockName = await question('Enter block name: ');
        if (!blockName) {
            console.error('Block name is required!');
            rl.close();
            return;
        }
    }

    rl.close();

    const kebabName = toKebabCase(blockName);
    const blockDir = path.join(__dirname, '..', 'themes', 'ai-test-child', 'blocks', kebabName);
    const srcDir = path.join(blockDir, 'src');

    // Create directories
    if (fs.existsSync(blockDir)) {
        console.error(`\n❌ Block "${kebabName}" already exists!`);
        return;
    }

    fs.mkdirSync(srcDir, { recursive: true });

    if (templateKey && blockTemplates[templateKey]) {
        const template = blockTemplates[templateKey];
        
        // Create block.json
        const blockJson = {
            "$schema": "https://schemas.wp.org/trunk/block.json",
            "apiVersion": 3,
            "name": `ai-test/${kebabName}`,
            "version": "1.0.0",
            "title": blockName,
            "category": template.category,
            "icon": template.icon,
            "description": template.description,
            "example": {},
            "supports": {
                "html": false,
                "align": true
            },
            "textdomain": "ai-test-child",
            "editorScript": "file:./build/index.js",
            "editorStyle": "file:./build/index.css",
            "style": "file:./build/style-index.css",
            "attributes": template.attributes
        };

        fs.writeFileSync(
            path.join(blockDir, 'block.json'),
            JSON.stringify(blockJson, null, 2)
        );

        // Create index.js
        const indexJs = template.editTemplate.replace(/{{kebabName}}/g, kebabName);
        fs.writeFileSync(path.join(srcDir, 'index.js'), indexJs);

        // Create editor.scss
        const editorScss = template.editorStyle.replace(/{{kebabName}}/g, kebabName);
        fs.writeFileSync(path.join(srcDir, 'editor.scss'), editorScss);

        // Create style.scss
        const styleScss = template.frontendStyle.replace(/{{kebabName}}/g, kebabName);
        fs.writeFileSync(path.join(srcDir, 'style.scss'), styleScss);

        console.log(`\n✅ AI-generated block "${blockName}" created successfully!`);
        console.log(`\n📦 Template used: ${templateKey}`);
    } else {
        // Create basic custom block
        const blockJson = {
            "$schema": "https://schemas.wp.org/trunk/block.json",
            "apiVersion": 3,
            "name": `ai-test/${kebabName}`,
            "version": "1.0.0",
            "title": blockName,
            "category": "widgets",
            "icon": "block-default",
            "description": "A custom Gutenberg block",
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

        const editorScss = `.wp-block-ai-test-${kebabName} {
    padding: 20px;
    border: 1px dashed #ccc;
    background-color: #f9f9f9;
}
`;

        fs.writeFileSync(path.join(srcDir, 'editor.scss'), editorScss);

        const styleScss = `.wp-block-ai-test-${kebabName} {
    padding: 20px;
}
`;

        fs.writeFileSync(path.join(srcDir, 'style.scss'), styleScss);

        console.log(`\n✅ Custom block "${blockName}" created successfully!`);
    }

    console.log(`\n📁 Location: themes/ai-test-child/blocks/${kebabName}`);
    console.log(`\n📝 Next steps:`);
    console.log(`   1. Update webpack.config.js to include the new block`);
    console.log(`   2. Run "npm run build" to compile the block`);
    console.log(`   3. Activate the theme in WordPress`);
    console.log(`   4. The block will be available in the block inserter\n`);
}

createAIBlock().catch(console.error);
