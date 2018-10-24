
<?php $this->Paginator->options(array('update'=> '#accordion','before' => $this->Js->get('#spinner')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#spinner')->effect('fadeOut', array('buffer' => false))));?>
    <?php
// so we use the paginator object the shorter way.
// instead of using '$this->Paginator' everytime, we'll use '$paginator'
//$paginator = $this->Paginator;
 
if(!empty($faqs)){
 
   ?>	 <?php
        $pageNum = 1;
        if(isset($this->params['named']['page'])){
           $pageNum = $this->params['named']['page'];   
        }
        
        // loop through the user's records
        $count = 5*($pageNum-1)+1;
						
        foreach( $faqs as $faq ){
            ?>
                                                    
                                                   <div class=" panel-default">
							    <div class="panel-heading clearfix">
							      <h4 class="panel-title">
							        <a data-toggle="collapse" data-parent="#accordion" href="#collapse-<?php echo $faq['Faq']['id']?>">
							        	<span class="count"><?php echo $count;?></span>
							          	<span  class="count-title"><?php echo $faq['Faq']['question']?></span>
							        </a>
							      </h4>
							    </div>
                                                       <?php if($selectedfaqs==''){?>
							    <div id="collapse-<?php echo $faq['Faq']['id']?>" class="panel-collapse collapse <?php echo ($count==1) ? 'in' : '' ?>"><?php } else {?> <div id="collapse-<?php echo $faq['Faq']['id']?>" class="panel-collapse collapse <?php echo ($faq['Faq']['id']==$selectedfaqs) ? 'in' : '' ?>">
                                                                <?php }?>
							      	<div class="panel-body"><?php echo $faq['Faq']['answers']?></div>
							    </div>
							</div> 
                                                    <?php
    $count++;
     
}
}
 
// tell the user there's no records found
else{
    echo "No Faq found.";
}
?>
                                       <?php if($faqCount > 5){
 
   ?>
    <div class="pagination pagination-sm custom-page"><?php
echo $this->Paginator->prev( __('<< Prev'), array(), null, array('class' => 'prev disabled pagination pagination-sm'));
echo $this->Paginator->numbers(array('separator' => ''));
echo $this->Paginator->next(__('Next >>'), array(), null, array('class' => 'next disabled'));
echo $this->Js->writeBuffer();
?></div>
   <?php }?>
<script>
    function deleteThis(recordID){
        
        $("#deleteRecordId").val(recordID);
       }
    function confirmDelete(){
         jQuery.ajax({
            type: 'POST',
            url: "<?php echo Router::url(array('controller' => 'articles', 'action' => 'deleteRecord')) ?>",
            data: {recordID:$("#deleteRecordId").val()},
            success: function(resp) {
                    //$("#delete-user").modal('hide');
                   $.ajax({                    
    url:'<?php echo Router::url(array('controller' => 'articles', 'action' => 'index')) ?>',
    type:"POST",                                        
    data:{},
    //dataType:'text',
    success: function(data) {
        $('#table-section').html(data);
    }
});
               
            }
        });
        
    }
    
    </script>