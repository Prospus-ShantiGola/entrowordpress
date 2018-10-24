jQuery( document ).ready( function() {
	var i,
	    w,
	    imgs = document.getElementsByTagName( 'img' );

	for ( i = 0; i < imgs.length; i++ ) {
		w = imgs[i].getAttribute( 'width' );
		imgs[i].removeAttribute( 'width' );
		imgs[i].removeAttribute( 'height' );
	}
});
