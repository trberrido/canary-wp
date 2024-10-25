<?php defined('ABSPATH') or die ('No script kiddies please !');

// note:
// the /GET method is not used anymore and kept for debug / tests purpose

add_action( 'rest_api_init', 'canary__rest_api_init');

function canary__rest_api_init (){
	register_rest_route(
		'canary/v1',
		'/infos/',
		array(
			'methods' => 'GET',
			'callback' => 'canary__infos__get',
			'permission_callback' => '__return_true'
		)
	);
	register_rest_route(
		'canary/v1',
		'/debug/',
		array(
			'methods' => 'GET',
			'callback' => 'canary__debug',
			'permission_callback' => '__return_true'
		)
	);
}