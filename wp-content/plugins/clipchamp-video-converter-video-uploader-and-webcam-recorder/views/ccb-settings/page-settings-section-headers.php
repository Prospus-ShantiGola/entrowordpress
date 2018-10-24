<?php if ( 'ccb_section-general' == $section['id'] ) : ?>

	<p>General settings for the Clipchamp button.</p>

<?php elseif ( 'ccb_section-appearance' == $section['id'] ) : ?>

	<p>Customize the appearance of the Clipchamp button and popup.</p>

<?php elseif ( 'ccb_section-style' == $section['id'] ) : ?>

    <p>Allows for a detailed visual customization of the Clipchamp API's visual appearance using CSS. A custom CSS stylesheet can be provided as a URL (Stylesheet URL setting) or as CSS declarations string (Stylesheet setting). In both cases, the custom CSS declarations augment, but do not replace the default user interface styling, based on the Bootstrap 3 default styling. That is, the custom CSS styling is layered on top of the existing CSS styling, where existing CSS classes can be augmented, CSS properties be added or replaced. Available in the API Business plan. Clipchamp themes available to everyone.</p>

<?php elseif ( 'ccb_section-video' == $section['id'] ) : ?>

	<p>Everything related to the video magic happening.</p>

<?php elseif ( 'ccb_section-posts' == $section['id'] ) : ?>

    <p>Everytime a users uploads a video through the Clipchamp button, a video post (see Clipchamp Videos on the left) will be created. Manage the default settings for these posts here.</p>

<?php elseif ( 'ccb_section-s3' == $section['id'] ) : ?>

	<p>Configuration elements when using Amazon S3 upload target. (<a href="https://blog.clipchamp.com/uploading-videos-from-clipchamp-button-to-aws-s3" target="_blank">configuration instructions for S3</a>)</p>

<?php elseif ( 'ccb_section-azure' == $section['id'] ) : ?>

	<p>Configuration elements when using Microsoft Azure blob storage upload target. (<a href="https://blog.clipchamp.com/uploading-videos-from-clipchamp-button-to-windows-azure" target="_blank">configuration instructions for Azure</a>)</p>

<?php elseif ( 'ccb_section-gdrive' == $section['id'] ) : ?>

	<p>Configuration elements when using Google Drive upload target.</p>

<?php elseif ( 'ccb_section-youtube' == $section['id'] ) : ?>

	<p>Configuration elements when using YouTube upload target.</p>

<?php elseif ( 'ccb_section-dropbox' == $section['id'] ) : ?>

    <p>Configuration elements when using Dropbox upload target.</p>

<?php endif; ?>