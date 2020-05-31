const mix = require('laravel-mix');

const CompressionPlugin = require('compression-webpack-plugin');


if (mix.inProduction()) {
    mix.webpackConfig({
        plugins: [
            new CompressionPlugin({
                filename: '[path].br[query]',
                algorithm: 'brotliCompress',
                test: /\.(js|css|html|svg)$/,
                compressionOptions: {level: 11},
                minRatio: 1,
                deleteOriginalAssets: false,
            })
        ],
    });
}

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
    .sass('resources/mobile/assets/app.scss', 'public/css/mobile')
    // .sourceMaps()
    .options({
        processCssUrls: false
    })

if (mix.inProduction()) {
    mix.minify('public/js/app.js')
    mix.minify('public/css/app.css')
    mix.minify('public/css/mobile/app.css')
    mix.minify('public/js/active.js')
    mix.minify('public/js/plugins.js')
    mix.minify('public/js/vendor.js')
    mix.minify('public/js/vendor/modernizr-3.5.0.min.js')
}


