// npx mix
// npx mix --production
// npx mix watch

const mix = require('laravel-mix');

mix.setPublicPath('public')
  .js('assets/js/app.js', 'js')
  .react().js('assets/js/admin.js', 'js')
  .sass('assets/scss/app.scss', 'css')
  .sass('assets/scss/admin.scss', 'css')
  .copy('assets/img', 'public/img');
