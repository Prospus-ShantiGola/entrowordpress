<script type="text/template" id="fusion-builder-block-module-recent-posts-preview-template">
	<h4 class="fusion_module_title"><span class="fusion-module-icon {{ fusionAllElements[element_type].icon }}"></span>{{ fusionAllElements[element_type].name }}</h4>
	<?php printf( esc_html__( 'layout = %s', 'fusion-builder' ), '{{ params.layout }}' ); ?>
	<br />
	<?php printf( esc_html__( 'columns = %s', 'fusion-builder' ), '{{ params.columns }}' ); ?>
	<br />

	<# var categories = ( params.cat_slug === null ) ? 'All' : params.cat_slug; #>
	<?php printf( esc_html__( 'categories = %s', 'fusion-builder' ), '{{ categories }}' ); ?>

</script>
