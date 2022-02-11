const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const globImporter = require('node-sass-glob-importer');
const defaultConfig = require('@wordpress/scripts/config/webpack.config');

module.exports = {
  ...defaultConfig,
  entry: {
    'app': [
      './src/index.js',
      './src/index.scss'
    ],
  },
  module: {
    ...defaultConfig.module,
    rules: [
      ...defaultConfig.module.rules.map((rule) => {
        if (rule.test.test('.scss')) {
          rule.use.forEach(use => {
            if (use.loader === require.resolve('sass-loader')) {
              use.options.sassOptions = {
                ...(use.options.sassOptions || null),
                importer: globImporter(),
              };
            }
          });
        }

        return rule;
      }),
    ],
  },
  plugins: [
    ...defaultConfig.plugins,
    new BrowserSyncPlugin({
      files: [
        'build/**/*.css',
        'build/**/*.js',
        '**/*.php',
      ],
    }, {
      injectCss: true,
      reload: true
    }),
  ].filter(Boolean),
};
