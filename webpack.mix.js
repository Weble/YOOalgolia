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
    .js('./plugin/assets/src/algolia.js', './plugin/assets/algolia.min.js')
    .js('./plugin/assets/src/autocomplete.js', './plugin/assets/autocomplete.min.js')
