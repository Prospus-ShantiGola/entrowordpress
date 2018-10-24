<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<?php if ( 'Top' != Avada()->settings->get( 'header_position' ) || ( ! in_array( Avada()->settings->get( 'header_layout' ), array( 'v4', 'v5' ) ) ) ) : ?>
	<?php get_template_part( 'templates/menu-mobile-modern' ); ?>
<?php endif; ?>

<?php $mobile_menu_text_align = ( 'right' == Avada()->settings->get( 'mobile_menu_text_align' ) ) ? ' fusion-mobile-menu-text-align-right' : ''; ?>

<nav class="fusion-mobile-nav-holder<?php echo $mobile_menu_text_align; ?>"></nav>

<?php if ( has_nav_menu( 'sticky_navigation' ) && 'Top' == Avada()->settings->get( 'header_position' ) ) : ?>
	<nav class="fusion-mobile-nav-holder<?php echo $mobile_menu_text_align; ?> fusion-mobile-sticky-nav-holder"></nav>
<?php endif;

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
