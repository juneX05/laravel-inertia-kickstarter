const path = require('path');

module.exports = {
    resolve: {
        alias: {
            '@': path.resolve('application/Modules'),
        },
    },
    module: {
        rules: [
            {test: /\.php$/, loader: 'ignore-loader'},
            {test: /\.txt$/, loader: 'ignore-loader'},
        ]
    }
};
