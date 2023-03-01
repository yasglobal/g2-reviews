<?php
/**
 * G2 Reviews Shortcode.
 *
 * @package G2Reviews
 */

if (!class_exists('WP_Widget')) {
	require_once(ABSPATH . 'wp-includes/class-wp-widget.php');
}

class G2_Reviews_Shortcode
{
	function my_shortcode( $atts ) {
		// Merge the user-defined attributes with the default attributes
		$atts = shortcode_atts( array(
			'attribute1' => 'default value 1',
			'attribute2' => 'default value 2',
			'attribute3' => 'default value 3',
		), $atts );

		// Access the attributes using the $atts array
		$output = '<p>Attribute 1: ' . esc_html( $atts['attribute1'] ) . '</p>';
		$output .= '<p>Attribute 2: ' . esc_html( $atts['attribute2'] ) . '</p>';
		$output .= '<p>Attribute 3: ' . esc_html( $atts['attribute3'] ) . '</p>';

		return $output;
	}
}
add_shortcode( 'G2_Reviews_Shortcode', 'my_shortcode' );
