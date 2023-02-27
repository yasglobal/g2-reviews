<?php
/**
 * G2 Reviews Admin.
 *
 * @package G2Reviews
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create admin menu, add links on plugin page etc.
 */
class G2_Reviews_Admin {
	/**
	 * Initializes WordPress hooks.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );

		add_filter(
			'plugin_action_links_' . G2_REVIEWS_BASENAME,
			array( $this, 'settings_link' )
		);
	}

	/**
	 * Added Pages in Menu for Settings.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_menu() {
		add_menu_page(
			'G2 Reviews',
			'G2 Reviews',
			'administrator',
			'g2-reviews-settings',
			array( $this, 'g2_reviews_page' ),
			'dashicons-format-quote'
		);
	}

	/**
	 * Settings Page where user can change the Settings for G2.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function g2_reviews_page() {
		new G2_Reviews_Settings();

		add_filter( 'admin_footer_text', array( $this, 'admin_footer_text' ), 1 );
	}

	/**
	 * Add Plugin Support in the footer of Admin Pages.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Shows version and website link.
	 */
	public function admin_footer_text() {
		$footer_text = sprintf(
			// translators: placeholders like %2$s replaced with the link.
			__( 'G2 Reviews version %1$s by <a href="%2$s" title="YAS Global Website" target="_blank">YAS Global</a> - <a href="%3$s" title="Support forums" target="_blank">Support forums</a>', 'g2-reviews' ),
			G2_REVIEWS_VERSION,
			'https://www.yasglobal.com',
			'https://wordpress.org/support/plugin/g2-reviews'
		);

		return $footer_text;
	}

	/**
	 * Add About and Settings Page Link on the Plugin Page under the Plugin Name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $links Contains the Plugin Basic Link (Activate/Deactivate/Delete).
	 *
	 * @return array Plugin Basic Links and added some customer link for Settings,
	 * and Contact.
	 */
	public function settings_link( $links ) {
		$contact_link  = '<a href="https://www.yasglobal.com/#contact-us/" target="_blank">' .
			__( 'Contact', 'g2-reviews' ) .
		'</a>';
		$settings_link = '<a href="admin.php?page=g2-reviews" target="_blank">' .
			__( 'Settings', 'g2-reviews' ) .
		'</a>';

		array_unshift( $links, $contact_link );
		array_unshift( $links, $settings_link );

		return $links;
	}
}

new G2_Reviews_Admin();
