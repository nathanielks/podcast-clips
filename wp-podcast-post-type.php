<?php
/**
 *
 * @wordpress-plugin
 * Plugin Name:       WP Podcast Post Type
 * Description:       A plugin that adds podcast and podcast_clip post types.
 * Version:           0.0.1
 * Author:            Nathaniel Schweinberg
 * Author URI:        http://fightthecurrent.org/
 * License:           MIT
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define('WPPPT_PLUGIN_PATH', __DIR__);
define('WPPPT_PLUGIN_URL', untrailingslashit(plugin_dir_url(__FILE__)));

function run_WPPPT() {
	$plugin = new WPPPT\Plugin();
	$plugin->run();
}

run_WPPPT();
