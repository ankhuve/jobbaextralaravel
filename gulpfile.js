var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */
//
elixir(function(mix) {

    //mix.scriptsIn('resources/assets/js');

    mix.sass('app.scss')
        .browserify('search.js')
        .browserSync({
            proxy: 'jobbrek.app',
            port: 5002
        });

    mix.version(['css/app.css', 'js/search.js']);

});
