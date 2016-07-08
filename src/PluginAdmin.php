<?php

namespace WPPPT;

class PluginAdmin {

    protected $plugin;
    protected $loader;

    public function __construct( $plugin, $loader ){
        $this->plugin = $plugin;
        $this->loader = $loader;
        $this->menu_pages = array(
            'BulkUpload' => new Admin\Pages\BulkUpload
        );
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {
        foreach($this->menu_pages as $page){
            $page->enqueue_scripts();
        }
    }

    public function add_menu_pages(){
        foreach($this->menu_pages as $page){
            $page->add_menu_pages();
        }
    }

    public function process_forms(){
        foreach($this->menu_pages as $page){
            $page->process_form();
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
