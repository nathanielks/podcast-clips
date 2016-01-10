<?php

namespace WPPPT;

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

		$file = '/js/build/bundle.js';
		$url = WPPPT_ROOT_URL . $file;
		$version = $this->plugin->get_version();

		if('development' === WP_ENV){
			$url = 'https://localhost:8080/bundle.js';
			$version = time();
		}

		wp_enqueue_script( $this->plugin->get_plugin_name(), $url, array(), $version, true );
	}

	public function add_meta_boxes(){
		add_meta_box(
			'Podcast Clips',
			__( 'Podcast Clips', 'wppc' ),
			array( $this, 'podcast_clips_meta_box_html' ),
			'podcast'
		);
	}

	public function podcast_clips_meta_box_html(){
		echo '<div id="podcast-clips-root">Loading...</div>';
	}
}
