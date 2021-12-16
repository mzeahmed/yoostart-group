<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              yoostart.com
 * @since             1.0.0
 * @package           Yoostartwp_Groups
 *
 * @wordpress-plugin
 * Plugin Name:       Yoostart Groups
 * Plugin URI:        https://yoostart.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Yoostart
 * Author URI:        yoostart.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       yoostartwp-groups
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'YOOSTARTWP_GROUPS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-yoostartwp-groups-activator.php
 */
function activate_yoostartwp_groups() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-yoostartwp-groups-activator.php';
	Yoostartwp_Groups_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-yoostartwp-groups-deactivator.php
 */
function deactivate_yoostartwp_groups() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-yoostartwp-groups-deactivator.php';
	Yoostartwp_Groups_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_yoostartwp_groups' );
register_deactivation_hook( __FILE__, 'deactivate_yoostartwp_groups' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-yoostartwp-groups.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_yoostartwp_groups() {

	$plugin = new Yoostartwp_Groups();
	$plugin->run();

}
run_yoostartwp_groups();
