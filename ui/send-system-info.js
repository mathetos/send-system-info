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
                data : 'action=regenerate_url&security='+systemInfoAjax.ajax_nonce,
				success : function( response ) {
                    $( '.ssi-url-text' ).addClass( 'generate' );
				    $( '.ssi-url-text' ).val( response );
					$( '.ssi-url-text-link' ).attr( 'href', response );
                    setTimeout(function () {
                        $( '.ssi-url-text' ).removeClass( 'generate' );
                    }, 1000);

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
                data : 'action=delete_ssi_url&security='+systemInfoAjax.ajax_nonce,
                success : function( response ) {
                    $( '.ssi-url-text' ).addClass( 'delete' );
                    $( '.ssi-url-text' ).val('');
                    $( '.ssi-url-text-link' ).attr( 'href', '' );
                    setTimeout(function () {
                        $( '.ssi-url-text' ).removeClass( 'delete' );
                    }, 1000);
                },
                error : function( j, t, e ) {
                    console.log( "Send System Info Error: " + j.responseText );
                }
            });
        });
	});
})(jQuery);
