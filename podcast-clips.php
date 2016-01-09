<?php
/**
 *
 * @wordpress-plugin
 * Plugin Name:       Podcast Clips
 * Version:           0.0.1
 * Author:            Nathaniel Schweinberg
 * Author URI:        http://fightthecurrent.org/
 * License:           MIT
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

function run_podcast_clips() {
	$plugin = new Podcast_Clips\Plugin();
	$plugin->run();
}

run_podcast_clips();
