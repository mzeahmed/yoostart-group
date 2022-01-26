// Surcharge de la configuration par defaut de @wordpress/scripts pour ajouter des points d'entrée pérsonnalisés

// yarn start
// yarn run buil

const defaultConfig = require('@wordpress/scripts/config/webpack.config.js');
const path = require('path');

module.exports = {
  ...defaultConfig,
  ...{
    entry: {
      index: path.resolve(process.cwd(), 'assets/js', 'index.js')
    }
  }
};