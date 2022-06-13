const mix = require('laravel-mix');

mix.setPublicPath('public')
  .js('./assets/app.js', 'build')
  .vue({
    extractStyles: true,
    globalStyles: false,
  })
  .js('./assets/js/admin.js', 'build')
  .sass('./assets/styles/app.scss', 'build')
  .sass('./assets/styles/admin.scss', 'build')
  .copy('./assets/images', 'public/build/images')
;

// mix.webpackConfig({
//   plugins: [
//     new webpack.ContextReplacementPlugin(/moment[\/\\]locale$/, /fr/),
//   ],
// });
