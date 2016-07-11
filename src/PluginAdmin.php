<?php

namespace WPPPT;

class PluginAdmin {

    protected $plugin;
    protected $loader;

    public function __construct( $plugin ){
        $this->plugin = $plugin;
        $this->menu_pages = array(
            'BulkUpload' => new Admin\Pages\BulkUpload($plugin)
        );
    }

    public function init(){
        foreach($this->menu_pages as $page){
            $page->init();
        }

        add_filter( 'rwmb_meta_boxes', array($this, 'define_meta_boxes' ));
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {}

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
