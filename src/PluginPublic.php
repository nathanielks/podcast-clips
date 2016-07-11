<?php

namespace WPPPT;

class PluginPublic {

	public function __construct( $plugin ){
		$this->plugin = $plugin;
	}

	public function register_post_types(){

		$args = array(
			'label'  => 'Podcast',
			'labels' => array(
				'name'          => 'Podcasts',
				'singular_name' => 'Podcast',
			),
			'public'      => true,
			'supports' =>   array(
				'title',
				'editor',
				'thumbnail',
			),
			'has_archive' => 'podcasts'
		);

        register_post_type( 'podcast', $args );

		$args = array(
			'label'  => 'Podcast Clip',
			'labels' => array(
				'name'          => 'Podcast Clips',
                'singular_name' => 'Podcast Clip',
                'edit_item' => 'Edit Podcast Clip',
                'add_new_item' => 'Add New Podcast Clip',
			),
			'public'      => true,
			'supports' =>   array(
				'title',
				'editor',
				'thumbnail',
			),
            'has_archive' => 'podcast_clips',
            'show_in_menu' => 'edit.php?post_type=podcast'
		);

		register_post_type( 'podcast_clip', $args );

	}

	public function register_tags(){
		register_taxonomy_for_object_type( 'post_tag', 'podcast' );
		register_taxonomy_for_object_type( 'post_tag', 'podcast_clip' );
		register_taxonomy_for_object_type( 'post_tag', 'attachment' );
	}

	public function connect_post_types(){
		if( function_exists('p2p_register_connection_type') ){
			add_action( 'p2p_init', function () {

				p2p_register_connection_type( array(
					'name' => 'podcast_to_product',
					'from' => 'podcast',
					'to' => 'product'
				) );

				p2p_register_connection_type( array(
					'name' => 'podcast_clip_to_podcast',
					'from' => 'podcast_clip',
					'to' => 'podcast'
				) );

				p2p_register_connection_type( array(
					'name' => 'podcast_clip_to_product',
					'from' => 'podcast_clip',
					'to' => 'product'
                ) );

			});
		}
	}
}
