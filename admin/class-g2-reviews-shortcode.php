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
	include G2_REVIEWS_PATH . 'admin/g2-reviews-widget-view.php';

	return $output;
}


add_shortcode('g2reviews' , 'g2_review_shortcode');
wp_enqueue_style('G2-style', '/wp-content/plugins/g2-reviews/assets/style.css', array(), '20190328');
//wp_enqueue_script('G2-script', '/wp-content/plugins/g2-reviews/assets/script.js', array(), '20161114', true);

