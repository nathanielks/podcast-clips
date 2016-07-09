<?php

namespace WPPPT\Admin\Pages;

class BulkUpload {

    public function __construct($plugin){
        $this->plugin = $plugin;
        $this->action = 'wpppt_async_upload';
        $this->nonce_name = 'media-form';
        $this->page_slug = 'bulk-upload-podcast-clips';
    }

    public function init(){
        if(is_admin()){
            add_action('admin_menu', array($this, 'add_menu_pages'));
            add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
            add_action("admin_post_{$this->action}", array($this, 'process_async_upload'));
            add_filter('get_edit_post_link', array($this, 'filter_get_edit_post_link'), 3, 20);
        }
    }

    public function enqueue_scripts(){
        wp_enqueue_script('plupload-handlers');
    }

    public function add_menu_pages(){
        add_submenu_page(
            'edit.php?post_type=podcast',
            __('Bulk Upload Podcast Clips', 'wpppt'),
            __('Bulk Upload Podcast Clips', 'wpppt'),
            'upload_files',
            $this->page_slug,
            array($this, 'render')
        );
    }

    public function process_async_upload(){
        header( 'Content-Type: text/html; charset=' . get_option( 'blog_charset' ) );

        if ( ! current_user_can( 'upload_files' ) ) {
            wp_die( __( 'You do not have permission to upload files.' ) );
        }

        check_admin_referer($this->nonce_name);

        $attachment_id = media_handle_upload( 'async-upload', 0 );

        if ( is_wp_error($attachment_id) ) {
            echo '<div class="error-div error">
            <a class="dismiss" href="#" onclick="jQuery(this).parents(\'div.media-item\').slideUp(200, function(){jQuery(this).remove();});">' . __('Dismiss') . '</a>
            <strong>' . sprintf(__('&#8220;%s&#8221; has failed to upload.'), esc_html($_FILES['async-upload']['name']) ) . '</strong><br />' .
            esc_html($attachment_id->get_error_message()) . '</div>';
            exit;
        }

        require_once WPPPT_PLUGIN_PATH . '/migrations/functions.php';
        $post_id = \WPPPT\create_new_post(get_post($attachment_id));

        if ( is_wp_error($post_id) ) {
            echo '<div class="error-div error">
            <a class="dismiss" href="#" onclick="jQuery(this).parents(\'div.media-item\').slideUp(200, function(){jQuery(this).remove();});">' . __('Dismiss') . '</a>
            <strong>' . sprintf(__('&#8220;%s&#8221; has failed to upload.'), esc_html($_FILES['async-upload']['name']) ) . '</strong><br />' .
            esc_html($post_id->get_error_message()) . '</div>';
            exit;
        }

        echo apply_filters( 'wpppt_async_upload', $attachment_id );
    }

    public function filter_get_edit_post_link($link, $attachment_id, $context){
        if(!isset($_SERVER['HTTP_REFERER'])){
            return $link;
        }

        parse_str(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY), $query);
        if(!(isset($query['page']) && $query['page'] === $this->page_slug)){
            return $link;
        }

        $attachment = get_post($attachment_id);
        if('attachment' !== $attachment->post_type){
            return $link;
        }

        $post_id = $this->get_attached_podcast_clip_id($attachment_id);
        if(is_null($post_id)){
            return $link;
        }

        return get_edit_post_link($post_id);
    }

    public function get_attached_podcast_clip_id($attachment_id){
        global $wpdb;

        $post_id = $wpdb->get_var($wpdb->prepare(
            "select pm.post_id
            from $wpdb->postmeta pm
            where pm.meta_key = %s
            and pm.meta_value = %d",
            'attachment_id',
            $attachment_id
        ));

        return $post_id;
    }

    public function render(){
        $action_url = admin_url("admin-post.php?action={$this->action}");
        add_filter( 'plupload_init', function($plupload_init) use ($action_url){
            $plupload_init['url'] = $action_url;
            return $plupload_init;
        });
        wpppt_get_template('bulk-upload.php', array(
            'form_action' => $action_url,
            'nonce_name' => $this->nonce_name
        ));
    }

}
