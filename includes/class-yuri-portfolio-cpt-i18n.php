<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://jumbaeric.co.ke
 * @since      1.0.0
 *
 * @package    Yuri_Portfolio_Cpt
 * @subpackage Yuri_Portfolio_Cpt/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Yuri_Portfolio_Cpt
 * @subpackage Yuri_Portfolio_Cpt/includes
 * @author     Eric jumba kedogo <jumbaeric@gmail.com>
 */
class Yuri_Portfolio_Cpt_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'yuri-portfolio-cpt',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
