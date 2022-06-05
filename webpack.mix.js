const mix = require('laravel-mix');

mix.setPublicPath('public');
mix
  .js('./assets/app.js', 'build')
  .vue({
    extractStyles: true,
    globalStyles: false,
  });
mix.js('./assets/js/admin.js', 'build');
mix.sass('./assets/styles/app.scss', 'build');
mix.sass('./assets/styles/admin.scss', 'build');
mix.copy('./assets/images', 'public/build/images');

// mix.webpackConfig({
//   stats: {
//     children: true,
//   },
// });
