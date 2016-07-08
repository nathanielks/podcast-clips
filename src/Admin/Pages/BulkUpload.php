<?php

namespace WPPPT\Admin\Pages;

class BulkUpload implements Page {

    public function enqueue_scripts(){
        wp_enqueue_script('plupload-handlers');
    }

    public function add_menu_pages(){
        add_submenu_page(
            'edit.php?post_type=podcast',
            __('Bulk Upload Podcast Clips', 'wpppt'),
            __('Bulk Upload Podcast Clips', 'wpppt'),
            'upload_files',
            'bulk-upload-podcast-clips',
            array($this, 'render')
        );
    }

    public function process_form(){
        add_filter('async_upload_audio', function($id){
            error_log(print_r($id, true));
            error_log(print_r($_REQUEST, true));
            error_log(print_r($_SERVER, true));
        });
    }

    public function render(){
        add_filter( 'plupload_init', function($plupload_init){
            $plupload_init['url'] = WPPPT_PLUGIN_URL . '/src/includes/async-upload.php';
            return $plupload_init;
        });
        wpppt_get_template('bulk-upload.php');
    }

}
