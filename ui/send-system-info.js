(function($) {
	$( document ).ready( function() {
		/**
		 * Generate new Remote View URL
		 * and display it on the admin page
		 */
		$( 'input[name="generate-new-url"]' ).on( 'click', function( event ) {
			event.preventDefault();
			$.ajax({
				type : 'post',
				dataType : 'json',
				url : systemInfoAjax.ajaxurl,
				data : { action : 'regenerate_url' },
				success : function( response ) {
					$( '.ssi-url-text' ).val( response );
					$( '.ssi-url-text-link' ).attr( 'href', response );
				},
				error : function( j, t, e ) {
					console.log( "Send System Info Error: " + j.responseText );
				}
			});
		});

        /**
         * Delete the SSI URL
         */

        $( 'input[name="delete-ssi-url"]' ).on( 'click', function( event ) {
            event.preventDefault();
            $.ajax({
                type : "post",
                dataType : "json",
                url : systemInfoAjax.ajaxurl,
                data : { action : 'delete_ssi_url' },
                success : function( response ) {
                    $( '.ssi-url-text' ).val('');
                    $( '.ssi-url-text-link' ).attr( 'href', '' );
                },
                error : function( j, t, e ) {
                    console.log( "Send System Info Error: " + j.responseText );
                }
            });
        });
	});
})(jQuery);
