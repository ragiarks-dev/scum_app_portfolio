const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

// mix.js('resources/js/app.js', 'public/js')
//     .postCss('resources/css/app.css', 'public/css', [
//         //
//     ]);

mix.js('resources/vue-material-dashboard-2/src/main.js', 'public/js')
    .js('resources/vue-material-dashboard-2/src/material-dashboard.js', 'public/js')
    .css('resources/css/app.css', 'public/css')
    .css('resources/vue-material-dashboard-2/src/assets/css/nucleo-icons.css', 'public/css')
    .css('resources/vue-material-dashboard-2/src/assets/css/nucleo-svg.css', 'public/css')
    .sass('resources/vue-material-dashboard-2/src/assets/scss/material-dashboard.scss', 'public/css')
    .vue();
