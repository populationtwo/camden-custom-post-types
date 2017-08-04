<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://population-2.com
 * @since      1.0.0
 *
 * @package    Camden_Custom_Post_Types
 * @subpackage Camden_Custom_Post_Types/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Camden_Custom_Post_Types
 * @subpackage Camden_Custom_Post_Types/includes
 * @author     Population2 <info@population-2.com>
 */
class Camden_Custom_Post_Types_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'camden-custom-post-types',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
