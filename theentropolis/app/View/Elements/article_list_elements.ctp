
<?php $this->Paginator->options(array('update'=> '#article-listing','before' => $this->Js->get('#spinner')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#spinner')->effect('fadeOut', array('buffer' => false))));?>
    <?php
// so we use the paginator object the shorter way.
// instead of using '$this->Paginator' everytime, we'll use '$paginator'
//$paginator = $this->Paginator;
 
if(!empty($articles)){
 
   ?>	 <?php
         
        // loop through the user's records
        $count = 1;
						
        foreach( $articles as $article ){
            ?>
                <div class="article-listing clearfix">
							<h5><?php echo $article['HelpTopic']['topic']?></h5>
							<p><?php echo $article['HelpTopic']['topic_details']?></p>							
							<a href="<?php echo Router::url(array('controller' => 'EmergencyServices', 'action' => 'articleDetail',$article['HelpTopic']['id'])) ?>" class="anchor-right">Read More</a>
						</div><?php
    
     
}
}
 
// tell the user there's no records found
else{
    echo "No Article found.";
}
?>
                                       <?php if($articleCount > 5){
 
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