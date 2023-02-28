<?php
if ( ! defined( 'ABSPATH' ) && !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

global $wpdb;
$table_name = G2_REVIEWS_TABLE;

// Delete the plugin options
delete_option( 'g2_reviews_settings' );

// Delete the review table
$wpdb->query( "DROP TABLE IF EXISTS $table_name" );
