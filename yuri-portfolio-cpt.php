<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://jumbaeric.co.ke
 * @since             1.0.0
 * @package           Yuri_Portfolio_Cpt
 *
 * @wordpress-plugin
 * Plugin Name:       Yuri Portfolio Custom Post Type
 * Plugin URI:        https://jumbaeric.co.ke/plugins/yuri-portfolio-cpt
 * Description:       This plugin adds portfolio, testimonials, services custom post type, and custom meta fields, this enables freelancers to manage their portfolios, add gallery images to portolio, services, and testimonials
 * Version:           1.0.0
 * Author:            Eric jumba kedogo
 * Author URI:        https://jumbaeric.co.ke
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       yuri-portfolio-cpt
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
define( 'YURI_PORTFOLIO_CPT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-yuri-portfolio-cpt-activator.php
 */
function activate_yuri_portfolio_cpt() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-yuri-portfolio-cpt-activator.php';
	Yuri_Portfolio_Cpt_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-yuri-portfolio-cpt-deactivator.php
 */
function deactivate_yuri_portfolio_cpt() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-yuri-portfolio-cpt-deactivator.php';
	Yuri_Portfolio_Cpt_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_yuri_portfolio_cpt' );
register_deactivation_hook( __FILE__, 'deactivate_yuri_portfolio_cpt' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-yuri-portfolio-cpt.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_yuri_portfolio_cpt() {

	$plugin = new Yuri_Portfolio_Cpt();
	$plugin->run();

}
run_yuri_portfolio_cpt();
