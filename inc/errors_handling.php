<?php defined('ABSPATH') or die ('No script kiddies please !');

// PHP errors handling

/*

curently not wokling

add_action('init', 'canary__detect_errors', 20 );
function canary__detect_errors() {

	$log_file = WP_CONTENT_DIR . '/debug.log';
    $last_error = get_option( 'canary__last_processed_error' );

	if ( file_exists( $log_file ) ) {

		$log_content = file_get_contents( $log_file );

		if ( strpos( $log_content, 'PHP Fatal error' ) !== false ) {

			$has_error = false;
			$new_errors = '';

			$error_messages = explode( "\n", $log_content );
			foreach ( $error_messages as $message ) {
				if ( !empty( $message ) && $message !== $last_error) {
					$has_error = true;
					$new_errors .= $message . "\n";
				}
			}

			if ( $has_error ){
				update_option( 'canary__last_processed_error', $message );
				canary__log( 'PHP Errors: ' . $new_errors );
			}

		}

	}

}

*/