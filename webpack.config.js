const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const path = require('path');

module.exports = {
    ...defaultConfig,
    entry: {
        'sample-block': './themes/ai-test-child/blocks/sample-block/src/index.js',
    },
    output: {
        path: path.resolve(__dirname, 'themes/ai-test-child/blocks'),
        filename: '[name]/build/index.js',
    },
};
