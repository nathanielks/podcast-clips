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
		if('podcast' !== get_post_type()){
			return;
		}

		if('development' === WP_ENV){
			$url = 'https://localhost:8080/bundle.js';
			$version = time();
		} else {
			$url = plugin_dir_url( __FILE__ ) . '../build/bundle.js';
			$version = $this->plugin->get_version();
		}

		wp_enqueue_script( $this->plugin->get_plugin_name(), $url, array(), $version, true );
	}

	public function add_meta_boxes(){
		add_meta_box(
			'podcast_clips',
			__( 'Podcast Clips', 'wppc' ),
			array( $this, 'podcast_clips_meta_box_html' ),
			'podcast'
		);
	}

	public function podcast_clips_meta_box_html(){
		echo '<div id="podcast-clips-root">Loading...</div>';
	}
}
