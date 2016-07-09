<?php
$form_class = 'media-upload-form type-form validate';
$post_id = 0;
?>
<div class="wrap">
	<h1>Title!</h1>

	<form enctype="multipart/form-data" method="post" action="<?php echo esc_url($form_action); ?>" class="<?php echo esc_attr( $form_class ); ?>" id="file-form">

	<?php media_upload_form(); ?>

	<script type="text/javascript">
	var post_id = <?php echo $post_id; ?>, shortform = 3;
	</script>
    <?php wp_nonce_field($nonce_name); ?>
    <div id="media-items" class="hide-if-no-js"></div>
	</form>
</div>
