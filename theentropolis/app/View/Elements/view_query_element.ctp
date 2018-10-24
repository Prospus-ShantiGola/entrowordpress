
 <?php 
 $perPageLimit;
 $pageNum = 1;
 if(isset($this->params['named']['page'])){
    $pageNum = $this->params['named']['page'];   
 }
 
 $page = '';
 if(isset($pass[0])){
    $page = $pass[0];
 }
 $this->Paginator->options(array('update'=> '#postsPaging','before' => $this->Js->get('#spinner')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#spinner')->effect('fadeOut', array('buffer' => false))));?>
    <div class="table-wrap" id="postsPaging">
        <input type="hidden" class="currentNumPage" value="<?php echo $pageNum;?>">
        <table class="table table-striped table-hover user-table action-table" cellspacing="0" cellpadding="0" width="100%">
            <thead>
                <tr>
                            <th>S.No</th>
                            <th>Full Name</th>
                            <th>Email Id</th>
                         <!--    <th>subje</th> -->
                            <th>Message</th>
                            <th>Queried On</th>
                            <th>Actions</th>
                 </tr>
            </thead>
            <tbody>
                <?php 
         if(count($inquires) > 0){       
                $indexer = $perPageLimit*($pageNum-1);
                foreach ($inquires as $key=>$query_value){
                    $indexer++;
                    $show = 1;
                  
                ?>

                <tr>
                            <td><?php echo $indexer;?></td>
                            <td><?php echo $query_value['Inquire']['name']." ".$query_value['Inquire']['last_name']; ?></td>
                            <td><?php echo $query_value['Inquire']['email_address']; ?></td>
                            <!-- <td><?php echo $query_value['Inquire']['contact_number']; ?></td> -->
                            <td><?php echo $query_value['Inquire']['message']; ?></td>
                            <td><?php echo date("M j, Y",strtotime($query_value['Inquire']['submission_timestamp'])); ?><br><?php echo date("g:i a",strtotime($query_value['Inquire']['submission_timestamp'])); ?></td>
                            <td>
                                <div class="actions">
                                    <a href="javascript:void(0);" data-id = "<?php echo $query_value['Inquire']['id'];?>" class='delete-query'>Delete</a>
                                </div>
                            </td>
                        </tr>
                        



                <?php  
                } 
         }else{
              echo "<tr><td colspan='8'> No records found.</td></tr>";
         }?>

            </tbody>
        </table>
<?php if(count($inquires) > 0){ ?>          
        <div class="pagination pagination-sm custom-page"><?php
        echo $this->Paginator->prev( __('<< Prev'), array(), null, array('class' => 'prev disabled pagination pagination-sm'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next(__('Next >>'), array(), null, array('class' => 'next disabled'));
        echo $this->Js->writeBuffer();
        ?></div>
<?php } ?>        
  </div>

  <script type="text/javascript">

 jQuery("body").on("click",'.delete-query',function(){
        var obj = jQuery(this);

        var query_id = jQuery(this).data('id');
        //var page_title = jQuery(this).closest ('tr').find('.page-title').attr('value'); 
        bootbox.dialog({
                    message: "Are you sure delete this query ?",            
                    buttons: {
                        success: {
                            label: "Yes",
                            className: "btn-black",
                            callback: function() {
                                deleteQuery(obj, query_id);
                            }
                        },
                        danger: {
                            label: "No",
                            className: "btn-black"                   
                        }

                    }
                });
          
     });

 function deleteQuery(obj,query_id)
  {
     currentPageNum = $('.currentNumPage').val();
    jQuery.ajax({
        'type':'POST',
        'url':'deleteQuery',
        'data':
        {
            
            'query_id':query_id
        },
        'success':function(data)
        {
            obj.closest ('tr').remove ();

            jQuery.ajax({
             type:'POST',
             url :'viewQuery/page:'+currentPageNum,
             data:{},
             success:function(res){
                 $('#postsPaging').html(res);
             }
          });
            
        }

    });
  }
  </script>

