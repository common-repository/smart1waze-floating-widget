<?php

// If uninstall not called from WordPress exit
if( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit;

// Delete option from options table
delete_option( 'sm1waze_settings' );

// Delete multisite option from the database
delete_site_option( 'sm1waze_settings' );
