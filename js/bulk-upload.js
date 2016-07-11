jQuery(document).ready(function($){

  var $select = $('#wpppt_select_podcast_id'),
      $dnd = $('#wpppt-dnd-uploader');
  $select.select2();
  $select.on('change', function(e){
    wpUploaderInit.multipart_params['podcast_id'] = parseInt($(e.target).val());
    if(!$dnd.is(':visible')){
      $dnd.slideDown();
    }
  });
});
