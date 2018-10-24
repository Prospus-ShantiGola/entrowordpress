<?php
$theme_options_style = '';
if ( class_exists( 'Avada' ) ) {
	$theme_options_style = strtolower( Avada()->settings->get( 'title_style_type' ) );
}
?>
<script type="text/template" id="fusion-builder-block-module-title-preview-template">

	<div class="fusion-title-preview">
		<#
		var style_type = ( params.style_type ) ? params.style_type.replace( ' ', '_' ) : 'default';

		if ( 'default' === params.style_type ) {
			style_type = '<?php echo $theme_options_style; ?>';
			style_type = style_type.replace( ' ', '_' );
		}

		if ( /<[a-z][\s\S]*>/i.test( params.element_content ) ) {
			var shortcode_content = jQuery(params.element_content).text();
		} else {
			var shortcode_content = params.element_content;
		}

		var align = 'align-' + params.content_align;
		#>

		<span class="{{ style_type }}" style="border-color: {{ params.sep_color }};"><sub class="title_text {{ align }}">{{ shortcode_content }}</sub></span>
	</div>

</script>
