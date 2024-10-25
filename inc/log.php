<?php defined('ABSPATH') or die ('No script kiddies please !');

// log will be readible through /wp-json/canary/v1/debug
// see inc/endpoint_debug.php

function canary__log( $message ){

	file_put_contents( PLUGIN_DIR . '/canary.log', date( 'Y-m-d H:i:s' ) . ': ' . $message . "\n", FILE_APPEND);
	return ;

}