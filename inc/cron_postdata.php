<?php defined('ABSPATH') or die ('No script kiddies please !');

// every 5 minutes, send /POST data to API

add_action( 'canary__cron_postdata__hook', 'canary__cron_postdata__callback' );
function canary__cron_postdata__callback (){

	$data = canary__generate_data();

	$auth_header = '';
	$canary__options = get_option( 'canary__options' );
	if ( isset( $canary__options['canary__http_auth__id'] ) && isset( $canary__options['canary__http_auth__psswd'] ) ){
		$auth_header = 'Authorization: Basic ' . base64_encode($canary__options['canary__http_auth__id'] . ':' . $canary__options['canary__http_auth__psswd'] );
	}
	$options = [
		'http' => [
			'method' => 'POST',
			'header' => 'Content-Type: application/json\r\n' . $auth_header,
			'content' => wp_json_encode( $data ),
		],
	];

	$context = stream_context_create( $options );
	$response = json_decode( file_get_contents( $CANARY__API_URL . '/reports', false, $context ), true );

	canary__log( 'response: ' . $response );

	return $response;

}

if ( ! wp_next_scheduled( 'canary__cron_postdata__hook' ) ) {
    wp_schedule_event( time(), 'canary__interval__5_minutes', 'canary__cron_postdata__hook' );
}