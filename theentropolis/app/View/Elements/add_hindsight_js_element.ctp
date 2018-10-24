<script type="text/javascript">

 function clearHindsightAll(){
    $('#Userchallangeinfo').find("#category_id").nextAll().remove();
   $('#Userchallangeinfo').find("#decision_type_id").nextAll().remove();
    $('#Userchallangeinfo').find("#datepicker").nextAll().remove();
    $('#Userchallangeinfo').find("#hindsight_title").nextAll().remove();
     $('#Userchallangeinfo').find("#outcome").nextAll().remove();
}

$('.submitHindsightFrm').click( function(e){ 
          e.preventDefault();
	      var datas=$('#Userchallangeinfo').serialize();
          var network_type;
		  var share_type = $(this).attr('data-share-type');
          if($("input[type='radio'].radioBtnClass").is(':checked')) {
            network_type = $("input[type='radio'].radioBtnClass:checked").val();
        }
            
        if(share_type == "blog"){
			var addintional = 'network_type=' + network_type;
        	datas = datas + '&' + addintional + '&data_share_type=' +share_type; 
		}else{
			var addintional = 'network_type=' + network_type;
        	datas = datas + '&' + addintional;    
		}
	
          $.ajax({
           url:'<?php echo $this->webroot?>DecisionBanks/add_ajax/',
           data:datas,
           type:'POST',
           success:function(data){ 
        

               if(data.result=="error")
               {
                    clearHindsightAll();
                   
                   if(data.error_msg.hindsight_decision_date !== undefined && data.error_msg.hindsight_decision_date[0]!=''){
                       $('#Userchallangeinfo').find("#datepicker").after('<div class="error-message">'+data.error_msg.hindsight_decision_date[0]+'</span>');
                   }
                   if(data.error_msg.category_id !== undefined && data.error_msg.category_id[0]!=''){
                           $('#Userchallangeinfo').find("#category_id").after('<div class="error-message">'+data.error_msg.category_id[0]+'</span>');
                   }
                   if(data.error_msg.decision_type_id !== undefined && data.error_msg.decision_type_id[0]!=''){
                          $('#Userchallangeinfo').find("#decision_type_id").after('<div class="error-message">'+data.error_msg.decision_type_id[0]+'</div>');
                   }
                   if(data.error_msg.hindsight_title !== undefined && data.error_msg.hindsight_title[0]!=''){
                       $("#hindsight_title").after('<div class="error-message">'+data.error_msg.hindsight_title[0]+'</div>');
                   }
                    if(data.error_msg.outcome !== undefined && data.error_msg.outcome[0]!=''){
                       $("#outcome").after('<div class="error-message">'+data.error_msg.outcome[0]+'</div>');
                   }
                     setTimeout(function() {
                                $("#hindsight .mCustomScrollbar").mCustomScrollbar('scrollTo', '0');
                     }, 100)
               }    
               else
               { 
                   //alert(data.decision_data.name);
                  clearHindsightAll();     
                  //$('#Userchallangeinfo').find("#hindsight_id").val("");
                  $('ul.tabs li').removeClass('active');
                       $('#' + data.decision_data.name + '-tab').closest('li').addClass('active');
                   $("#Userchallangeinfo").get(0).reset();

                     
                    $("#hindsight").modal('hide');
                  
                     
                  // getListData(data.decision_data.name, data.decision_data.id, 'tab', 0);
                   //window.location.reload(true);
                  //var currentElm = $(this);
                 // showShareModal(currentElm);

                        $("#submit-hindsight").modal('hide');
                        jQuery("#thanks-hindsight-add").data('tabname', data.decision_data.name);
                        jQuery("#thanks-hindsight-add").data('tabid', data.decision_data.id);
                       jQuery("#thanks-hindsight-add").modal('show');
                  
               } 
           },
           error: function(jqXHR, textStatus, error) {
              var currentElm = $(this);
                  showShareModal(currentElm);
                  $("#hindsight").modal('hide');
                  console.error(jqXHR, textStatus, error);
           }
           
       });
           
    });

//       $('body').on('click','#confirmadvice',function(){
// // window.location="<?php echo Router::url(array('controller' => 'decisionBanks', 'action' => 'dashboard')) ?>";
// window.location.reload();
//       $("#hindsight").modal('hide');
   

// });

      /*function here to save article in library and hindsight as draft*/
    
    
     $('#submitHindsightAsDraft').click( function(e){ 

          e.preventDefault();
          var datas=$('#Userchallangeinfo').serialize();
          
          
        //  DecisionBankIndexForm
          $.ajax({
           url:'<?php echo $this->webroot?>DecisionBanks/addHindsightAsDraft/',
           data:datas,
           type:'POST',
           success:function(data){ 
               if(data.result=="error")
               {
                   $('#Userchallangeinfo').find("#category_id").nextAll().remove();
                   $('#Userchallangeinfo').find("#decision_type_id").nextAll().remove();
                   $('#Userchallangeinfo').find("#datepicker").nextAll().remove();
                   $("#hindsight_title").nextAll().remove();
                   $("#outcome").nextAll().remove();
                   
                   if(data.error_msg.hindsight_decision_date !== undefined && data.error_msg.hindsight_decision_date[0]!=''){
                           $('#Userchallangeinfo').find("#datepicker").after('<div class="error-message">'+data.error_msg.hindsight_decision_date[0]+'</span>');
                   }
                   if(data.error_msg.category_id !== undefined && data.error_msg.category_id[0]!=''){
                           $('#Userchallangeinfo').find("#category_id").after('<div class="error-message">'+data.error_msg.category_id[0]+'</span>');
                   }
                   if(data.error_msg.decision_type_id !== undefined && data.error_msg.decision_type_id[0]!=''){
                           $('#Userchallangeinfo').find("#decision_type_id").after('<div class="error-message">'+data.error_msg.decision_type_id[0]+'</div>');
                   }
                   if(data.error_msg.hindsight_title !== undefined && data.error_msg.hindsight_title[0]!=''){
                       $("#hindsight_title").after('<div class="error-message">'+data.error_msg.hindsight_title[0]+'</div>');
                   }
                   if(data.error_msg.outcome !== undefined && data.error_msg.outcome[0]!=''){
                       $("#outcome").after('<div class="error-message">'+data.error_msg.outcome[0]+'</div>');
                   }
                   setTimeout(function() {
                          $("#hindsight .mCustomScrollbar").mCustomScrollbar('scrollTo', '0');
                  }, 100)
               }    
               else
               { 
    
                  $('ul.tabs li').removeClass('active');
                  jQuery('.row-wrap').remove();
                  $('#'+data.decision_data.name+'-tab').closest('li').addClass('active'); 
                  $("#user_id option[value='']").attr("selected","");
                  $("#user_id option[value='<?php echo $this->Session->read('context_role_user_id'); ?>']").attr("selected","selected");
                   $('#Userchallangeinfo').find("#category_id").nextAll().remove();
                   $('#Userchallangeinfo').find("#decision_type_id").nextAll().remove();
                   $('#Userchallangeinfo').find("#datepicker").nextAll().remove();
                   $("#hindsight_title").nextAll().remove();
                   $("#Userchallangeinfo").get(0).reset();
                   
                   $('.uploading-data').hide();
                   $('.hindsight_description_editor').val('');
                   $('.short_description_editor').val('');
                   $('.hindsight_detail_editor').val('');
                   $('.hind-sights.maintain-count-value').remove();
                   $("#hindsight").modal('hide');
                   jQuery("#thanks-draft-hindsight-add").modal('show');

               } 
           }
           
       });
               
        });

// $('#submit-hindsight').on('click', '#submitHindsightFrmSuccess', function() {
//     jQuery("#thanks-hindsight-add").modal('show');
// });

     </script>