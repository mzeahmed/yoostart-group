// npx mix
// npx mix --production
// npx mix watch

const mix = require('laravel-mix');

mix
  .setPublicPath('public')
  .js('./assets/js/app.js', 'build').react()
  .js('./assets/js/admin.js', 'build')
  .sass('./assets/styles/app.scss', 'build')
  .sass('./assets/styles/admin.scss', 'build')
  .copy('./assets/images', 'public/build/images')
;
