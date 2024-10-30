<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.hiredwp.com
 * @since             1.0.0
 * @package           Hiredwp
 *
 * @wordpress-plugin
 * Plugin Name:       WordPress Technical Support – Free 24/7 WordPress Technical Support by Hired WP
 * Plugin URI:        https://www.hiredwp.com/
 * Description:       Hired WP provides the WordPress technical support and maintenance services needed to grow your small business.
 * Version:           1.0.0
 * Author:            Hired WP
 * Author URI:        https://www.hiredwp.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       hiredwp
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-hiredwp-activator.php
 */
function activate_hiredwp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-hiredwp-activator.php';
	Hiredwp_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-hiredwp-deactivator.php
 */
function deactivate_hiredwp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-hiredwp-deactivator.php';
	Hiredwp_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_hiredwp' );
register_deactivation_hook( __FILE__, 'deactivate_hiredwp' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-hiredwp.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_hiredwp() {

	$plugin = new Hiredwp();
	$plugin->run();

}
run_hiredwp();
