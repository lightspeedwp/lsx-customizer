/*
 * lsx-customizer-admin.js
 */

( function( $ ) {
	
	// Update site colours...
	var style = $( '#lsx-color-scheme-css' );

	if ( ! style.length ) {
		style = $( 'body' ).append( '<style type="text/css" id="lsx-color-scheme-css" />' ).find( '#lsx-color-scheme-css' );
	}

	// Colour Scheme CSS.
	wp.customize.bind( 'preview-ready', function() {
		wp.customize.preview.bind( 'update-color-scheme-css', function( css ) {
			style.html( css );
		} );
	} );

} )( jQuery );
