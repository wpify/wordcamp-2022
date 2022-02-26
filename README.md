# Ukázka pro WordCamp Prague 2022

## Example simple project structure

That example shows you how to structure your project, in this case a custom theme.

You can see a usage of the following:

* Namespaces.
* Dependency injection.
* Usage of composer.
* Scoping of composer dependencies.
* Usage of Comporer autoloader for custom classes.


## Example WordPress Scripts

In this example, you will learn how to use `@wordpress/scripts`, how to configure
that via webpack.config.js:

* Add glob-importer that allows you to import scss files with asterix.
* Add tailwindcss support
* Integrate with BrowserSync.
* Generates SVG Sprites for your svgs.

## Example CI/CD

In this example you can see various pipelines both for Gitlab a Github. It contains example of:

* Build process and deployment via SSH. (gitlab and github)
* Build process and deployment via FTP. (gitlab)
* Build process and deployment on WordPress.org. (gitlab)
* Build process and creating a zip file with plugin. (gitlab)

## Links

* [WPify Scoper](https://gitlab.com/wpify/scoper) - Scoping of Composer dependencies.
* [WPify Custom Fields](https://gitlab.com/wpify/custom-fields) - Custom fields for WordPress plugins.
* [Plugin Skeleton](https://gitlab.com/wpify/plugin-skeleton) - Starting template for WordPress plugins.
