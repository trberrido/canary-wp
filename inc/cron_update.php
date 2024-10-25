<?php defined('ABSPATH') or die ('No script kiddies please !');

// every 5 minutes, update this plugin

add_action( 'canary__cron_update__hook', 'canary__cron_update__callback' );
function canary__cron_update__callback(){

	$status = 'Updating';
	$zip_file = PLUGIN_DIR . '/canary.zip';
	if ( ! file_put_contents( $zip_file, file_get_contents( $CANARY__PLUGIN_DL_URL ) ) ){
		$status = 'Unable to download the latest version';
		return canary__log( 'Update status: ' . $status );
	}

	chmod( $zip_file, 0777 );

	$zip = new ZipArchive();
	if ( ! $zip->open( $zip_file ) ) {
		$status = 'Unable to open the latest version';
		return canary__log( $status );
	}

	if ( ! $zip->extractTo( PLUGIN_DIR ) ){
		$status = 'Unable to unzip the latest version';
		return canary__log( $status );
	}

	$zip->close();

	unlink( $zip_file );

	unlink( PLUGIN_DIR . '/canary.log' );

	return canary__log( 'Update done :)' );

}

if ( ! wp_next_scheduled( 'canary__cron_update__hook' ) ) {
    wp_schedule_event( time(), 'canary__interval__5_minutes', 'canary__cron_update__hook' );
}