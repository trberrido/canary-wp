<?php defined('ABSPATH') or die ('No script kiddies please !');

// route : /wp-json/canary/v1/debug
// just a space to play

function response ( $log_content ){

	$message = array(
		'note'		=> 'This log file is reset every time you call this endpoint, and at every successful update',
		'options'	=> get_option( 'canary__options' ),
		'log'		=> 	$log_content
	);
	$response = new WP_REST_Response( canary__generate_data() );
	$response->set_status( 200 );

	return $response;

}

function canary__debug() {

	$response = new WP_REST_Response( canary__generate_data() );
	$response->set_status( 200 );

	return $response;

}