// npx mix
// npx mix --production
// npx mix watch

const mix = require('laravel-mix');

mix.setPublicPath('public');

mix.js('assets/js/app.js', 'js').react();
mix.js('assets/js/admin.js', 'js');
mix.sass('assets/scss/app.scss', 'css');
mix.sass('assets/scss/admin.scss', 'css');
mix.copy('assets/img', 'public/img');
