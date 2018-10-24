
<div class="col-md-10 content-wraaper">		
    <div class="title dashboard-title challenge-color">
        <h1>Discussion</h1>
        <div class="title-sep-container">
            <div class="title-sep"></div>		
        </div>
    </div>

    <div id="challenge-display">
        <div class="row">
            <div class="col-md-12 judge-challenge challenge-color">
                <div class="col-md-7 hind-sights-form" >
                    <?php //pr($decision_types);
                    foreach($categories as $key=>$category){
                        $catList[$category['Category']['id']] = $category['Category']['category_name'];                        
                    }
                    
                    ?>
                    <?php echo $this->Session->Flash('discussion-form');?>
 <?php echo $this->Form->create('mychallenges', array('url'=>'discussion'));?>    
                               
                    <div class="form-group">
                         <?php echo $this->Form->input('category_id', array('options'=>$decision_types,'id'=>'decision_type_id', 'class'=>'form-control', 'label'=>false));?>
                        <?php //echo $this->Form->input('category_id', array('options'=>$catList, 'id'=>'category_id','class'=>'form-control', 'label'=>false));?>  

                    </div>
                    <div class="form-group">
                        <?php //echo $this->Form->input('sub_category_id', array('options'=>array(''=>'Select Sub-Category'), 'id'=>'sub_category_id','class'=>'form-control', 'label'=>false));?>  
                        <?php echo $this->Form->input('sub_category_id', array('options'=>array(''=>'Select Category'), 'id'=>'category_id','class'=>'form-control', 'label'=>false));?>  
                 </div>
                    <div class="form-group" style="float:left; margin-top: 12px; width: 100%">
                        <?php echo $this->Form->input('question_title', array('id'=>'question_title','class'=>'form-control', 'placeholder'=>'Question Title', 'label'=>false));?>  

                    </div>
                    
                    <div class="form-group" style="float:left; margin-top: 12px; width: 100%">
                        <?php echo $this->Form->textarea('description', array('id'=>'description', 'placeholder'=>'Description', 'class'=>'form-control', 'rows'=>'6', 'label'=>false));?>  

                    </div>
                  <div class="form-group  my_challenge" style="float:left; margin-top: 12px; width: 100%">
                        <?php echo $this->Form->submit('Submit', array('class'=>'btn btn-black'));?>  

                    </div>  
                    											
  <?php echo $this->Form->end();?>                 
                    


            </div>
                
               
            </div>
        </div>



    </div>
</div>
<script type="text/javascript">
    $('body').on('change','#decision_type_id' , function(){
    $.ajax({
        url:'<?php echo Router::url(array('controller'=>'DecisionBanks', 'action'=>'decision_category'));?>',
        data:{
          id:this.value
        },
        type:'get',
        success:function(data){ 
            $('#category_id').html(data);
        }
        
    });
});
</script>    

