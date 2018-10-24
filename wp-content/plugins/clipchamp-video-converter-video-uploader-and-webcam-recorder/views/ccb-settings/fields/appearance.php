<?php
/*
* Appearance Section
*/
?>

<?php if ( 'ccb_field-label' == $field['label_for'] ) : ?>

    <input id="<?php esc_attr_e( 'ccb_field-label' ); ?>" name="<?php esc_attr_e( 'ccb_settings[appearance][field-label]' ); ?>" class="regular-text" value="<?php esc_attr_e( $settings['field-label'] ); ?>" />
    <p class="description">The Clipchamp button label. This is the text that appears in the button, which is placed into the wrapper element.</p>

<?php endif; ?>

<?php if ( 'ccb_field-size' == $field['label_for'] ) : ?>
    <select id="<?php esc_attr_e( 'ccb_field-size' ); ?>" name="<?php esc_attr_e( 'ccb_settings[appearance][field-size]' ); ?>">
        <?php foreach ($default_sets['sizes'] as $size ) : ?>
            <option value="<?php esc_attr_e( $size ); ?>" <?php selected( $settings['field-size'], $size ); ?>><?= ucfirst( $size ); ?></option>
        <?php endforeach; ?>
    </select>
    <p class="description">The size of the Clipchamp button. We offer four sizes to meet any website's design.</p>

<?php endif; ?>

<?php if ( 'ccb_field-title' == $field['label_for'] ) : ?>

    <input id="<?php esc_attr_e( 'ccb_field-title' ); ?>" name="<?php esc_attr_e( 'ccb_settings[appearance][field-title]' ); ?>" class="regular-text" value="<?php esc_attr_e( $settings['field-title'] ); ?>" />
    <p class="description">The title of the Clipchamp popup. This is the text that appears at the top of the popup iframe, which is shown after the user clicks the Clipchamp button.</p>

<?php endif; ?>

<?php if ( 'ccb_field-logo' == $field['label_for'] ) : ?>

    <input id="<?php esc_attr_e( 'ccb_field-logo' ); ?>" name="<?php esc_attr_e( 'ccb_settings[appearance][field-logo]' ); ?>" class="regular-text media-uploader" value="<?php esc_attr_e( $settings['field-logo'] ); ?>" />
    <input id="upload-button" type="button" class="button" value="Choose Logo" />
    <p class="description">The URL of the logo image for the Clipchamp popup. This is an image that is shown in the top-left corner of the iframe.</p>

<?php endif; ?>

<?php if ( 'ccb_field-color' == $field['label_for'] ) : ?>

    <input id="<?php esc_attr_e( 'ccb_field-color' ); ?>" name="<?php esc_attr_e( 'ccb_settings[appearance][field-color]' ); ?>" class="color-field" value="<?php esc_attr_e( $settings['field-color'] ); ?>" />
    <p class="description">Determines the color of the Clipchamp button the background of the popup's title bar and other graphical elements. Can be a color name (such as blue, a hex-encoded color code (such as <code>#3300cc</code>), or an RGB-encoded color (such as <code>rgba(78,24,212,0.5)</code>).</p>

<?php endif; ?>

<?php if ( 'ccb_field-style-url' == $field['label_for'] ) : ?>

    <input id="<?php esc_attr_e( 'ccb_field-style-url' ); ?>" name="<?php esc_attr_e( 'ccb_settings[style][field-style-url]' ); ?>" class="regular-text" value="<?php esc_attr_e( $style['field-style-url'] ); ?>" />
    <p class="description">The URL of a custom CSS stylesheet that is loaded after the Clipchamp API's default CSS styling. Must not be used in combination with the Stylesheet setting.</p>

<?php endif; ?>

<?php if ( 'ccb_field-style-text' == $field['label_for'] ) : ?>

    <textarea id="<?php esc_attr_e( 'ccb_field-style-text' ); ?>" name="<?php esc_attr_e( 'ccb_settings[style][field-style-text]' ); ?>" rows="10" class="codemirror"><?php esc_attr_e( $style['field-style-text'] ); ?></textarea>
    <p class="description">A custom CSS stylesheet, given as a string. The custom CSS stylesheet is instantiated after the Clipchamp API's default styling. Must not be used in combination with the Stylesheet URL setting.</p>

<?php endif; ?>

<?php if ( 'ccb_field-theme' == $field['label_for'] ) : ?>

    <select id="<?php esc_attr_e( 'ccb_field-theme' ); ?>" name="<?php esc_attr_e( 'ccb_settings[style][field-theme]' ); ?>">
        <?php foreach ($default_sets['themes'] as $theme => $themeLabel ) : ?>
            <option value="<?php esc_attr_e( $theme ); ?>" <?php selected( $style['field-style-url'], $theme ); ?>><?php esc_attr_e( $themeLabel ) ?></option>
        <?php endforeach; ?>
    </select>
    <p class="description">The theme of the Clipchamp popup. You can see a preview of the available themes in the <a href="https://clipchamp.com/en/api-setup/install" target="_blank">API setup wizard</a>. Certain themes might not work with the primary color set. <strong>WARNING:</strong> Overwrites Stylesheet URL and Stylesheet Text settings!</p>

<?php endif; ?>