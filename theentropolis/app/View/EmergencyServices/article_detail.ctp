<div class="top-grey-strip-bg search-wrap margin-bottom">
    <div class="container">
        <div class="adjust-height">
			<?php echo $this->element('search_article_elements'); ?>
		</div>
    </div>
</div>
<div id="emergency-services" class="container margin-bottom">			
	<div class="row article">
		<div class="col-md-8">
			<div class="content-block help-topics">
				<div class="article-detail clearfix text-orange">

					<h5><?php echo $articleInfo['HelpTopic']['topic']?></h5>
					<p> 
						<?php if($articleInfo['HelpTopic']['topic_image'] !='') {?>
                            <img src="<?php echo $this->Html->url('/'). $this->Image->resize(IMG_PATH."upload/".$articleInfo['HelpTopic']['topic_image'], 240, 180, false);?>" id="advice_uploaded_image" alt=""  class="img-thumbnail right top"/>
                        <?php } else {?>                        
                        <img   id="advice_uploaded_image" src="<?php echo IMG_PATH?>img/no_image.png" width="100" height="100" alt="" class="img-thumbnail right top">
                        <?php }?>
                                                    
                        <?php echo $articleInfo['HelpTopic']['topic_details']?></p>
				</div>
				
				
				
			</div>
		</div>
		<div class="col-md-4 text-orange">
		  <h4>Help Topics</h4>
		 <?php echo $this->element('article_box_elements',array('articleList'=>$articleData)); ?>
                            <h4 class="capitalize">FAQs</h4>
                         <?php echo $this->element('faq_box_elements',array('faqList'=>$faqlist)); ?>
		</div>
	</div>		
</div>
		