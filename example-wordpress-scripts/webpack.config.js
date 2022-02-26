/**
 * Import dependencies for build process
 */

const fs = require('fs');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const SVGSpritemapPlugin = require('svg-spritemap-webpack-plugin');
const globImporter = require('node-sass-glob-importer');
const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const packageJson = require('./package.json');

/**
 * Exports the configuration for the build process. This is a webpack configuration that you can modify
 * Please see the documentation of webpack for more details about what all of those options means:
 * https://webpack.js.org/
 */

module.exports = {

  // By using three dots you can expand an object, in this case default webpack configuration
  // See more about spread syntax in documentation:
  // https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Spread_syntax
  ...defaultConfig,

  entry: {

    // The result files will be main.js and main.css in the build folder
    'main': [
      './assets/index.js', // those are source files in assets folder
      './assets/index.scss',
    ],
  },

  module: {

    // when overwriting the module in default config, we need to expand default module config as well.
    ...defaultConfig.module,
    rules: [

      // we need to go throw the module rules to modify the settings as we need
      ...defaultConfig.module.rules.map((rule) => {

        // If the rule is for scss files, we want to modify the configuration for that.
        if (rule.test.test('.scss')) {
          rule.use.forEach(use => {
            // if the loader is sass-loader, ...
            if (use.loader === require.resolve('sass-loader')) {
              use.options.sassOptions = {
                ...(use.options.sassOptions || null),
                // ... we want to use glob importer to have a possibility to load all scss files via asterix.
                // See assets/index.scss and documentation:
                // https://www.npmjs.com/package/node-sass-glob-importer
                importer: globImporter(),
              };
            }
          });

        // If the rule is for css file, and we have tailwind in devDependencies and we have tailwind.config.js in root of the project,
        // we want to also add tailwind plugins to postcss loader that are needed for tailwindcss.
        // See the documentation for more information:
        // https://tailwindcss.com/docs/installation/using-postcss
        } else if (rule.test.test('.css') && packageJson.devDependencies.tailwindcss && fs.existsSync('./tailwind.config.js')) {
          rule.test = /\.p?css$/;
          rule.use.forEach(use => {
            if (use.loader === require.resolve('postcss-loader')) {
              use.options.postcssOptions = {
                ...(use.options.postcssOptions || null),
                plugins: [
                  require('postcss-import'),
                  require('tailwindcss/nesting'),
                  require('tailwindcss'),
                  ...(use.options.postcssOptions.plugins || null),
                ],
              };
            }
          });
        }

        // return modified rule
        return rule;
      }),
    ],
  },

  // We want to add some cool plugins as well :)
  plugins: [

    // Expand the plugins from default configuration
    ...defaultConfig.plugins,

    // We want to use Browsersync.io that will be active when you run `npm run start`
    // See the documentation for more information:
    // https://www.npmjs.com/package/browser-sync-webpack-plugin
    new BrowserSyncPlugin({
      // Those are files we want to watch
      files: [
        'build/**/*.css',
        'build/**/*.js',
        'build/**/*.svg',
        'src/**/*.php',
        'templates/**/*.php',
      ],
      // if we have any certificates in .ssl folder, we use it to establish secure connection with browsersync.
      // That is helpful if you run https also on your localhost
      ...(fs.existsSync('./.ssl/master.key') && fs.existsSync('./.ssl/master.crt')
        ? {
          https: {
            key: './.ssl/certs/master.key',
            cert: './.ssl/certs/master.crt',
          }
        }
        : {}),
    }, {
      // Here are the plugin options that makes browsersync hot reload the styles, so the page is not reloaded
      // when the styles are changed, but injected instead.
      injectCss: true,
      reload: true,
    }),

    // Another cool plugin is SVGSpritemap. This takes the svgs from the folder and creates one SVG file with all the
    // svgs. You can then use it in your project. See the documentation for details:
    // https://github.com/cascornelissen/svg-spritemap-webpack-plugin
    // To use svgs, you need to insert build/sprites.svg file in the page.
    new SVGSpritemapPlugin('./assets/sprites/**/*.svg', {
      output: {
        filename: 'sprites.svg', // that makes the output path `build/sprites.svg`
        svg4everybody: true,
        svgo: true,
      },
      sprite: {
        generate: {
          title: true,
          symbol: true,
          use: true,
          view: '-fragment',
        },
      },
      styles: {
        filename: './assets/sprites.scss',
        format: 'fragment',
        // Here we want to generate some code, so we can use our svgs like that:
        // <svg class="sprite sprite--star"><use xlink:href="#sprite-star"></use></svg>
        // in your HTML. You can use that SVG multiple times and it's inlined, so you can style insides of the svg.
        callback: (content) => `${content}
@each $name, $size in $sizes {
  .sprite--#{$name} {
    width: map-get($size, width);
    height: map-get($size, height);
  }
}`,
      },
    }),
  ],
};
