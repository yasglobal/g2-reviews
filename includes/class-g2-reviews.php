<?php
/**
 * G2 Reviews setup.
 *
 * @package G2Reviews
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main G2 Reviews class.
 */
class G2_Reviews {
	/**
	 * G2 Reviews version.
	 *
	 * @var string
	 */
	public $version = '0.0.1';

	/**
	 * Class constructor.
	 */
	public function __construct() {
		$this->define_constants();
		$this->includes();
		$this->init_hooks();
	}

	/**
	 * Define G2 Reviews Constants.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function define_constants() {
		$this->define( 'G2_REVIEWS_BASENAME', plugin_basename( G2_REVIEWS_FILE ) );
		$this->define( 'G2_REVIEWS_PATH', plugin_dir_path( G2_REVIEWS_FILE ) );
		$this->define( 'G2_REVIEWS_VERSION', $this->version );
	}

	/**
	 * Define constant if not set already.
	 *
	 * @since 1.0.0
	 * @access private
	 *
	 * @param string      $name  Constant name.
	 * @param string|bool $value Constant value.
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function includes() {
		include_once G2_REVIEWS_PATH . 'admin/class-g2-reviews-admin.php';
		include_once G2_REVIEWS_PATH . 'admin/class-g2-reviews-cron.php';
		include_once G2_REVIEWS_PATH . 'admin/class-g2-reviews-settings.php';
		include_once G2_REVIEWS_PATH . 'admin/class-g2-reviews-widget.php';
	}


	/**
	 * Hook into actions and filters.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function init_hooks() {
		register_activation_hook(
			G2_REVIEWS_FILE,
			array( 'G2_Reviews', 'activate_details' )
		);

		add_action( 'plugins_loaded', array( $this, 'check_loaded_plugins' ) );
	}

	/**
	 * Set installed version in options table and create custom tables.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function activate_details() {
		global $wpdb;

		update_option( 'g2_reviews_plugin_version', G2_REVIEWS_VERSION );

		if ( ! $wpdb->get_var( "SHOW TABLES LIKE '{$wpdb->prefix}g2_reviews';" ) ) {
			$collate = '';
			if ( $wpdb->has_cap( 'collation' ) ) {
				$collate = $wpdb->get_charset_collate();
			}

			$sql = "CREATE TABLE {$wpdb->prefix}g2_reviews (
				id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
				star_rating VARCHAR(255),
				title VARCHAR(255),
				comment_answers VARCHAR(255),
				secondary_answers VARCHAR(255),
				verified_current_user BOOLEAN,
				user VARCHAR(255),
				country_region VARCHAR(255),
				other_attributes VARCHAR(255),
				submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				PRIMARY KEY (id)
			) $collate";
		
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
			dbDelta( $sql );
		}
	}
	

	/**
	 * Loads the plugin language files to support different languages.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function check_loaded_plugins() {
		if ( is_admin() ) {
			$current_version = get_option( 'g2_reviews_plugin_version', -1 );

			if ( -1 === $current_version
				|| $current_version < G2_REVIEWS_VERSION
			) {
				self::activate_details();
			}
		}

		load_plugin_textdomain(
			'g2-reviews',
			false,
			basename( dirname( G2_REVIEWS_FILE ) ) . '/languages/'
		);
	}
}

new G2_Reviews();
