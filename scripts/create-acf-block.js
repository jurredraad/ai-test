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

function toSnakeCase(str) {
    return str
        .replace(/([a-z])([A-Z])/g, '$1_$2')
        .replace(/[\s-]+/g, '_')
        .toLowerCase();
}

async function createACFBlock() {
    console.log('\n🎨 ACF Block Creator\n');

    const blockName = await question('Enter block name (e.g., "Content Section"): ');
    if (!blockName) {
        console.error('Block name is required!');
        rl.close();
        return;
    }

    const blockDescription = await question('Enter block description: ') || 'A custom ACF block';
    const blockCategory = await question('Enter block category (common/formatting/layout/widgets/embed): ') || 'layout';
    const blockIcon = await question('Enter block icon (dashicons name, e.g., "admin-page"): ') || 'admin-page';

    rl.close();

    const kebabName = toKebabCase(blockName);
    const snakeName = toSnakeCase(blockName);
    const pascalName = toPascalCase(blockName);
    
    const blockDir = path.join(__dirname, '..', 'themes', 'ai-test-child', 'blocks', kebabName);

    // Create directories
    if (fs.existsSync(blockDir)) {
        console.error(`\n❌ Block "${kebabName}" already exists!`);
        return;
    }

    fs.mkdirSync(blockDir, { recursive: true });

    // Create block.php
    const blockPhp = `<?php
/**
 * ${blockName} Block
 *
 * @package AI_Test_Child
 */

if ( ! function_exists( 'acf_register_block_type' ) ) {
    return;
}

acf_register_block_type( array(
    'name'              => '${kebabName}',
    'title'             => __( '${blockName}', 'ai-test-child' ),
    'description'       => __( '${blockDescription}', 'ai-test-child' ),
    'render_template'   => get_stylesheet_directory() . '/blocks/${kebabName}/template.php',
    'category'          => '${blockCategory}',
    'icon'              => '${blockIcon}',
    'keywords'          => array( '${kebabName}' ),
    'supports'          => array(
        'align'         => array( 'wide', 'full' ),
        'anchor'        => true,
        'mode'          => true,
        'jsx'           => true,
    ),
    'enqueue_assets'    => function() {
        wp_enqueue_style( 
            'block-${kebabName}', 
            get_stylesheet_directory_uri() . '/blocks/${kebabName}/style.css',
            array(),
            filemtime( get_stylesheet_directory() . '/blocks/${kebabName}/style.css' )
        );
    },
) );
`;

    fs.writeFileSync(path.join(blockDir, 'block.php'), blockPhp);

    // Create template.php
    const templatePhp = `<?php
/**
 * ${blockName} Block Template
 *
 * @package AI_Test_Child
 */

// Create id attribute allowing for custom "anchor" value.
$id = '${kebabName}-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = '${kebabName}-block';
if ( ! empty( $block['className'] ) ) {
    $className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $className .= ' align' . $block['align'];
}

// Load values and handle defaults.
$title = get_field( 'title' ) ?: 'Add your title';
$content = get_field( 'content' ) ?: 'Add your content here';

?>
<section id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $className ); ?>">
    <div class="container">
        <div class="block-content">
            <h2><?php echo esc_html( $title ); ?></h2>
            <div class="content">
                <?php echo wp_kses_post( $content ); ?>
            </div>
        </div>
    </div>
</section>
`;

    fs.writeFileSync(path.join(blockDir, 'template.php'), templatePhp);

    // Create style.css
    const styleCss = `.${kebabName}-block {
    padding: 60px 0;
}

.${kebabName}-block .block-content {
    max-width: 800px;
    margin: 0 auto;
}

.${kebabName}-block h2 {
    font-size: 2.5rem;
    margin-bottom: 20px;
    line-height: 1.2;
}

.${kebabName}-block .content {
    font-size: 1.1rem;
    line-height: 1.6;
}

/* Responsive */
@media (max-width: 768px) {
    .${kebabName}-block {
        padding: 40px 0;
    }

    .${kebabName}-block h2 {
        font-size: 2rem;
    }

    .${kebabName}-block .content {
        font-size: 1rem;
    }
}
`;

    fs.writeFileSync(path.join(blockDir, 'style.css'), styleCss);

    // Create ACF JSON field group
    const acfJson = {
        "key": `group_${snakeName}_block`,
        "title": `${blockName} Block Fields`,
        "fields": [
            {
                "key": `field_${snakeName}_title`,
                "label": "Title",
                "name": "title",
                "type": "text",
                "instructions": "Enter the block title",
                "required": 0,
                "default_value": "Add your title"
            },
            {
                "key": `field_${snakeName}_content`,
                "label": "Content",
                "name": "content",
                "type": "wysiwyg",
                "instructions": "Add your content",
                "required": 0,
                "tabs": "all",
                "toolbar": "full",
                "media_upload": 1
            }
        ],
        "location": [
            [
                {
                    "param": "block",
                    "operator": "==",
                    "value": `acf/${kebabName}`
                }
            ]
        ]
    };

    // Ensure acf-json directory exists
    const acfJsonDir = path.join(__dirname, '..', 'themes', 'ai-test-child', 'acf-json');
    if (!fs.existsSync(acfJsonDir)) {
        fs.mkdirSync(acfJsonDir, { recursive: true });
    }

    fs.writeFileSync(
        path.join(acfJsonDir, `group_${snakeName}_block.json`),
        JSON.stringify(acfJson, null, 4)
    );

    console.log(`\n✅ ACF Block "${blockName}" created successfully!`);
    console.log(`\n📁 Location: themes/ai-test-child/blocks/${kebabName}`);
    console.log(`\n📝 Files created:`);
    console.log(`   - block.php (Block registration)`);
    console.log(`   - template.php (Block template)`);
    console.log(`   - style.css (Block styles)`);
    console.log(`   - acf-json/group_${snakeName}_block.json (ACF fields)`);
    console.log(`\n💡 Next steps:`);
    console.log(`   1. Ensure ACF Pro plugin is installed and activated`);
    console.log(`   2. The block will be automatically registered`);
    console.log(`   3. Customize the template.php and style.css as needed`);
    console.log(`   4. The ACF fields will be auto-loaded from JSON`);
    console.log(`   5. Use the block in the WordPress editor!\n`);
}

createACFBlock().catch(console.error);
