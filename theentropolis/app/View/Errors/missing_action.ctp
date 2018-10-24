<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Errors
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
$this->layout = 'entropolis_page_layout';
?>

<div class="error error_404">
	<?php echo __d('cake', '<h3>NOT FOUND</h3>'); ?>
        <h4><?php echo $name; ?></h4>
	
</div>
<script>
$(document).ready(function(){
    $('.error_404').height($(window).height() - ($('.error_header').outerHeight() + $('.footer').outerHeight()))
})
</script>

