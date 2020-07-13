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

mix.setPublicPath('public_html/');

mix.js("resources/js/app.js", "js")
    .sass("resources/sass/app.scss", "public_html/css")

    //Admin
    .scripts(
        [
            "node_modules/jquery/dist/jquery.min.js",
            "resources/admin/plugins/jquery-ui/jquery-ui.min.js",
            "resources/admin/plugins/jquery-ui-paginatedautocomplete.js",
            "node_modules/sweetalert2/dist/sweetalert2.all.min.js",
        ],
        "public_html/static/admin/assets/js/vendor.js"
    )
    .scripts("resources/admin/assets/js/functions.js", "public_html/static/admin/assets/js/functions.js")
    .copy("resources/admin/plugins", "public_html/static/admin/plugins")
    //.copy("node_modules/font-awesome/fonts", "public_html/static/admin/fonts")
    .sass("resources/admin/assets/scss/adminlte.scss", "public_html/static/admin/assets/css")
