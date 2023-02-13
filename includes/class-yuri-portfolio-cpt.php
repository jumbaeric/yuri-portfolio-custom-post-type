<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://jumbaeric.co.ke
 * @since      1.0.0
 *
 * @package    Yuri_Portfolio_Cpt
 * @subpackage Yuri_Portfolio_Cpt/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Yuri_Portfolio_Cpt
 * @subpackage Yuri_Portfolio_Cpt/includes
 * @author     Eric jumba kedogo <jumbaeric@gmail.com>
 */
class Yuri_Portfolio_Cpt {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Yuri_Portfolio_Cpt_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'YURI_PORTFOLIO_CPT_VERSION' ) ) {
			$this->version = YURI_PORTFOLIO_CPT_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'yuri-portfolio-cpt';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_custom_post_types();
		$this->define_meta_boxes();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Yuri_Portfolio_Cpt_Loader. Orchestrates the hooks of the plugin.
	 * - Yuri_Portfolio_Cpt_i18n. Defines internationalization functionality.
	 * - Yuri_Portfolio_Cpt_Admin. Defines all hooks for the admin area.
	 * - Yuri_Portfolio_Cpt_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-yuri-portfolio-cpt-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-yuri-portfolio-cpt-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-yuri-portfolio-cpt-admin.php';

		/**
		 * The class responsible for defining all metabox that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-yuri-portfolio-metabox.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-yuri-portfolio-cpt-public.php';

		$this->loader = new Yuri_Portfolio_Cpt_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Yuri_Portfolio_Cpt_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Yuri_Portfolio_Cpt_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Yuri_Portfolio_Cpt_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Yuri_Portfolio_Cpt_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

		/**
	 * Register all of the custom post types
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_custom_post_types() {

		$plugin_admin = new Yuri_Portfolio_Cpt_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'init', $plugin_admin, 'register_custom_post_types' );

	}

	// Add Portfolio Metabox
	function define_meta_boxes() {
		$portfolio_meta_box = new Yuri_Portfolio_Metabox('yuri_lucas_box_id', 'portfolio', 'Portfolio Details', 'portfolios');
		$testimonial_meta_box = new Yuri_Portfolio_Metabox('yuri_lucas_box_id', 'testimonial', 'Testimonial Details', 'testimonials');
		$service_meta_box = new Yuri_Portfolio_Metabox('yuri_lucas_box_id', 'service', 'Service Details', 'services');
		$gallery_meta_box = new Yuri_Portfolio_Metabox('post_custom_gallery', 'gallery', 'Portfolio Gallery', 'portfolios', 'normal', 'core');
	 
		$this->loader->add_action( 'add_meta_boxes', $portfolio_meta_box, 'add_metabox' );
		$this->loader->add_action( 'add_meta_boxes', $testimonial_meta_box, 'add_metabox' );
		$this->loader->add_action( 'add_meta_boxes', $service_meta_box, 'add_metabox' );
		$this->loader->add_action( 'add_meta_boxes', $gallery_meta_box, 'add_metabox' );
		
		$this->loader->add_action( 'admin_head-post.php', $gallery_meta_box, 'portfolio_gallery_styles_scripts' );
		$this->loader->add_action( 'admin_head-post-new.php', $gallery_meta_box, 'portfolio_gallery_styles_scripts' );
		
		$this->loader->add_action( 'save_post', $portfolio_meta_box, 'save_portfolio_postdata' );
		$this->loader->add_action( 'save_post', $testimonial_meta_box, 'save_testimonial_postdata' );
		$this->loader->add_action( 'save_post', $service_meta_box, 'save_service_postdata' );
		$this->loader->add_action( 'save_post', $gallery_meta_box, 'portfolio_gallery_save' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Yuri_Portfolio_Cpt_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
