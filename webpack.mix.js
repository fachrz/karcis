const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/pesawat_app.js', 'public/js')
   .js('resources/js/app.js', 'public/js')
   .js('resources/js/admin_app.js', 'public/js')
   .js('resources/js/kereta_app.js', 'public/js')
   .js('resources/js/countdown.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .sass('resources/sass/login.scss', 'public/css')
   .sass('resources/sass/register.scss', 'public/css')
   .sass('resources/sass/sb-admin.scss', 'public/css');
