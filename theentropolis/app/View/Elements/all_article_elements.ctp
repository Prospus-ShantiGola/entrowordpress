
<?php
$pageNum = 1;
 if(isset($this->params['named']['page'])){
    $pageNum = $this->params['named']['page'];   
 }

$this->Paginator->options(array('update'=> '#table-section','before' => $this->Js->get('#spinner')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#spinner')->effect('fadeOut', array('buffer' => false))));?>
    <?php
// so we use the paginator object the shorter way.
// instead of using '$this->Paginator' everytime, we'll use '$paginator'
//$paginator = $this->Paginator;
 
if($articles){
 
   ?> <input type="hidden" class="currentNumPage" value="<?php echo $pageNum;?>">
<table class="table table-striped table-hover article-table action-table">
					<thead>
					    <tr>
							<th>S.No</th>
							<th>Title</th>
							<th>Description</th>
							<th>Image</th>
							<th>Actions</th>
						</tr>
					</thead>
					
				
    
    <?php
         
        // loop through the user's records
        $count = 1;
			$indexer = $perPageLimit*($pageNum-1);				
        foreach( $articles as $article ){
            $indexer++;
              if($article['HelpTopic']['topic_image']!='') {
                 $imagePath="upload/".$article['HelpTopic']['topic_image'];
 } else {
                                                         $imagePath="img/no_image.png";
                                                     }
                                                     $imagePath =$this->Html->url('/'). $this->Image->resize(IMG_PATH.$imagePath, 100, 100, false);
                                                     $id = $article['HelpTopic']['id'];
            echo "<tr>";
                echo "<td>{$indexer}</td>";
                echo "<td>{$article['HelpTopic']['topic']}</td>";
                echo "<td>".$this->Common->limit_words($article['HelpTopic']['topic_details'],20)."</td>";
                 echo "<td><div class='article-img'><img src='{$imagePath}' alt=''></div></td>";
                echo "<td><div class='actions'><a href='articles/editHelpTopic/{$article['HelpTopic']['id']}'>Edit</a><a href='javascript:void(0);' onclick='deleteThis({$article['HelpTopic']['id']})'class='delete-article' data-id = '$id'>Delete</a></div></td>";
            echo "</tr>";
            $count++;
        }
         
    echo "</table>";
 
    // pagination section
    
     
}
 
// tell the user there's no records found
else{
    echo "No Article found.";
}
?>
                                       <?php if($articleCount > 10){
 
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
   
jQuery(document).ready(function(){

     jQuery("body").on("click",'.delete-article',function(){
        var obj = jQuery(this);

       // var eluminati_id = jQuery(this).data('id');
        //var page_title = jQuery(this).closest ('tr').find('.page-title').attr('value'); 
        bootbox.dialog({
                    message: "Are you sure delete this article?",            
                    buttons: {
                        success: {
                            label: "Yes",
                            className: "btn-black",
                            callback: function() {
                               // alert(obj.data('id'));
                              jQuery.ajax({
                                    type: 'POST',
                                    url: "<?php echo Router::url(array('controller' => 'articles', 'action' => 'deleteRecord')) ?>",
                                    data: {recordID:obj.data('id')},
                                    success: function(resp) {
                                            //$("#delete-user").modal('hide');
                                           $.ajax({                    
                            url:'<?php echo Router::url(array('controller' => 'articles', 'action' => 'index','page'=>$pageNum)) ?>',
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
                        },
                        danger: {
                            label: "No",
                            className: "btn-black"                   
                        }

                    }
                });
          
     });
});

</script>