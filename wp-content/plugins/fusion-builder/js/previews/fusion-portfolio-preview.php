<script type="text/template" id="fusion-builder-block-module-portfolio-preview-template">
	<h4 class="fusion_module_title"><span class="fusion-module-icon {{ fusionAllElements[element_type].icon }}"></span>{{ fusionAllElements[element_type].name }}</h4>
	<?php printf( esc_html__( 'layout = %s', 'fusion-builder' ), '{{ params.layout }}' ); ?>
	<br />

	<#
console.log(params.cat_slug);
	var categories = ( null === params.cat_slug || '' === params.cat_slug ) ? 'All' : params.cat_slug; #>
	<?php printf( esc_html__( 'categories = %s', 'fusion-builder' ), '{{ categories }}' ); ?>

</script>
