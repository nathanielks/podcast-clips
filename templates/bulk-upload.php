<?php
$form_class = 'media-upload-form type-form validate';
?>
<div class="wrap">
    <h1><?php _e('Bulk Upload Podcast Clips'); ?></h1>

	<form enctype="multipart/form-data" method="post" action="<?php echo esc_url($form_action_url); ?>" class="<?php echo esc_attr( $form_class ); ?>" id="file-form">

    <select name="podcast_id" id="wpppt_select_podcast_id">
        <option value="0">Select a Podcast</option>
        <?php foreach($podcasts as $post_id => $title){ ?>
            <option value="<?php echo intval($post_id); ?>"><?php esc_html_e($title); ?></option>
        <?php } ?>
    </select>

    <p>By selecting a podcast via the above selector, you enable the uploader to automatically connect the clips you upload to the selected podcast. Having uploaded the desired clips, and you would like to upload more, simply change the selected podcast and upload more clips!</p>

    <div id="wpppt-dnd-uploader">
        <?php media_upload_form(); ?>
    </div>

	<script type="text/javascript">
	var post_id = 0, shortform = 3;
    </script>
    <input type="text" class="hidden" name="action" value="<?php echo esc_attr($action); ?>">
    <?php wp_nonce_field($nonce_name); ?>
    <div id="media-items" class="hide-if-no-js"></div>
	</form>
</div>
