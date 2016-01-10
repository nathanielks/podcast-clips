<?php

namespace Podcast_Clips;

class PluginAdmin {

	public function __construct( $plugin ){
		$this->plugin = $plugin;
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		if('development' === WP_ENV){
			$url = 'https://localhost:8080/bundle.js';
			$version = time();
		} else {
			$url = plugin_dir_url( __FILE__ ) . '../build/bundle.js';
			$version = $this->plugin->get_version();
		}

		wp_enqueue_script( $this->plugin->get_plugin_name(), $url, array(), $version, true );
	}
}
