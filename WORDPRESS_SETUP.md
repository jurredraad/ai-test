# WordPress Theme with Gutenberg Blocks

This repository contains a blank WordPress parent theme and child theme with Gutenberg block support and AI-assisted block creation tools.

## 🎯 Features

- **Parent Theme (ai-test-parent)**: A minimal, clean WordPress theme
- **Child Theme (ai-test-child)**: Extends the parent theme with custom blocks
- **Gutenberg Block Support**: Full support for creating custom blocks
- **AI-Assisted Block Creator**: Terminal-based tool to generate blocks from templates
- **Build System**: Webpack-based build system using @wordpress/scripts

## 📦 Installation

### Prerequisites

- Node.js (v14 or higher)
- npm or yarn
- WordPress installation (6.0 or higher)

### Setup

1. Clone this repository into your WordPress themes directory or development environment:

```bash
git clone https://github.com/jurredraad/ai-test.git
cd ai-test
```

2. Install dependencies:

```bash
npm install
```

3. Build the blocks:

```bash
npm run build
```

4. Copy the theme folders to your WordPress installation:

```bash
cp -r themes/ai-test-parent /path/to/wordpress/wp-content/themes/
cp -r themes/ai-test-child /path/to/wordpress/wp-content/themes/
```

5. Activate the child theme in WordPress Admin:
   - Go to Appearance → Themes
   - Activate "AI Test Child"

## 🛠️ Creating Blocks

### Method 1: Basic Block Creator

Create a simple custom block using the interactive CLI:

```bash
npm run create-block
```

This will prompt you for:
- Block name
- Block description
- Block category
- Block icon

### Method 2: AI-Assisted Block Creator

Create blocks from pre-built templates:

```bash
npm run ai-block
```

Choose from templates:
1. **Call to Action** - Button with title and description
2. **Testimonial** - Quote with author attribution
3. **Feature Box** - Icon, title, and description
4. **Custom** - Basic blank template

Each template includes:
- Pre-configured attributes
- Styled components
- Hover effects and animations
- Responsive design

## 📁 Project Structure

```
ai-test/
├── themes/
│   ├── ai-test-parent/          # Parent theme
│   │   ├── style.css            # Theme stylesheet with metadata
│   │   ├── functions.php        # Theme functions
│   │   ├── header.php           # Header template
│   │   ├── footer.php           # Footer template
│   │   └── index.php            # Main template
│   │
│   └── ai-test-child/           # Child theme
│       ├── style.css            # Child theme stylesheet
│       ├── functions.php        # Child theme functions
│       └── blocks/              # Custom blocks directory
│           └── sample-block/    # Example block
│               ├── block.json   # Block metadata
│               ├── src/         # Source files
│               │   ├── index.js
│               │   ├── editor.scss
│               │   └── style.scss
│               └── build/       # Compiled files (generated)
│
├── scripts/
│   ├── create-block.js          # Basic block generator
│   └── ai-block-creator.js      # AI-assisted block generator
│
├── package.json                 # Node dependencies
├── webpack.config.js            # Webpack configuration
└── README.md                    # This file
```

## 🔨 Development Workflow

### 1. Create a New Block

Use one of the creation methods above to generate a new block.

### 2. Update Webpack Configuration

After creating a block, update `webpack.config.js`:

```javascript
entry: {
    'sample-block': './themes/ai-test-child/blocks/sample-block/src/index.js',
    'your-new-block': './themes/ai-test-child/blocks/your-new-block/src/index.js',
},
```

### 3. Build the Blocks

For development with auto-rebuild:

```bash
npm start
```

For production build:

```bash
npm run build
```

### 4. Test in WordPress

1. Go to WordPress admin
2. Create or edit a page/post
3. Click the "+" button in the editor
4. Search for your block name
5. Add it to the page

## 🎨 Customizing Blocks

### Block Structure

Each block consists of:

1. **block.json** - Block metadata and configuration
2. **src/index.js** - Block logic (edit and save functions)
3. **src/editor.scss** - Styles for the editor
4. **src/style.scss** - Styles for the frontend

### Example: Editing a Block

Edit `themes/ai-test-child/blocks/sample-block/src/index.js`:

```javascript
import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, RichText } from '@wordpress/block-editor';

registerBlockType('ai-test/sample-block', {
    edit: ({ attributes, setAttributes }) => {
        const blockProps = useBlockProps();
        
        return (
            <div {...blockProps}>
                <RichText
                    tagName="p"
                    value={attributes.message}
                    onChange={(message) => setAttributes({ message })}
                    placeholder="Enter your message..."
                />
            </div>
        );
    },
    save: ({ attributes }) => {
        const blockProps = useBlockProps.save();
        
        return (
            <div {...blockProps}>
                <RichText.Content tagName="p" value={attributes.message} />
            </div>
        );
    },
});
```

## 🤖 AI Block Templates

The AI-assisted creator includes these templates:

### Call to Action Block
- Gradient background
- Editable title, description, and button
- Customizable button URL
- Hover animations

### Testimonial Block
- Quote styling with quotation marks
- Author and role fields
- Clean, professional design

### Feature Box Block
- Icon/emoji support
- Hover effects
- Perfect for feature grids

## 📚 Additional Resources

- [WordPress Block Editor Handbook](https://developer.wordpress.org/block-editor/)
- [@wordpress/scripts Documentation](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-scripts/)
- [Block API Reference](https://developer.wordpress.org/block-editor/reference-guides/block-api/)

## 🔧 Troubleshooting

### Blocks not appearing in editor

1. Make sure the theme is activated
2. Run `npm run build` to compile blocks
3. Clear WordPress cache
4. Check browser console for JavaScript errors

### Build errors

1. Delete `node_modules` and reinstall: `npm install`
2. Check Node.js version (should be 14+)
3. Verify webpack.config.js includes all blocks

### Styling issues

1. Clear browser cache
2. Rebuild blocks: `npm run build`
3. Check that both editor.scss and style.scss are present

## 📝 License

This project is licensed under the GPL-2.0-or-later license.

## 🤝 Contributing

Feel free to submit issues and enhancement requests!
