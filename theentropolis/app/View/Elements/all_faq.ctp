
<?php 
$pageNum = 1;
 if(isset($this->params['named']['page'])){
    $pageNum = $this->params['named']['page'];   
 }
$this->Paginator->options(array('update'=> '#postsPaging','before' => $this->Js->get('#spinner')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#spinner')->effect('fadeOut', array('buffer' => false))));?>
    <?php
// so we use the paginator object the shorter way.
// instead of using '$this->Paginator' everytime, we'll use '$paginator'
//$paginator = $this->Paginator;
 
if($faq){
 ?><input type="hidden" class="currentNumPage" value="<?php echo $pageNum;?>"><?php
    //creating our table
    echo "<table class='table table-striped table-hover faq-table action-table' id='faq-table'>";
 
        // our table header, we can sort the data user the paginator sort() method!
        echo "<thead><tr>";
         
            // in the sort method, ther first parameter is the same as the column name in our table
            // the second parameter is the header label we want to display in the view
            echo "<th>S.No</th>";
            echo "<th>Question</th>";
            echo "<th>Answer</th>";
            echo "<th>Actions</th>";
        echo "</tr></thead>";
         
        // loop through the user's records
       
			$indexer = $perPageLimit*($pageNum-1);			
        foreach( $faq as $faqs ){
            $id = $faqs['Faq']['id'];
            $indexer++;
            echo "<tr id='{$faqs['Faq']['id']}'>";
                echo "<td>{$indexer}</td>";
                echo "<td>{$faqs['Faq']['question']}</td>";
                echo "<td>".$this->Common->limit_words($faqs['Faq']['answers'],20)."</td>";
                echo "<td><div class='actions'><a href='faqs/editFaq/{$faqs['Faq']['id']}'>Edit</a><a href='javascript:void(0)' onclick='deleteThis({$faqs['Faq']['id']})' data-id='$id' class = 'delete-user'>Delete</a></div></td>";
            echo "</tr>";
           
        }
         
    echo "</table>";
 
    // pagination section
    
     
}
 
// tell the user there's no records found
else{
    echo "No Faq found.";
}
?>
  <?php if($faqCount > 20){
 
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
//     function confirmDelete(){
        
//          jQuery.ajax({
//             type: 'POST',
//             url: "<?php echo Router::url(array('controller' => 'faqs', 'action' => 'deleteRecord')) ?>",
//             data: {recordID:$("#deleteRecordId").val()},
//             success: function(resp) {
//                     //$("#delete-user").modal('hide');
//                    $.ajax({                    
//     url:'<?php echo Router::url(array('controller' => 'faqs', 'action' => 'index','page'=>$pageNum)) ?>',
//     type:"POST",                                        
//     data:{},
//     //dataType:'text',
//     success: function(data) {
//         $('#postsPaging').html(data);
//     }
// });
               
//             }
//         });
        
//     }
    
jQuery(document).ready(function(){

     jQuery("body").on("click",'.delete-user',function(){
        var obj = jQuery(this);

       // var eluminati_id = jQuery(this).data('id');
        //var page_title = jQuery(this).closest ('tr').find('.page-title').attr('value'); 
        bootbox.dialog({
                    message: "Are you sure delete this?",            
                    buttons: {
                        success: {
                            label: "Yes",
                            className: "btn-black",
                            callback: function() {
                               // alert(obj.data('id'));
                             jQuery.ajax({
                            type: 'POST',
                            url: "<?php echo Router::url(array('controller' => 'faqs', 'action' => 'deleteRecord')) ?>",
                            data: {recordID: obj.data('id')},
                            success: function(resp) {
                                    //$("#delete-user").modal('hide');
                                   $.ajax({                    
                    url:'<?php echo Router::url(array('controller' => 'faqs', 'action' => 'index','page'=>$pageNum)) ?>',
                    type:"POST",                                        
                    data:{},
                    //dataType:'text',
                    success: function(data) {
                        $('#postsPaging').html(data);
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
    <script type="text/javascript">

$(document).ready(function(){
    $("#faq-table").tableDnD({
    onDrop: function(table, row) {
        jQuery.ajax({
            type: 'POST',
            url: "<?php echo Router::url(array('controller' => 'faqs', 'action' => 'sortRecord')) ?>",
            data: $.tableDnD.serialize(),
            success: function(resp) {
                 $.ajax({                    
    url:'<?php echo Router::url(array('controller' => 'faqs', 'action' => 'index')) ?>',
    type:"POST",                                        
    data:{},
    //dataType:'text',
    success: function(data) {
        $('#postsPaging').html(data);
    }
});
            }
        });
    }
});
	
	
});
</script>