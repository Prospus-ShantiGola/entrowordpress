<div class="page-loading" style="color:red"><?php echo $this->Html->image('loading-upload.gif');?></div>

<div class="col-md-10 content-wraaper" id="ask-Question">
    <div class="sage-dash-wrap">
        <h1 class="roboto_light">ASK|ENTROPOLIS</h1>
        <div class="ask-wrap">
            <?php echo $this->Form->create('AskQuestion', array('id'=>"discussion-form-data"));?>     
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="">
                            <div class="input select required">
                                <?php echo $this->Form->input('category_id', array('options'=>$decisiontypes,'id'=>'decision_type', 'class'=>'form-control', 'label'=>false));?>
                                <!--   <select required="required" class="form-control" id="country" name="data[User][country_id]">
                                    <option value="">Category</option>
                                    </select> -->
                            </div>
                        </label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="">
                            <div class="input select required"style="min-width: 170px;">
                                <!--   <select required="required" class="form-control" id="country" name="data[User][country_id]">
                                    <option value="">Sub - Category</option>
                                    </select> -->
                                <?php echo $this->Form->input('sub_category_id', array('options'=>array(''=>'Sub-Category'), 'id'=>'categoryid','class'=>'form-control', 'label'=>false));?>  
                            </div>
                        </label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <?php echo $this->Form->input('question_title', array('id'=>'question_title','class'=>'form-control', 'placeholder'=>'Title', 'label'=>false,'maxlength'=>'500'));?>  
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <?php echo $this->Form->input('description', array('id'=>'description', 'placeholder'=>'Your question', 'class'=>'form-control',  'label'=>false,'type'=>'text'));?>
                        <!--  <input type="email" class="form-control" placeholder="Your Question"> -->
                        <!--  <button class="btn Black-Btn">Ask</button> -->
                    </div>
                </div>
                <div class="col-md-1">
                    <?php echo $this->Form->submit('Ask', array('class'=>'btn Black-Btn add-discussion no-loading' ,'div'=>false) );?>
                    <!-- <button class="btn Black-Btn">Ask</button> -->
                    <?php echo $this->Form->end();?>  
                </div>
            </div>
        </div>
        <h1 class="roboto_light page-topic" >YOUR|QUESTIONS
            <?php  if(!empty($data)) {  ?>
            <button type="button" name="delete-btn" class="btn Black-Btn btn-large margin-top-small large right del-btn my_decisionbank delete-hindsight" disabled style="opacity:0.2;">Delete</button>
            <?php } ?>
        </h1>
        <div class="categories-wrapper clearfix ask-ques-wrap">
            <div class="cat-left-col">
                <h3>Category</h3>
                <ul class="nav nav-tabs tabs  setting-tab">
                    <?php foreach($decision_types as $key => $tab_name) { ?> 
                    <?php if(strtoupper($tab_name)==strtoupper('Decision and Hindsight Category')) { ?> 
                    <li class="active"><a href="#all-hindsights" data-toggle="tab" id="all-hindsights-tab" onclick="getListData('all-hindsights','','tab');">All</a></li>
                    <?php } else { $tabname = str_replace(array(' ',',','&'),'',$tab_name);?>
                    <li><a href="#<?php echo $tabname ?>" data-toggle="tab" id="<?php echo $tabname ?>-tab" onclick="getListData('<?php echo $tabname ?>', '<?php echo $key ?>','tab');"><?php echo $tab_name; ?></a></li>
                    <?php } ?>
                    <?php } ?>   
                </ul>
            </div>
            <div class="cat-right-col">
                <form name="loadDateFrm" id="loadDateFrm" method="Post" action="#" >
                    <input type="hidden" name="active_tab_name" id="active_tab_name">
                    <input type="hidden" name="active_tab_id" id="active_tab_id">
                    <input type="hidden" name="active_category_id" id="active_category_id">
                    <input type="hidden" name="active_keyword_search" id="active_keyword_search">
                    <input type="hidden" name="active_user_id" id="active_user_id" value="<?php echo $selected_user_id;?>">
                </form>
                <div class="tab-content-hindsight">
                    <table class="table table-striped ask-table-wrap">
                        <thead>
                            <th><input  type="checkbox" class="check_all" name="" value="" ></th>
                            <th>Sub - Category</th>
                            <th>Date</th>
                            <th>Question</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                    </table>
                    <div  class=""  >
                        <div class="">
                            <div class="">
                                <table class="table table-striped  table-condensed ask-table-wrap ">
                                    <tbody>
                                        <?php  if(!empty($data)) { 
                                          //  pr($data);die;?>
                                        <?php foreach($data as $rec) { ?>
                                        <tr class= "get-question-modal" data-type = "<?php echo $user_type; ?>" data-id = <?php echo $rec['AskQuestion']['id'];?>  data-direction='right'>
                                            <td><input  type="checkbox" class="check-hindsight" name="AskQuestion[]" value="<?php echo $rec['AskQuestion']['id'];?>" ></td>
                                            <td title= "<?php echo $rec['Category']['category_name'];?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td>
                                            <td><?php echo date('M j, Y', strtotime($rec['AskQuestion']['added_on']));?></td>
                                            <td><a><?php echo $this->Eluminati->text_cut($rec['AskQuestion']['description'], $length = 25, $dots = true); ?></a></td>
                                            <td class="<?php echo $rec['AskQuestion']['status'] ; ?>"><?php echo ucfirst($rec['AskQuestion']['status']) ; ?></td>
                                            <td><a >View</a></td>
                                        </tr>
                                        <?php } ?>                         
                                    </tbody>
                                    <?php } else { ?>
                                    <tr>
                                        <td colspan= '7' style = "background-color:#f2f2f2; text-align:center;">No records found.</td>
                                    </tr>
                                    <?php } ?>                 
                                </table>
                            </div>
                            <?php if($total_count>10){?>
                              <div class="margin-bottom clearfix right load-more" id="loadmorebtn">
                                  <button class="btn  btn-orange-small large right" onclick="loadmoredata();">Load More</button>
                              </div>
                            <?php }?>
                        </div>
                    </div>                    
                    
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->element('dashboard_js_element');?>
<script type="text/javascript">
   
    
    function getListData(tabname, decision_type_id, type, load_row)
        { 
          $('.loading').show();  
          if(type == 'tab' || type == 'advance_search')
          {    
               $('#active_tab_name').val(tabname);
               $('#active_tab_id').val(decision_type_id);
               
               if(type == 'tab')
               {    
                   $('#active_category_id').val('');
                   $('#active_keyword_search').val('');
               }
          }
          jQuery.ajax({
               url:'<?php echo $this->webroot?>askQuestions/getquestionlist/',
               data:{
                 'tab_name':tabname,  
                 'decision_type_id':decision_type_id,
                 'fetch_type':type,
                 'category_id':$('#active_category_id').val(),
                 'keyword_search':$('#active_keyword_search').val(),
                 'load_row':load_row,
                 'context_role_user_id':$('#active_user_id').val()
               },
               type:'POST',
               success:function(data){
                   $('.loading').hide();  

                   var dataarr = data.split('#$$#');
                   if(type=='loadmore')
                   {
                      jQuery('.table tbody').append(dataarr[0]); 

                       
                   }
                   else
                   {
                     jQuery('.tab-content-hindsight').html(dataarr[0]);  
                   }    
                 
                   var rowCount = $('.table-condensed >tbody >tr').length;
                   if(dataarr[1] <= rowCount)
                   {
                       $('#loadmorebtn').hide();
                      
                   }
                   else
                   {
                       $('#loadmorebtn').show();
                   }
                    
                     var colHIG = $('.cat-right-col').height();
                       $('.cat-left-col').css({minHeight: colHIG});
                  if((dataarr[1]).trim()!=0)
                  {
                    

                      var total_checked_length = $('.check-hindsight:checked').length;
                     
                      if(total_checked_length ==0)
                      {
                        
                         var html_btn =' YOUR|QUESTIONS <button type="button" name="delete-btn" class="btn Black-Btn btn-large margin-top-small large right del-btn my_decisionbank  delete-hindsight"  style="opacity:0.2;">Delete</button>';  
                      }
                      else
                      { 
                         var html_btn =' YOUR|QUESTIONS <button type="button" name="delete-btn" class="btn Black-Btn btn-large margin-top-small large right del-btn my_decisionbank  delete-hindsight"  >Delete</button>';  
                      }
                     
                      jQuery(".page-topic").html(html_btn);          
                  }
                  else
                  {
                  
                    $('.delete-hindsight').hide();
                    $(".check_all").prop( "checked", false );
                  }
    
                       
                }
               
               
           });
        }
        
        function loadmoredata() { 
           //alert("tab name=> "+$('#active_tab_name').val() + "tab id=> "+$('#active_tab_id').val());
           var tabname = $('#active_tab_name').val();
           var decision_type_id = $('#active_tab_id').val();
           var rowCount = $('.table-condensed >tbody >tr').length;
           getListData(tabname, decision_type_id, 'loadmore', rowCount);
        }
        
    
    $(document).ready(function () {
      $('body').on('click','.check-hindsight',function(e){
          e.stopPropagation();
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
    
                var total_length = $('.check-hindsight').length;
                var total_checked_length = $('.check-hindsight:checked').length;
    
                if (total_length == total_checked_length) {
                    $(".check_all").prop( "checked", true );
                } 
           
           if(showThis == 1){
               $('.delete-hindsight').prop('disabled', false).css({opacity:'1'});
           }
           else{
               $('.delete-hindsight').prop('disabled', true).css({opacity:'0.2'});
               $(".check_all").prop( "checked", false );
           }
           
       });
    
    
     $('body').on('click','.delete-hindsight',function(){
         
          bootbox.dialog({
                title: "Confirm Deletion",
                message: "Are you sure you want to delete ?",            
                buttons: {
                    success: {
                        label: "Yes",
                        className: "btn-black",
                        callback: function() {
         
                             $('.loading').show();  
                             var data_val = '';
                             $('.check-hindsight').each(function(){ 
                                   $this = $(this);
                                   if($this.is(':checked', true)){
                                    if( data_val ==''){
                                      data_val = $this.val();
                                    }else{
                                       data_val = data_val+"~"+ $this.val();
                                    }
                                   }
                                   
                              });
    
                              jQuery.ajax({
                                   url:'<?php echo $this->webroot?>askQuestions/deleteQuestion/',
                                   data:{
                                      
                                     'data_val':data_val,                                   
                                   },
                                   type:'POST',
                                   success:function(data){
                                      $('.loading').hide();  
                                      $('.check-hindsight').each(function(){ 
                                          $this = $(this);
                                          if($this.is(':checked', true)){
                                             $this.closest('tr').remove();
                                          }
                                      });

                                       var rowCount = $('.table-condensed >tbody >tr').length;
                                       if(rowCount)
                                       {
                                             $('.delete-hindsight').prop('disabled', true).css({opacity:'0.2'});
                                           
                                       }
                                       else
                                       {
                                           $('.delete-hindsight').hide();
                                           $(".check_all").prop( "checked", false );
                                       }


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
    
       $('body').on('click','.check_all',function(e){
        e.stopPropagation();
          $this = $(this);
    
                  if($this.is(':checked', true)){
                    $('.check-hindsight').prop( "checked", true );
                     $('.delete-hindsight').prop('disabled', false).css({opacity:'1'});
               
               }else{
                  $('.check-hindsight').prop( "checked", false );
                    $('.delete-hindsight').prop('disabled', true).css({opacity:'0.2'});
               }
    
               // $('.check-hindsight').trigger('click');
          
    
       });
    });
</script>
<!-- <div class="modal fade" id="discussion-submit" tabindex="-1"  style="top:20%;" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true"  >&times;</button> 
                <h4 class="modal-title" id="myModalLabel">Success Message</h4>
            </div>
            <div class="modal-body"><p>Thank you!! Your Question has been sent to Entropolis HQ and we will connect you with some great advice and hindsight wisdom shortly.</p>
            </div>
            <div class="modal-footer model-footer1 my_challenge">
                <button type="button" class="btn btn-black" data-dismiss="modal" onclick = "window.location.reload();">Okay</button>
            </div>
        </div>
    </div>
</div> -->
