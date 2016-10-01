const elixir = require('laravel-elixir');

require('laravel-elixir-webpack-official');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {
    mix.sass('app.scss', null, null, { includePaths: [
        'node_modules/bootstrap/scss/'
    ]})
        .webpack('app.js');
        //.browserSync({ proxy: 'vente-morissette.app' });
});
