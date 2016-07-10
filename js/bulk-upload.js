jQuery(document).ready(function($){
  var $select = $('#wpppt_select_podcast_id');
  $select.on('change', function(e){
    wpUploaderInit.multipart_params['podcast_id'] = parseInt($(e.target).val());
  });
});
