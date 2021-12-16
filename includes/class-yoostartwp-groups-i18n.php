<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       yoostart.com
 * @since      1.0.0
 *
 * @package    Yoostartwp_Groups
 * @subpackage Yoostartwp_Groups/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Yoostartwp_Groups
 * @subpackage Yoostartwp_Groups/includes
 * @author     Yoostart <contact@yoostart.com>
 */
class Yoostartwp_Groups_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'yoostartwp-groups',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
