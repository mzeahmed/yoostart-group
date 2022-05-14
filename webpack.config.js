const Encore = require('@symfony/webpack-encore');

Encore
  .setOutputPath('public/build/')
  .setPublicPath('/build')

  .addEntry('app_js', './assets/js/app.js')
  .addEntry('app_css', './assets/scss/app.scss')
  .addEntry('admin_js', './assets/js/admin.js')
  .addEntry('admin_css', './assets/scss/admin.scss')

  .enableSingleRuntimeChunk()

  .enableBuildNotifications()

  .enableSassLoader()

  .enableReactPreset()

  // Compilation des images et fichiers, installer file-loader | yarn add file-loader
  .copyFiles({
    from: './assets/images',
    to: 'images/[path][name].[ext]',
    pattern: /\.(png|jpg|jpeg|gif)$/
  })
;

module.exports = Encore.getWebpackConfig();