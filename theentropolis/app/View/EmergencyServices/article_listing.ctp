<div class="top-grey-strip-bg margin-bottom">
    <div class="container">
        <div class="page-title">
           Help Topics
        </div>
    </div>
</div>
<div id="emergency-services" class="container margin-bottom">
			
			<div class="row article">
				<div class="col-md-8">
					<div class="search-wraps manage-width helop-topic">
								 <?php echo $this->element('search_article_elements'); ?>
							</div>
					<div class="content-block help-topics text-orange" id="article-listing"> 						
						 <?php echo $this->element('article_list_elements'); ?>				
					</div>
				</div>
				<div class="col-md-4 text-orange">
                    <h4>Help Topics</h4>
				 <?php echo $this->element('article_box_elements',array('articleList'=>$articleData)); ?>
				 <div class="clearfix text-orange"></div>
                    <h4 class="capitalize">FAQs</h4>
                    <?php echo $this->element('faq_box_elements',array('faqList'=>$faqlist)); ?>
				</div>
			</div>		
			
		</div>