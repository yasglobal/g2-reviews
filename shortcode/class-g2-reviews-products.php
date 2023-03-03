<?php
/**
 * G2 Reviews Shortcode.
 *
 * @package G2Reviews
 */

/**
 * Create g2_review_shortcode Class for shortcode.
 *
 * @param array $atts Shortcode attributes.
 *
 * @return string The shortcode output.
 */
function g2_review_shortcode( $atts ) {
	// Merge the user-defined attributes with the default attributes.
	$atts = shortcode_atts(
		array(
			'review-items' => '3',
			'items-row'    => '3',
		),
		$atts
	);

	$output    = '';
	$file_call = 'shortcode';
	delete_option( 'g2_reviews_message' );
	if ( get_option( 'g2_reviews_settings' ) ) {
		include G2_REVIEWS_PATH . 'admin/g2-reviews-widget-view.php';
	} elseif ( is_user_logged_in() ) {
		$output = 'Please fill G2 API  <a href="/wp-admin/admin.php?page=g2-reviews-settings" title="G2 API Setting">here</a>. ';
	}

	return $output;
}


add_shortcode( 'g2reviews', 'g2_review_shortcode' );
wp_enqueue_style( 'G2-style', '/wp-content/plugins/g2-reviews/assets/style.css', array(), '20190328' );
