jQuery( document ).ready( function() {

	// Combine inline styles for body tag
	jQuery( 'body' ).each( function() {
		var combinedStyles = '<style type="text/css">';

		jQuery( this ).find( 'style' ).each( function() {
			combinedStyles += jQuery( this ).html();
			jQuery( this ).remove();
		});

		combinedStyles += '</style>';

		jQuery( this ).prepend( combinedStyles );
	});
});
