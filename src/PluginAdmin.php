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

		$url = WPPPT_ROOT_URL;
		$dir = '/js/build/';
		$files = ['vendors', 'bundle'];
		$version = $this->plugin->get_version();
		$handle = $this->plugin->get_plugin_name();

		if('development' === WP_ENV){
			$url = 'https://localhost:8080';
			$version = time();
		}

		foreach($files as $file){
			wp_enqueue_script( "${handle}-${file}", "${url}${dir}${file}.js", array(), $version, true );
		}

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
