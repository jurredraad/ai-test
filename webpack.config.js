const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const path = require('path');
const fs = require('fs');

// Automatically find all blocks in the child theme
const blockEntries = {};
const blocksPath = path.resolve(__dirname, 'themes/ai-test-child/blocks');

if (fs.existsSync(blocksPath)) {
    const blockDirs = fs.readdirSync(blocksPath, { withFileTypes: true })
        .filter(dirent => dirent.isDirectory())
        .map(dirent => dirent.name);

    blockDirs.forEach((blockName) => {
        const blockIndexPath = path.join(blocksPath, blockName, 'src', 'index.js');
        if (fs.existsSync(blockIndexPath)) {
            blockEntries[blockName] = blockIndexPath;
        }
    });
}

module.exports = {
    ...defaultConfig,
    entry: blockEntries,
    output: {
        path: path.resolve(__dirname, 'themes/ai-test-child/blocks'),
        filename: '[name]/build/index.js',
    },
};

