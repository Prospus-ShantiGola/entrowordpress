<style>
    #table-<?php echo $tabID?> tr{ display:none;
}
</style>

<?php
//pr($conceptAdviceList);
if (!empty($adviceList)) {
    ?>

<form class="" novalidate id="form-<?php echo $tabID?>" name="form-<?php echo $tabID?>" role="form" method="post" action="<?php echo $this->webroot ?>admin/advices">
    <button type="submit" name="submit" class="btn search-bar-button1 delete-advice" disabled>Delete Selected</button>  
    <input type="hidden" class="form-control select-tab-delete" name="decision_type" id="select-tab-delete" value="<?php echo (!isset($this->request->data['decision_type'])) ? 1 : $this->request->data['decision_type'] ?>">
     
<table class="table table-striped table-condensed advice_management admin-advice" id="table-<?php echo $tabID?>" >
                    <thead>
                        <tr>
                            
                            <th>Date</th>
                            <th>Posted By</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Rating</th>
                            <th>View</th>
                            <th>Select</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php foreach ($adviceList as $conadList) {
        ?>

                                <tr>
                                   
                                    <td><?php echo date("M j, Y", strtotime($conadList['Advice']['advice_decision_date'])); ?></td>
                                    <td><?php echo $this->User->userName($conadList['ContextRoleUser']['User']['id']); ?></td>
                                   <td><?php echo $this->Eluminati->text_cut($conadList['Advice']['advice_title'], $length = 20, $dots = true); ?></td>
                                    <td><?php echo nl2br($this->Eluminati->text_cut($conadList['DecisionType']['decision_type']."|".$conadList['Category']['category_name'], $length = 5, $dots = true))  ?></td>
                                    
                                    <td><?php echo $this->Rating->getRating($conadList['Advice']['id']); ?> / 10

                                        
                                    </td>
                                    <td>
                                        <a href="<?php echo Router::url(array('controller' => 'Advices', 'action' => 'viewAndRateAdvice', $conadList['Advice']['id'])) ?>"><i class="fa fa-eye"></i></a>
                                    </td>
                                     <td><input  type="checkbox" class="check-hindsight" name="Advices[]" value="<?php echo $conadList['Advice']['id'];?>" ></td>
                                          
                                </tr>
                                <?php //echo $this->element('edit_advice_elements', array('adviceData'=>$conadList))?>
                            <?php
                            }
                        ?>
<?php } ?>
            </tbody>
                </table>    
      <?php  if(!empty($adviceList)) {  ?>
      <div class="align-right margin-top">
    
  </div>
     <?php } ?>
</form>
                                <?php  if(empty($adviceList)) {  ?>
        <table class="table table-striped table-condensed">
              <tbody><tr><td class="no-record">No records found.</td></tr>
          </tbody></table>
      <?php } ?>
                  
<?php if(count($adviceList) >10){?>
<div class="margin-bottom clearfix">
            <button class="btn btn-orange-small margin-top-small large right " id="loadMore-<?php echo $tabID?>">Load More</button>
        </div>
<?php }?>
<script>
    
       $(document).ready(function () {
var limit = 'x'+<?php echo $tabID?>;
var rowCount='size_li_'+<?php echo $tabID?>;

    rowCount = $("#table-<?php echo $tabID?> tr").size();
    limit=10;
    $('#table-<?php echo $tabID?> tr:lt('+limit+')').show();
    $('#loadMore-<?php echo $tabID?>').click(function () {
        limit= (limit+10 <= rowCount) ? limit+10 : rowCount;
        $('#table-<?php echo $tabID?> tr:lt('+limit+')').show();
    });
});

/*---------- Start to handle delete button -------------*/
$(document).ready(function () {
   $('.check-hindsight').click(function(){
       var showThis = 0;
       $('.check-hindsight').each(function(){
           $this = $(this);
           if($this.is(':checked', true)){
               showThis = 1;
               return false;
           }
           else{
               showThis = 0;
           }
       });
       
       if(showThis == 1){

           $('.delete-advice').prop('disabled', false).css({opacity:'1'});
       }
       else{
           $('.delete-advice').prop('disabled', true).css({opacity:'0.2'});
       }
       
   });
});
/*---------- End to handle delete button -------------*/
    </script>