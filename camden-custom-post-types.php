<?php

/**
 * Camden Custom Post Type
 *
 * Plugin to create Custom Post Types on Camden theme.
 *
 * @package   Camden_Custom_Post_Type
 * @author    Population2 <populationtwo@gmail.com>
 * @license   GPL-2.0+
 * @link      http://population-2.com
 * @copyright 2017 Population2
 *
 * @wordpress-plugin
 * Plugin Name:       Camden Custom Post Type
 * Plugin URI:        http://population-2.com
 * Description:       Plugin to create custom post type on Camden theme.
 * Version:           1.0.0
 * Author:            Population2
 * Author URI:
 * Text Domain:       camden-custom-post-type
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/populationtwo/camden-custom-post-types
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-camden-custom-post-types-activator.php
 */
function activate_camden_cpt() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-camden-custom-post-types-activator.php';
	Camden_Custom_Post_Types_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-camden-custom-post-types-deactivator.php
 */
function deactivate_camden_cpt() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-camden-custom-post-types-deactivator.php';
	Camden_Custom_Post_Types_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_camden_cpt' );
register_deactivation_hook( __FILE__, 'deactivate_camden_cpt' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-camden-custom-post-types.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_camden_cpt() {

	$plugin = new Camden_Custom_Post_Types();
	$plugin->run();

}
run_camden_cpt();
