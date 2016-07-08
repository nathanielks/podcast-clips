<?php

require_once 'functions.php';

remove_attachment_connections(['attachment_to_podcast', 'attachment_to_product']);

function remove_attachment_connections($connection_types){
    // get attachments for type
    $results = get_connected_results($connection_types);

    // aggregate results
    $aggregated = aggregate_results($results);

    foreach($aggregated as $post_id => $to_post){
        // remove old connection
        delete_old_connections($connection_types, $post_id);
    }
}
