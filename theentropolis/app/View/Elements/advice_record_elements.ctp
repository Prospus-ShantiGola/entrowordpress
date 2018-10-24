<style>
    #table-<?php echo $tabID?> tr{ display:none;
}
</style>

<?php

if (!empty($adviceList)) {
    ?>
<table class="table table-striped table-condensed" id="table-<?php echo $tabID?>" >
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Posted By</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Rating</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
    <?php foreach ($adviceList as $conadList) {
        ?>

                                <tr>
                                    <td><?php echo date("M j, Y", strtotime($conadList['Advice']['advice_decision_date'])); ?></td>
                                    <td><?php echo $this->User->userName($conadList['ContextRoleUser']['User']['id']); ?></td>
                                    <td><?php echo $this->Eluminati->text_cut($conadList['Advice']['advice_title'], $length = 10, $dots = true); ?></td>
                                    <td><?php echo nl2br($this->Eluminati->text_cut($conadList['DecisionType']['decision_type']."|".$conadList['Category']['category_name'], $length = 10, $dots = true))  ?></td>
                                    
                                    <td><?php echo $this->Rating->getRating($conadList['Advice']['id']); ?> / 10<br>

                                        
                                         </td>
                                    <td>
                                        <a href="<?php echo Router::url(array('controller' => 'Advices', 'action' => 'viewAndRateAdvice', $conadList['Advice']['id'])) ?>"><i class="fa fa-eye"></i></a>
                                        <?php if ($conadList['ContextRoleUser']['User']['id'] == $this->Session->read('user_id')) { ?> <a href="#edit-advice-<?php echo $conadList['Advice']['id']; ?>" data-toggle="modal" data-target="#edit-advice-<?php echo $conadList['Advice']['id']; ?>"><i class="fa fa-pencil"></i></a> <?php } ?>
                                    </td>
                                </tr>
                                <?php echo $this->element('edit_advice_elements', array('adviceData'=>$conadList))?>
                            <?php
                            }
                        ?>
<?php } ?>
            </tbody>
                </table>                       
                                <?php  if(empty($adviceList)) {  ?>
        <table class="table table-striped table-condensed">
              <tbody><tr><td>No records found.</td></tr>
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
    </script>