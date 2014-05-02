(function($) {
	$( document ).ready( function() {
		$( 'input[name="generate-new-url"]' ).on( 'click', function(e) {
			console.log( "TEST" );
			e.preventDefault();
			$.ajax({
				type : 'post',
				dataType : 'json',
				url : systemInfoAjax.ajaxurl,
				data : { action : 'regenerate_url' },
				success : function( response ) {
					$( '.send-system-info-url' ).html( response );
				},
				error : function( j, t, e ) {
					console.log( j.responseText );
				}
			});
		});
	});
})(jQuery);
