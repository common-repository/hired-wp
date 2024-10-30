<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.hiredwp.com
 * @since      1.0.0
 *
 * @package    Hiredwp
 * @subpackage Hiredwp/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Hiredwp
 * @subpackage Hiredwp/admin
 * @author     Hired WP <support@hiredwp.com>
 */
class Hiredwp_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The options name to be used in this plugin
	 *
	 * @since  	1.0.0
	 * @access 	private
	 * @var  	string 		$option_name 	Option name of this plugin
	 */
	private $option_name = 'hiredwp';

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
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Hiredwp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Hiredwp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/hiredwp-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Hiredwp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Hiredwp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/hiredwp-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Echos custom JS
	 *
	 * @since  1.0.0
	 */
	public function custom_admin_js() {


		if ( $this->show_widget() ) {
		    $url = plugin_dir_url( __FILE__ ) . 'js/intercom.js';
		    echo '"<script type="text/javascript" async src="'. $url . '"></script>"';
		}

	}

	/**
	 * Show the widget only if user is admin, and page matches location setting.
	 *
	 * @since  1.0.0
	 */
	public function show_widget() {

		$location = get_option( $this->option_name . '_location', 'admin' );

		if ( $location == 'hidden' ) {
			return false;
		}

		return true;

	}	

	/**
	 * Add an options page under the Settings submenu
	 *
	 * @since  1.0.0
	 */
	public function add_options_page() {
	
		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Hired WP Settings', 'hiredwp' ),
			__( 'Hired WP', 'hiredwp' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_options_page' )
		);
	
	}

	/**
	 * Render the options page for plugin
	 *
	 * @since  1.0.0
	 */
	public function display_options_page() {
		include_once 'partials/hiredwp-admin-display.php';
	}

	/**
	 * Register all related settings of this plugin
	 *
	 * @since  1.0.0
	 */
	public function register_setting() {
		add_settings_section(
			$this->option_name . '_general',
			__( 'General', 'outdated-notice' ),
			array( $this, $this->option_name . '_general_cb' ),
			$this->plugin_name
		);

		add_settings_field(
			$this->option_name . '_location',
			__( 'Widget location', 'hiredwp' ),
			array( $this, $this->option_name . '_location_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_location' )
		);

		register_setting( $this->plugin_name, $this->option_name . '_location', array( $this, $this->option_name . '_sanitize_location' ) );
	}

	/**
	 * Render the text for the general section
	 *
	 * @since  1.0.0
	 */
	public function hiredwp_general_cb() {
		echo '<p>' . __( 'Please change the settings accordingly.', 'outdated-notice' ) . '</p>';
	}

	/**
	 * Render the radio input field for location option
	 *
	 * @since  1.0.0
	 */
	public function hiredwp_location_cb() {
		$location = get_option( $this->option_name . '_location', 'admin' );
		?>
			<fieldset>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_location' ?>" id="<?php echo $this->option_name . '_location' ?>" value="admin" <?php checked( $location, 'admin' ); ?>>
					<?php _e( 'Show in dashboard', 'hiredwp' ); ?>
				</label>
				<br>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_location' ?>" value="hidden" <?php checked( $location, 'hidden' ); ?>>
					<?php _e( 'Hide', 'hiredwp' ); ?>
				</label>
			</fieldset>
		<?php
	}

	/**
	 * Sanitize the text location value before being saved to database
	 *
	 * @param  string $location $_POST value
	 * @since  1.0.0
	 * @return string           Sanitized value
	 */
	public function hiredwp_sanitize_location( $location ) {
		if ( in_array( $location, array( 'admin', 'hidden' ), true ) ) {
	        return $location;
	    }
	}

}
