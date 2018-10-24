<div class="new-dashboard-wrap advice-wrap">
                 

    <div class="my-advice">
    <h2 class="orange">My Questions</h2>
    <div class = 'new-dashboard-table' >
         <?php if(!empty($question)){ ?>
        <table class="table table-striped table-condensed my_decisionbank my_challenge">
       
            <thead>
                <tr>
                    <th>Date</th>
                   
                    <th>Title</th>
                    <th>Category</th>
                     <th>Posted By</th>
                   
                </tr>
            </thead>        
            <tbody>
                <?php  

                foreach ($question as $question_detail) {?>
                <tr>
                     <td><?php echo date('M j, Y', strtotime($question_detail['Discussion']['added_on']));?></td>
                 
                    <td><?php echo $this->Eluminati->text_cut($question_detail['Discussion']['question_title'], $length =20 , $dots = true); ?> </td>
                    <td><?php echo $question_detail['Category']['category_name'];?></td>
                       <td> <?php echo  $this->Session->read('user_name');    ?> </td>
                    
                </tr>
                <?php }?>
            </tbody>
        </table>
          <?php }else {echo 'No records found.';} ?>
    </div>
    <?php 
     if($totalquestion>5)
        {?> <div class="right">
            <a href = 'question' target = "_Blank" class = "btn btn btn-orange-small">View All</a>
            </div>
        <?php }?>
    
</div>
</div>