<?php

namespace WPPPT;

function get_connected_results($type){
    global $wpdb;

    $how_many = count($type);
    $placeholders = array_fill(0, $how_many, '%s');
    $format = implode(', ', $placeholders);

    return $wpdb->get_results(
        $wpdb->prepare("
            select p2p_to as to_id, p2p_from as from_id, p2p_type as type
            from {$wpdb->prefix}p2p
            where p2p_type IN ({$format})
            ",
            $type
    )
);
}

function aggregate_results($results){
    $aggregated = array();
    foreach($results as $result){
        $aggregated[$result->from_id][] = array(
            'id' => $result->to_id,
            'type' => $result->type
        );
    }
    return $aggregated;
}

function get_query_for_post_ids($ids){
    return new \WP_Query(array(
        'post__in' => $ids,
        'post_type' => 'attachment',
        'posts_per_page' => -1,
        'post_status' => 'any'
    ));
}

function create_new_post($old_post){
    $unset = array( 'ID', 'post_parent', 'guid', 'post_mime_type');
    $new_args = array_merge( (array) $old_post, array(
        'post_type' => 'podcast_clip',
        'post_status' => 'publish'
    ));
    foreach($unset as $key){
        unset($new_args[$key]);
    }

    $new_post_id = wp_insert_post($new_args);
    if(is_wp_error($new_post_id)){
        throw new Exception($new_post_id->get_error_message());
    }

    $enclosure_key = apply_filters('wpppt_powerpress_enclosure_key', '_podcast-clips:enclosure', $old_post->ID, $new_post_id);

    update_post_meta($new_post_id, 'attachment_id', $old_post->ID);
    update_post_meta($new_post_id, $enclosure_key, wp_get_attachment_url($old_post->ID));
    return $new_post_id;
}

function connect_new_post_to_connected($post_id, $connect_to){
    foreach($connect_to as $post){
        $type = str_replace('attachment', 'podcast_clip', $post['type']);
        p2p_create_connection($type, array(
            'from' => $post_id,
            'to' => $post['id']
        ));
    }
}

function copy_tags_from_old_to_new($old_id, $new_id){
    $old_terms = wp_get_post_terms($old_id, 'post_tag');
    $old_term_ids = array_map(function($term){
        return $term->term_id;
    }, $old_terms);
    wp_set_post_terms($new_id, $old_term_ids, 'post_tag', true);
}

// TODO update to work with new aggregated syntax
function delete_old_connections($types, $post_id){
    foreach($types as $type){
        p2p_delete_connections($type, array('from' => $post_id));
    }
}
