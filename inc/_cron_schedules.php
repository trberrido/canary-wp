<?php defined('ABSPATH') or die ('No script kiddies please !');
// add a custom interval of 5 minutes to the cron schedules
// this file has to be included before cron_postdata.php and cron_update.php

add_filter( 'cron_schedules', 'canary__set_interval' );
function canary__set_interval( $schedules ) {
	$schedules['canary__interval__5_minutes'] = array(
		'interval'	=> 60 * 5,
		'display'	=> 'Every 5 Minutes'
	);
	return $schedules;
}