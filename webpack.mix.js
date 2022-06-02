const mix = require('laravel-mix');

mix
  .setPublicPath('public')
  .js('./assets/app.js', 'build')
  .vue().js('./assets/js/admin.js', 'build')
  .sass('./assets/styles/app.scss', 'build')
  .sass('./assets/styles/admin.scss', 'build')
  .copy('./assets/images', 'public/build/images')
;
