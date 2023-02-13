<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://jumbaeric.co.ke
 * @since      1.0.0
 *
 * @package    Yuri_Portfolio_Cpt
 * @subpackage Yuri_Portfolio_Cpt/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Yuri_Portfolio_Cpt
 * @subpackage Yuri_Portfolio_Cpt/admin
 * @author     Eric jumba kedogo <jumbaeric@gmail.com>
 */
class Yuri_Portfolio_Cpt_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Yuri_Portfolio_Cpt_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Yuri_Portfolio_Cpt_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/yuri-portfolio-cpt-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Yuri_Portfolio_Cpt_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Yuri_Portfolio_Cpt_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/yuri-portfolio-cpt-admin.js', array('jquery'), $this->version, false);
	}

	/**
	 * Portfolio Custom post Type.
	 */
	public function register_custom_post_types()
	{
		register_post_type(
			'portfolios',
			array(
				'labels'      => array(
					'name'          => __('Portfolios', $this->plugin_name),
					'singular_name' => __('Portfolio', $this->plugin_name),
				),
				'public'      => true,
				'has_archive' => true,
				'rewrite'     => array('slug' => 'portfolios'), // my custom slug
				'show_in_rest' => true,
				'supports' => array('title', 'editor', 'excerpt', 'custom-fields', 'thumbnail'),
				'taxonomies' => array('category', 'post_tag'),
			)
		);

		register_post_type(
			'services',
			array(
				'labels'      => array(
					'name'          => __('Services', $this->plugin_name),
					'singular_name' => __('Service', $this->plugin_name),
				),
				'public'      => true,
				'has_archive' => true,
				'rewrite'     => array('slug' => 'services'), // my custom slug
				'show_in_rest' => true,
				'supports' => array('title', 'editor', 'excerpt', 'custom-fields', 'thumbnail'),
				'taxonomies' => array('category', 'post_tag'),
			)
		);

		register_post_type(
			'testimonials',
			array(
				'labels'      => array(
					'name'          => __('Testimonials', $this->plugin_name),
					'singular_name' => __('Testimonial', $this->plugin_name),
				),
				'public'      => true,
				'has_archive' => true,
				'rewrite'     => array('slug' => 'testimonials'), // my custom slug
				'show_in_rest' => true,
				'supports' => array('title', 'editor', 'excerpt', 'custom-fields', 'thumbnail'),
			)
		);
	}
}
