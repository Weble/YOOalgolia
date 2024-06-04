let mix = require('laravel-mix');
let path = require('path');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

mix
    .setPublicPath(path.resolve('./'))
    .js('./assets/src/algolia.js', './assets/algolia.min.js')
    .vue({version: 2})
