<?php

/*
 * Plugin Name: Canary
 * Plugin URI: https://perfectogroupe.fr
 * Description: Monitoring access
 * Version: 1.3.2
 * Author: @trberrido
 *
 */

defined('ABSPATH') or die ('No script kiddies please !');

const PLUGIN_DIR = __DIR__;

add_action( 'init', 'canary__get_inc_files', 10 );

function canary__get_inc_files() {
	foreach ( glob( __DIR__ . '/inc/*.php' ) as $file ){
			include_once $file;
	}
}