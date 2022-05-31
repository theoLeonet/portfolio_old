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

mix.ts('wp-content/themes/portfolio/src/ts/Main.ts', 'js').sourceMaps()
    .sass('wp-content/themes/portfolio/src/scss/main.scss', 'css').sourceMaps()
    .options({
        processCssUrls: false
    })
    .setPublicPath('./wp-content/themes/portfolio/public')
    .browserSync({
        proxy: 'https://portfolio.test',
        notify: false,
        open: true,
    })
    .version();
