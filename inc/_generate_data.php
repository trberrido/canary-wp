<?php defined('ABSPATH') or die ('No script kiddies please !');

// function call by inc/cron_postdata.php and inc/endpoint__infos__get.php
// ie the /POST and /GET endpoints produce similar data

function canary__generate_data(){

	// required for get_plugins fn
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	$plugins = get_plugins();
	$updates_available = get_site_transient('update_plugins')->response;

	$plugins_filtered = array_map(
		function( $plugin_data, $plugin_slug ) use ($updates_available) {
			$new_version = $plugin_data['Version'];
			$update_available = false;
			if ( isset( $updates_available[ $plugin_slug ] ) ) {
				$new_version = $updates_available[ $plugin_slug ]->new_version;
				$update_available = true;
			}
			return array(
				'name'				=> $plugin_data['Name'],
				'version'			=> $plugin_data['Version'],
				'newVersion'		=> $new_version,
				'updateAvailable'	=> $update_available
			);
		},
		$plugins,
		array_keys( $plugins ),
	);

	$canary__options = get_option( 'canary__options' );

	$data = array(
		'sourceType'		=> 'wordpress',
		'marker'			=> isset( $canary__options['canary__sitemarker'] ) ? $canary__options['canary__sitemarker'] : '',
		'GET'				=> get_rest_url( null, 'canary/v1/infos/' ),
		'name'				=> get_bloginfo( 'name' ),
		'phpVersion'		=> phpversion(),
		'wpVersion'			=> get_bloginfo( 'version' ),
		'admin'				=> get_bloginfo( 'admin_email' ),
		'wpUrl'				=> get_bloginfo( 'wpurl' ),
		'plugins'			=> $plugins_filtered,
	);

	return $data;

}