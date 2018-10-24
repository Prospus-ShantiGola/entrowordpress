<div class="modal fade groupchat-popup  right_flyout"  id="groupchat-popup" data-id = "" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog advice-slide-wrap" >
        <div class="modal-content groupdetail-message">
            



        </div>
    </div>
</div>
<div class="modal fade custom-popup yellow-popup" id="thanks-groupinvitation" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-groupinvitation').modal('hide');"  aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">NICE NETWORKING!</h4>
            </div>
            <div class="modal-body ">
                <p>An invitation to join your group in Entropolis has been sent to all recipients. Once they accept, you can chat, share idea’s & work together! </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-black"  onclick = "javascript:jQuery('#thanks-groupinvitation').modal('hide');" >OK</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="thanks-group-message" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick = "javascript:jQuery('#thanks-group-message').modal('hide');" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">MESSAGE SENT!</h4>
            </div>
            <div class="modal-body ">
                <p>Your message has been sent to  to all recipients<b><span class= "modal-sage-name"></span></b></p>
            </div>
            <div class="modal-footer">
            
                <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-group-message').modal('hide');" >OK</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
// groupchat-popup

$('.get-group-detail').on('click',function(e){
  if(e.target.classList.contains('manage-group-invitation-status')){
    return true;
  }
           // e.stopPropagation();
        //e.preventDefault();
// alert('sa')

$this = $(this) ; 

var obj_type = $this.data('type');
var obj_id = $this.data('id');

jQuery.ajax({
                type: 'POST',
                url: '<?php echo $this->webroot ?>GroupDetails/getGroupDetail/',
                'data':
                        {
                            'obj_id': obj_id,
                            'obj_type': obj_type
                        
                        },
                'success': function (data)
                {

                  $('#groupchat-popup').modal('show');
                  $('#groupchat-popup .groupdetail-message').html(data);
                    // var group_name =  $('#groupchat-popup .groupdetail-message').find('.group-detail-info').data('groupname');
                    // var group_other_member = $('#groupchat-popup .groupdetail-message').find('.group_detail-wrap').data('memberary');
                    // $('#groupchat-popup').find('.group-name-class').text(group_name)
                    // $('#groupchat-popup').find('.open-group-feature-modal').data('groupid', obj_id);
                    // $('#groupchat-popup').find('.open-group-feature-modal').data('groupmemberid', group_other_member);
                    // $('#groupchat-popup').find('.open-group-feature-modal').data('groupname', group_name);
          jQuery(window).resize();
                }
        });

});


 $('body').on('submit', '#sendGroupMessage', function (event) {

        // jQuery("#send_message").submit(function(event){
        event.preventDefault();
        var isSendMsgFromPopup = $(event.currentTarget).closest('#sendMessagePopup').length;
        if(!isSendMsgFromPopup) {
            $('.page-loading-ajax').show();
        }
        var datas = $(this).serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo $this->webroot ?>GroupDetails/sendGroupMessage',
            data: datas,
            success: function (resp) {

                $('.page-loading-ajax').hide();
                if (resp) {
                    // var userName = $('#sendGroupMessage .modal-sage-name').text();
                   // alert(userName);

                   if($('#groupchat-popup .group_detail-wrap .message-list').length ==0)
                   {  
                  //  alert('df')
                          $('.no-message-data').remove();
                          $( "#groupchat-popup .group_detail-wrap .message-head" ).after(resp );
                         
                   }
                   else
                   {
                     $( "#groupchat-popup .group_detail-wrap .message-list:last" ).after(resp );
                   }
 
                   // $('#groupchat-popup .group_detail-wrap .list-info').
                    $('#sendMessagePopup').modal('hide');   
                    $(".show-detail.mail").css('display', 'none');
                    $('.bottom-icon a').children('img').removeClass('img-border');
                  //  $("#thanks-group-message").find('.modal-sage-name').text(userName);
                    // $("#thanks-group-message").modal('show');
                    $("#sendGroupMessage").get(0).reset();
                    $("#sendGroupMessage #message").val('')
                    $('.mail').removeClass('elmOpen');
                } else {
                    return false;
                }

                if ($('#add-to-group').hasClass('in'))
                {
                    $('body').css({overflow: 'hidden'});
                } else {

                }
            }
        });
    });


  $('body').on('submit', '#send_group_invitation', function (event) {
   event.preventDefault();
        $this = $(this);
 
    var action_type = $('#add-to-group .send_group_invitation').find('.action_type').val()
     var conversation_type = $('#add-to-group .send_group_invitation').find('.conversation_type').val()
    $('.send_group_invitation').find('.error-message').remove();
        if( $('.user_id_member').val() == null )
        {
               $(".tokenize").after('<div class="error-message">Please select atleast one user</div>');
               return false;
        }
        
     
        var datas = $(this).serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo $this->webroot ?>GroupDetails/sendGroupInvitation',
            data: datas,
            success: function (resp) {
                
                if (resp.result == 'success') {


                    $("#thanks-invitation").find('.modal-sage-name').text(jQuery("#add-to-network").find('.modal-user-name').text());

                    if(action_type == 'Edit')
                    {
                     
                        var group_name = $('#add-to-group .send_group_invitation').find('#group_name').val();
                        group_other_member = '';
                         member_name = '';
                        div_html ='';
                       var  group_detail_id  =  $('#add-to-group .send_group_invitation').find('.group_id_data').val()
                       // alert( $('#add-to-group .send_group_invitation').find('.tokenize .tokens-container .token').length)
                       $('#add-to-group .send_group_invitation').find('.tokenize .tokens-container .token').each(function ()
                        {   //&&  current_obj == $(this).data("objid")

                            var id  = $(this).data('value');
                            var user_name = $(this).find('span').text();
                            var combine_value = id+'-'+user_name;
                            
                            group_other_member += combine_value+',';
                            div_html +='<div class="member-lst">'+user_name+'</div>';
                            member_name += user_name+',';
                        });

                       if(conversation_type =='')
                       {
                            div_html +='<div class="member-lst"> </div>';
                            
                            $('#groupchat-popup').find('.memberlstn .member-lst').remove();
                            $('#groupchat-popup').find('.memberlstn').prepend(div_html);
                           //   alert(group_other_member);
                            $('#groupchat-popup').find('.open-group-feature-modal').data('groupmemberid', group_other_member);
                            $('#groupchat-popup').find('.open-group-feature-modal').data('groupname', group_name);
                         //   alert(group_detail_id)

                            $('#people-filter-tab-teacher .get-group-detail').each(function (){
                              var obj  = $(this);
                               if(obj.data("type") == 'group_invitation' && obj.data("id") == group_detail_id)
                                {        
                                   //alert('fdf');   
                                  member_name =  member_name.trim(',');   
                                  // alert(member_name);           
                                    obj.find('.list-profile-detail .group_member_list').text(member_name);

                                }

                            });
                           
                       }
                         

                         $('#add-to-group').modal('hide')
                        $("#thanks-groupinvitation").modal('show');
                         $('.clear_modal_data').trigger('click');
                    }
                    else
                    {
                       $('#add-to-group').modal('hide')
                        $("#thanks-groupinvitation").modal('show');

                       $('.clear_modal_data').trigger('click');
                    }
              }

            }
            })

})


 // $('body').on('keyup focus', '.token-search', function (event) {
 // var search_element  = $(this).find("input").val();
 //   // alert(search_element)
 //      $.ajax({
 //                        url: './GroupDetails/fetchUserName',
 //                        data: {
 //                            search_element :search_element
 //                        },
 //                        type: 'POST',
 //                        success: function(response) {

 //                             $('.tokenize-sample-demo1').html(response);
 //                        //    li_html = '<ul class="dropdown-menu"><li class="token" data-value="1"><a class=" dismiss"></a><span>art</span></li></ul>';
 //                          //  li_html = '<a data-value="886" data-text="sagne2(clove)">';
 //                          //  $('.tokenize-dropdown').html(li_html);
 //                            // <div class="tokenize-dropdown dropdown"><ul class="dropdown-menu" /></div>
                     
 //                          }
 //                       });
 // })

  $('body').on('click', '.open-group-feature-modal', function (event) {

   // alert('dsad');
     $this = $(this);
         var groupid =  '';
         var temp ='';
          var group_name ='';
          var conversation = '';
          var groupadmin = '';
      
       var data_action =  $this.data('action');
    

    
         // fetchUserName();

          $.ajax({
              url: './GroupDetails/fetchUserName',
              data: {
            search_element :''
              },
              type: 'POST',
              success: function(response) {

                     $('#add-to-group').modal('show');
                     $('.tokenize-sample-demo1').html(response);





                      if(data_action =='Edit')
                      {
                         $('.tokens-container .placeholder').css('display','none');
                          var groupid =  $this.data('groupid');
                            var groupadmin =  $this.data('groupadmin');
                       
                          var group_name =  $this.data('groupname');
                           var conversation =  $this.data('conversation');
                          var temp  =  $this.data('groupmemberid').split(',');


                          $('#add-to-group .send_group_invitation').find('.tokenize .tokens-container .new-user-list').remove();
                       
                          var  li_html='';
                          for(i =0 ; i< temp.length;i++)
                          {
                              if( temp[i] !='')
                              {
                                var member = temp[i].split('-');
                               
                               
                            
                                if(conversation =='New')
                                {
                                        if(groupadmin == member[0])
                                        {
                                           var class_elm = '';
                                        }
                                        else
                                        {
                                           var class_elm = 'dismiss leave_network_group conversation';
                                        }
                                }
                                else
                                {
                                   if(groupadmin == member[0])
                                        {
                                           var class_elm = '';
                                        }
                                        else
                                        {
                                           var class_elm = 'dismiss leave_network_group';
                                        }
                                }


                                li_html += '<li class="token new-user-list" data-value="'+member[0]+'"><a class="'+class_elm+'"  data-id = "'+groupid+'" data-type ="remove"></a><span>'+member[1]+'</span></li>';
                                 

                                 $('#add-to-group .send_group_invitation').find('.user_id_member option[value='+member[0]+']').attr('selected','selected');
                              }
                              
                             
                          }

                          if(conversation =='New')
                          {
                             $('#add-to-group .send_group_invitation').find('#group_name').val();
                             $('#add-to-group .send_group_invitation').find('#comment_text').hide();

                            conversation =  $this.closest('.list-info').data('messageid');
                          }

                          else
                          {
                               $('#add-to-group .send_group_invitation').find('#group_name').val(group_name);
                          }

                          $('#add-to-group .send_group_invitation').find('.tokenize .tokens-container').prepend(li_html);

                       
                          $('#add-to-group .send_group_invitation').find('#comment_text').hide();



                   }

                          $('#add-to-group .send_group_invitation').find('.action_type').val(data_action)
                          $('#add-to-group .send_group_invitation').find('.group_id_data').val(groupid)
                           $('#add-to-group .send_group_invitation').find('.conversation_type').val(conversation);

              }
          });
     
         
                   
    
      
     
  })  
       
  
        $('body').on('click', '.leave_network_group', function (event) {
            $this = $(this);
            var obj_type = $this.data('type');
            var obj_id = $this.data('id');
            var member_id =  $this.closest('.token').data('value');
            if($this.hasClass('conversation'))
            {

              
                   $('#add-to-group .send_group_invitation').find('.user_id_member option[value="'+member_id+'"]').removeAttr('selected');
                   $this.closest('.token').remove();
            }else
            {


             $.ajax({
                                type: 'POST',
                                url: '<?php echo Router::url(array('controller' => 'GroupDetails', 'action' => 'GroupinvitationStatus')); ?>',
                                data: {

                                    'invitation_id': obj_id,
                                    'status': obj_type,
                                    'user_id':member_id

                                },
                                success: function (resp) {

                                 
                              

                                    $('#add-to-group .send_group_invitation').find('.user_id_member option[value="'+member_id+'"]').removeAttr('selected');
                                    $this.closest('.token').remove();
                                      group_other_member = '';
                                      var div_html = '';
                                     $('#add-to-group .send_group_invitation').find('.tokenize .tokens-container .token').each(function ()
                                        {   //&&  current_obj == $(this).data("objid")

                                            var id  = $(this).data('value');
                                            var user_name = $(this).find('span').text();
                                            var combine_value = id+'-'+user_name;
                                            
                                            group_other_member += combine_value+',';
                                            div_html +='<div class="member-lst">'+user_name+'</div>';
                                            
                                        });
                                      div_html +='<div class="member-lst"> </div>';
                                      $('#groupchat-popup').find('.open-group-feature-modal').data('groupmemberid', group_other_member);
                                      $('#groupchat-popup').find('.memberlstn .member-lst').remove();
                                      $('#groupchat-popup').find('.memberlstn').prepend(div_html);
                      
                                }
                                });
}
        });
       


function fetchUserName(search_element)
{
    var search_element  = 'a';
    // alert('dsad')
      $.ajax({
                        url: './GroupDetails/fetchUserName',
                        data: {
                            search_element :search_element
                        },
                        type: 'POST',
                        success: function(response) {

                          
                     
                          }
                       });
                           }


  $('body').on('click','.clear_modal_data',function(){
   

     $('.send_group_invitation')[0].reset();
     $('#add-to-group .send_group_invitation').find('.tokenize .tokens-container .token').remove();
      $('#add-to-group .send_group_invitation').find('.user_id_member option:selected').attr('selected','');
      //$(".tokenize").after('<div class="error-message">This field is required</div>').remove();
       $('.send_group_invitation').find('.error-message').remove();
       $('#add-to-group').modal('hide')
  })                         
//# sourceURL=group_js_element1.ctpjs
</script>
