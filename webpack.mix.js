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


mix.copyDirectory('resources/assets/fonts', 'public/fonts');
mix.copyDirectory('resources/assets/js', 'public/js');
mix.copyDirectory('resources/assets/images', 'public/images');


/*mix.webpackConfig({
    devtool: 'inline-source-map'
})*/


mix.js('resources/js/app.js', 'public/js')
    //.extract(['vue'])
    .sass('resources/sass/app.scss', 'public/css')
    //.sourceMaps()
    .options({
        processCssUrls: false
    });




