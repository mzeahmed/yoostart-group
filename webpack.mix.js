// npx mix
// npx mix --production

const mix = require('laravel-mix');

mix.setPublicPath('public');

mix.js('assets/js/app.js', 'js');
mix.sass('assets/scss/app.scss', 'css');