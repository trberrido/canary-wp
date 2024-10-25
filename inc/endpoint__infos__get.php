<?php defined('ABSPATH') or die ('No script kiddies please !');

// route : /wp-json/canary/v1/infos

function canary__infos__get() {

	$data = canary__generate_data();

	$response = new WP_REST_Response( $data );
	$response->set_status( 200 );

	return $response;

}