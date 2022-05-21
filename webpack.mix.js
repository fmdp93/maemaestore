const mix = require("laravel-mix");

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

mix.autoload({
    jquery: ["$", "window.jQuery", "jQuery"],
})
    .webpackConfig({
        stats: "normal",
    })
    // .copy('resources/js/', 'public/js/')
    .js("resources/js/app.js", "public/js")
    .copy("resources/js/function.js", "public/js/function.js")
    .copy("resources/js/scope/", "public/js/scope/")
    .copy("resources/js/class/", "public/js/class/")
    .copy("resources/js/lib/", "public/js/lib/")
    .copy("resources/js/decorator/", "public/js/decorator/")
    // node_modules
    .copy(
        "node_modules/bootstrap/dist/js/bootstrap.bundle.min.js",
        "public/js/bootstrap.bundle.min.js"
    )
    .copy("node_modules/jquery/dist/jquery.min.js", "public/js/jquery.min.js")
    .copy("node_modules/html5-qrcode/", "public/js/html5-qrcode/")
    .copy("node_modules/hotkeys-js/", "public/js/hotkeys-js/")
    .copy("resources/img/", "public/img/")
    .sass("resources/scss/app.scss", "public/css")
    .browserSync("http://127.0.0.1:8000");

if (mix.inProduction()) {
    mix.version();
}
