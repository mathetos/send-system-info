(function($) {
	$( document ).ready( function() {
		$( 'input[name="generate-new-url"]' ).on( 'click', function(e) {
			e.preventDefault();
			$.ajax({
				type : 'post',
				dataType : 'json',
				url : systemInfoAjax.ajaxurl,
				data : { action : 'regenerate_url' },
				success : function( response ) {
					$( '.system-info-url' ).html( response );
				},
				error : function( j, t, e ) {
					console.log( j.responseText );
				}
			});
		});
	});
})(jQuery);
