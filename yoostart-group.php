<?php

/**
 * @link              yoostart.com
 * @since             1.0.0
 * @package           YsGroup
 *
 * @wordpress-plugin
 * Plugin Name:       Yoostart Group
 * Plugin URI:        https://yoostart.com
 * Description:       Plugin de gestion des groupes, à destination de yoostart.com, nécessite le plugin yoostartwp
 * Version:           1.3.3
 * Author:            Yoostart
 * Author URI:        yoostart.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       yoostart-group
 * Domain Path:       /languages
 */

defined('ABSPATH') || die;

if (!defined('YS_GROUP_PLUGIN_FILE')) {
    define('YS_GROUP_PLUGIN_FILE', __FILE__);
}

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/constants.php';

/**
 * @return YsGroup\YsGroup|null
 * @since 1.0.0
 */
function yoostart_group(): ?YsGroup\YsGroup
{
    return \YsGroup\YsGroup::getInstance();
}

yoostart_group();

add_action('after_setup_theme', function () {
    \Carbon_Fields\Carbon_Fields::boot();
});

add_action('ys_group_loaded', function () {
    \YsGroup\Container::load();
});
