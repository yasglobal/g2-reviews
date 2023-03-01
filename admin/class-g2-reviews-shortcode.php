<?php
/**
 * G2 Reviews Shortcode.
 *
 * @package G2Reviews
 */


function my_shortcode($atts)
{
	// Merge the user-defined attributes with the default attributes
	$atts = shortcode_atts(array(
		'review-items' => '3',
		'width' => '600',
	), $atts);

	$output = '';
	$fileCall = 'shortcode';
	include_once G2_REVIEWS_PATH . 'admin/g2-reviews-widget-view.php';

	return $output;
}

add_shortcode('g2reviews' , 'my_shortcode');

