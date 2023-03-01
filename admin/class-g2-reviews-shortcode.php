<?php
/**
 * G2 Reviews Shortcode.
 *
 * @package G2Reviews
 */


function my_shortcode( $atts ) {
	// Merge the user-defined attributes with the default attributes
	$atts = shortcode_atts( array(
		'review-items' => '1',
		'width' => '600',
	), $atts );

/*	// Access the attributes using the $atts array
	$output =  '<div data-rev="'.esc_html( $atts['review-items']) .'" style="width:'.esc_html( $atts['width']) .'px">
					  <div class="rev-user-icon">
						<span><img src="https://www.sageintacct.com/themes/custom/sageintacct/images/g2-anonymous-avatar.svg"></span>
						<span>Verified User in Health, Wellness and Fitness</span>
						<time datetime="2021-09-23">23 Sep 2021</time>
					  </div>
					  <div class="rev-rate star-3-5"> <i></i> <i></i> <i></i> <i></i> <i></i> </div>
					  <div class="rev-topic">Reliable and always available tool</div>
					  <div class="rev-q">What do you like best about the product?</div>
					  <div class="rev-a">The chief benefits of using Sage Intacct are the product features and capabilities of the software.</div>
					  <div class="rev-q">What do you dislike about the product?</div>
					  <div class="rev-a">There is a learning curve to Sage Intacct, as it takes a while to get used to report-building features, import data template structures, etc.</div>
					  <div class="rev-q">What problems is the product solving and how is that benefiting you?</div>
					  <div class="rev-a">Automation. As I use features that improve automation, I see a massive benefit for my company.</div>
					</div>';*/

	$fileCall = 'shortcode';
	include_once G2_REVIEWS_PATH . 'admin/g2-reviews-widget-view.php';

	return $output;
}
add_shortcode('my_shortcode', 'my_shortcode');

