<?php

namespace WPPPT;
require_once 'functions.php';

migrate_attachments_to_post_type(['attachment_to_podcast', 'attachment_to_product']);

function migrate_attachments_to_post_type($connection_types){
    // get attachments for type
    $results = get_connected_results($connection_types);

    // aggregate results
    $aggregated = aggregate_results($results);

    $query = get_query_for_post_ids(array_keys($aggregated));

    // iterate over attachments
    while( $query->have_posts() ) {
        $query->the_post();
        $post = get_post();

        // create post
        $new_post_id = create_new_post($post);

        // connect new post to relation type
        connect_new_post_to_connected($new_post_id, $aggregated[$post->ID]);

        // copy over tags
        copy_tags_from_old_to_new($post->ID, $new_post_id);
    }
}

