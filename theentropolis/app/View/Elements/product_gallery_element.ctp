<?php if($action =='View'){?>
<div class="kd-img-gallery kd-gallery">
	<div class="kd-box">
		<?php if($gallery['gallery_image_path']!='')
		{  ?>
	 <img src="<?php echo $this->Html->url('/', true) .$gallery['gallery_image_path']; ?>" alt="">
	 <?php }else
	 {?>
<input type="" name="" id="product_gallery_upload" class="galleryimg_upload" data-multiple-caption="{count} files selected" multiple=""  data-actual = "[product_gallery][]" data-type ="product_gallery">
                                                                            <label for="product_gallery_upload"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label> 
	<?php  } ?>
	</div>
</div>
<?php }
else if($action=='Edit')
{?>
	 <input type="file" name="fileToUploadAdd[]" id="logo_image_upload" class="atch-new galleryimg_upload" data-multiple-caption="{count} files selected" multiple="" data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "logo_image">
                                                            
                                                            <label for="logo_image_upload"> <div class="img-section row-wrap"><img src="http://localhost/trepicity/upload/thumb_1516709378Jellyfish.jpg"><input type="hidden" name="data[KidBusinessProfile][logo_image]" value="upload/thumb_1516709378Jellyfish.jpg"></div></label>
<?php }
else
{
	
}
 ?>