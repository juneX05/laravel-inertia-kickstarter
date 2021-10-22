const path = require('path');

module.exports = {
    resolve: {
        alias: {
            '@': path.resolve('modules'),
        },
    },
    module: {
        rules: [
            { test: /\.php$/, loader: 'ignore-loader' }
        ]
    }
};
