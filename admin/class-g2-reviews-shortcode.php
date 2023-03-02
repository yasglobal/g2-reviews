<?php
/**
 * G2 Reviews Shortcode.
 *
 * @package G2Reviews
 */


function g2_review_shortcode($atts)
{
	// Merge the user-defined attributes with the default attributes
	$atts = shortcode_atts(array(
		'review-items' => '3',
		'items-row' => '3',
	), $atts);

	$output = '';
	$fileCall = 'shortcode';
	delete_option( 'g2_reviews_message' );
	if(get_option( 'g2_reviews_settings' )){
		include G2_REVIEWS_PATH . 'admin/g2-reviews-widget-view.php';
	}else if(is_user_logged_in() ){
		$output = 'Please fill G2 API  <a href="/wp-admin/admin.php?page=g2-reviews-settings" title="G2 API Setting">here</a>. ';
	}

	return $output;
}


add_shortcode('g2reviews' , 'g2_review_shortcode');
wp_enqueue_style('G2-style', '/wp-content/plugins/g2-reviews/assets/style.css', array(), '20190328');
//wp_enqueue_script('G2-script', '/wp-content/plugins/g2-reviews/assets/script.js', array(), '20161114', true);

