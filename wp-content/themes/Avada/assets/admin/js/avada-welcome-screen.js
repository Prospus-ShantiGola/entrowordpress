jQuery( document ).ready( function( e ) {
	jQuery( '.avada-admin-toggle-heading' ).on( 'click', function() {
		jQuery( this ).parent().find( '.avada-admin-toggle-content' ).slideToggle( 300 );

		if ( jQuery( this ).find( '.avada-admin-toggle-icon' ).hasClass( 'dashicons-plus' ) ) {
			jQuery( this ).find( '.avada-admin-toggle-icon' ).removeClass( 'dashicons-plus' ).addClass( 'dashicons-minus' );
		} else {
			jQuery( this ).find( '.avada-admin-toggle-icon' ).removeClass( 'dashicons-minus' ).addClass( 'dashicons-plus' );
		}

	});
});
