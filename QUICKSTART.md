# Quick Start Guide

## Getting Started in 3 Steps

### 1. Install Dependencies

```bash
npm install
```

This will install all required packages including:
- @wordpress/scripts (build tools)
- inquirer (interactive CLI)
- chalk (colored terminal output)

### 2. Build the Sample Block

```bash
npm run build
```

This compiles the sample block and makes it ready for use in WordPress.

### 3. Create Your First Custom Block

**Option A: Simple Block Creator**
```bash
npm run create-block
```

**Option B: AI-Assisted with Templates**
```bash
npm run ai-block
```

## What You Get

### Parent Theme (ai-test-parent)
A minimal WordPress theme with:
- Clean, modern design
- Gutenberg block support
- Responsive layout
- Automatic block registration

### Child Theme (ai-test-child)
Extends the parent theme with:
- Custom block support
- Easy customization
- Sample block included
- Independent updates from parent

### Block Development Tools

#### 1. Basic Block Creator (`npm run create-block`)
Interactive CLI that asks you:
- Block name
- Description
- Category (common, formatting, layout, widgets, embed)
- Icon (dashicons name)

Creates a basic block with:
- RichText editing
- Basic styling
- Editor and frontend styles

#### 2. AI Block Creator (`npm run ai-block`)
Choose from pre-built templates:

**Call to Action Block**
- Beautiful gradient background
- Title, description, button
- Customizable button URL
- Hover animations

**Testimonial Block**
- Professional quote styling
- Author attribution
- Role/company field
- Quotation mark design element

**Feature Box Block**
- Icon/emoji support
- Clean card design
- Hover effects
- Perfect for showcasing features

**Custom Block**
- Basic template
- Fully customizable starting point

## Development Workflow

### Create a Block

```bash
npm run ai-block
# Choose template, enter name, done!
```

### Update Webpack Config

Add your new block to `webpack.config.js`:

```javascript
entry: {
    'sample-block': './themes/ai-test-child/blocks/sample-block/src/index.js',
    'my-new-block': './themes/ai-test-child/blocks/my-new-block/src/index.js',
},
```

### Build and Test

Development mode (auto-rebuild):
```bash
npm start
```

Production build:
```bash
npm run build
```

## Installing in WordPress

### Option 1: Copy Themes

```bash
# Copy to your WordPress installation
cp -r themes/ai-test-parent /path/to/wordpress/wp-content/themes/
cp -r themes/ai-test-child /path/to/wordpress/wp-content/themes/
```

Then activate "AI Test Child" theme in WordPress Admin.

### Option 2: Symlink for Development

```bash
# Create symlinks for easier development
ln -s $(pwd)/themes/ai-test-parent /path/to/wordpress/wp-content/themes/ai-test-parent
ln -s $(pwd)/themes/ai-test-child /path/to/wordpress/wp-content/themes/ai-test-child
```

This way, changes are immediately reflected in WordPress.

## Using Blocks in WordPress

1. Log in to WordPress Admin
2. Go to Pages or Posts
3. Click "Add New" or edit an existing page
4. Click the "+" (Add block) button
5. Search for your block name (e.g., "Sample Block")
6. Click to add it to the page
7. Edit the content
8. Publish!

## File Structure

```
your-block/
├── block.json          # Block configuration
├── src/
│   ├── index.js       # Block logic
│   ├── editor.scss    # Editor styles
│   └── style.scss     # Frontend styles
└── build/             # Compiled files (auto-generated)
    ├── index.js
    ├── index.css
    └── style-index.css
```

## Customization Tips

### Changing Block Styles

Edit `src/style.scss` for frontend styles:
```scss
.wp-block-ai-test-your-block {
    padding: 20px;
    background: #f0f0f0;
    border-radius: 8px;
}
```

### Adding Attributes

Edit `block.json`:
```json
"attributes": {
    "title": {
        "type": "string",
        "default": "Default Title"
    },
    "color": {
        "type": "string",
        "default": "#000000"
    }
}
```

### Using Attributes in Block

Edit `src/index.js`:
```javascript
edit: ({ attributes, setAttributes }) => {
    return (
        <div>
            <RichText
                value={attributes.title}
                onChange={(title) => setAttributes({ title })}
            />
        </div>
    );
}
```

## Next Steps

1. ✅ Install dependencies: `npm install`
2. ✅ Build sample block: `npm run build`
3. ✅ Create your first block: `npm run ai-block`
4. ✅ Update webpack config
5. ✅ Build your block: `npm run build`
6. ✅ Copy themes to WordPress
7. ✅ Activate child theme
8. ✅ Start creating!

## Need Help?

- See [WORDPRESS_SETUP.md](WORDPRESS_SETUP.md) for detailed documentation
- Check [WordPress Block Editor Handbook](https://developer.wordpress.org/block-editor/)
- View sample block code in `themes/ai-test-child/blocks/sample-block/`

Happy block building! 🚀
