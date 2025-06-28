( function( $ ){
  $( document ).ready( function(){
    $( '.newsup-btn-get-started' ).on( 'click', function( e ) {
      e.preventDefault();
      $( this ).html( 'Processing.. Please wait' ).addClass( 'updating-message' );
      $.post(newsup_ajax_object.ajax_url, { 'action' : 'install_act_plugin' }, function( response ){
        location.href = 'admin.php?page=ansar-demo-import';
      } );
    } );
  } );

  $( document ).on( 'click', '.notice-get-started-class .notice-dismiss', function () {
    // Read the "data-notice" information to track which notice
    // is being dismissed and send it via AJAX
    var type = $( this ).closest( '.notice-get-started-class' ).data( 'notice' );
    // Make an AJAX call
    $.ajax( ajaxurl,
    {
      type: 'POST',
      data: {
        action: 'newsup_dismissed_notice_handler',
        type: type,
      }
    } );
  } );
}( jQuery ) )