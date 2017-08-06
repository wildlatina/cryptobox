/**
 * Wrapper function to safely use $
 */
function cryptoboxWrapper( $ ) {
	var cryptobox = {

		/**
		 * Main entry point
		 */
		init: function () {
			cryptobox.prefix      = 'cryptobox_';
			cryptobox.templateURL = $( '#template-url' ).val();
			cryptobox.ajaxPostURL = $( '#ajax-post-url' ).val();

			cryptobox.registerEventHandlers();
		},

		/**
		 * Registers event handlers
		 */
		registerEventHandlers: function () {
			$( '#example-container' ).children( 'a' ).click( cryptobox.exampleHandler );
		},

		/**
		 * Example event handler
		 *
		 * @param object event
		 */
		exampleHandler: function ( event ) {
			alert( $( this ).attr( 'href' ) );

			event.preventDefault();
		}
	}; // end cryptobox

	$( document ).ready( cryptobox.init );

} // end cryptoboxWrapper()

cryptoboxWrapper( jQuery );
