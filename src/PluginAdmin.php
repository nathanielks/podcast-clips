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
    }

    public function add_meta_boxes(){
        add_filter( 'rwmb_meta_boxes', array($this, 'define_meta_boxes') );
    }

    public function define_meta_boxes($meta_boxes) {
        $meta_boxes[] = array(
            'title' => __('Podcast Clips Meta'),
            'post_types' => 'podcast_clip',
            'fields'     => array(
                array(
                    'id'   => 'attachment_id',
                    'name' => __( 'Attached Clip', 'textdomain' ),
                    'type' => 'file_advanced',
                ),
            ),
        );
        return $meta_boxes;
    }
}
