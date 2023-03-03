<?php
/**
 * G2 Reviews Uninstall.
 *
 * Delete settings and custom table on uninstalling the Plugin.
 *
 * @package G2Reviews
 * @since 1.0.0
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Delete the plugin options.
delete_option( 'g2_reviews_settings' );

// Delete the review table.
global $wpdb;

$table_name = $wpdb->prefix . 'g2_reviews';
$wpdb->query( $wpdb->prepare( 'DROP TABLE IF EXISTS %s', $table_name ) );
