<div class="page-loading-ajax" style="color:red; display:none"><?php echo $this->Html->image('loading-upload.gif'); ?></div>
<script>
    jQuery(document).ready(function () {

        /*------------- Start to get wisdom modal data ------------------*/
        jQuery("#buttonClose").click(function () {
            if ($('#broadcast-popup.modal').hasClass('in')) {
                jQuery("body").css("overflow", "");
            }
        });

        jQuery('body').on('click', '.get-data-broadcast-modal', function (e, obj_id, obj_type) {
            e.stopPropagation();
            var $this = jQuery(this);
            var obj_id = $this.data("id");
            var obj_type = $this.data('type');
            $this.removeClass('active');
            $("#broadcast-popup").data("id", obj_id);
            $(".set-data-wisdom").data("id", obj_id);
            jQuery(".get-wisdom-endorsement").data("id", obj_id);
            jQuery(".get-wisdom-endorsement").data("type", obj_type);

            /*$('body').on('click', '.remove-scroll tr td', function () {
                $('body').css("overflow", "hidden")
            });*/

            /*$('body').on('click', '.update-view-status', function () {
                $('body').css("overflow", "hidden")
            });*/

            if ($this.hasClass("set-data-wisdom")) {
                $('.page-loading-ajax').height($(window).height());
                $('.page-loading-ajax').show();
            } else {
                $('.page-loading').height($(window).height());
                $('.page-loading').show();
            }
            jQuery("#broadcast-popup").find('.advice-data').addClass('active');
            //jQuery("#broadcast-popup").find('.endrose-data').removeClass('active');
            //jQuery("#broadcast-popup").find('.profile-data').removeClass('active');

            $this.find('.add-new-notification').remove();

            jQuery.ajax({
                type: 'POST',
                url: '<?php echo $this->webroot ?>BroadcastMessages/getBroadcastModal/',
                data: {'obj_id': obj_id, 'obj_type': obj_type},
                success: function (data) {
                    $("#broadcast-popup").find('#wisdom-advice').addClass('active in');

                    $("#broadcast-popup").find('#wisdom-endorsements').removeClass('active in');

                    if ($this.hasClass("set-data-wisdom")) {
                        $('.page-loading-ajax').hide();
                    } else {
                        $('.page-loading').hide();
                    }
                    $("#broadcast-popup").modal('show');
                    $("#broadcast-popup").find('.tab-content #wisdom-advice').html('');
                    $("#broadcast-popup").find('.tab-content #wisdom-advice').html(data);
                    setTimeout(function () {
                        var main_div = jQuery("#broadcast-popup").find('.tab-content .wisdom-advice-data .advice_user_id').height();


                        var inner_div = jQuery("#broadcast-popup").find('.tab-content .wisdom-advice-data .advice_user_id .profile-img-blck').height();

                    }, 500);

                    if (jQuery("#wisdom-advice").find('.advice_user_id').data('context') == null) {
                        jQuery("#broadcast-popup").find(".get-seeker-profile").data("id", jQuery("#broadcast-popup").find(".get-seeker-profile").data("id"));
                    } else {
                        jQuery("#broadcast-popup").find(".get-seeker-profile").data("id", jQuery("#wisdom-advice").find('.advice_user_id').data('context'));
                    }

                    $(":file.custom-filefield").filestyle({buttonBefore: true});

                    var sage_name = jQuery("#broadcast-popup").find('.wisdm-name-for').val().trim();

                    jQuery(".modal-sage-name").text(sage_name);
                    jQuery(".inviter_user_id").val(jQuery(".advice_user_id").data("userid"));

                    containerHeight('.containerHeight');
                    customScroll();


                }
            });
        });

        /*code here start to add library*/

        jQuery('body').on('click', '.attach-wisdom-library', function (e) {
            var $this = $(this);
            var object_type = $this.data('type');
            var object_id = $this.data('id');
            var owner_user_id = $this.data('owner');
            $('.page-loading-ajax').show();

            $.ajax({
                type: 'POST',
                url: '<?php echo $this->webroot ?>myLibrarys/addToLibrary/',
                data: {
                    'object_type': object_type,
                    'object_id': object_id,
                    'owner_user_id': owner_user_id

                },
                success: function (data) {
                    $('.page-loading-ajax').hide();

                    if (data == 1) {

                        var msg = '<p>This article has been already saved to your favourites.</p>';

                        jQuery("#wisdom-library-msg").modal('show');
                        jQuery(".wisdom-fav").html(msg);

                        if ($('#wisdomadvice-popup.modal').hasClass('in')) {
                            $('body').css({overflow: 'hidden'});
                        }

                    } else {
                        var msg = '<p>This article has been saved to your favourites.</p>';
                        jQuery("#wisdom-library-msg").modal('show');
                        jQuery(".wisdom-fav").html(msg);

                        if ($('#wisdomadvice-popup.modal').hasClass('in')) {
                            $('body').css({overflow: 'hidden'});
                        }
                    }
                }
            });
        })
        /*end add library function here*/

        /*-----------Start to delete hindsight details ------------*/
        $('#broadcast-popup').on('click', '.delete-detail', function () {
            var wrap = $(this).closest('.textarea-editor'),
                    objId = wrap.data('id'),
                    datas = {'objId': objId};
            if (objId > 0) {
                bootbox.dialog({
                    title: "Confirm Deletion",
                    message: "Are you sure you want to delete ?",
                    buttons: {
                        success: {
                            label: "Yes",
                            className: "btn-black",
                            callback: function () {
                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo $this->webroot ?>DecisionBanks/deleteDetail',
                                    data: datas,
                                    success: function (resp) {
                                        if (resp == 1) {
                                            wrap.remove();
                                        } else {
                                            bootbox.alert({
                                                title: 'Error!!',
                                                message: 'Sorry! record did not delete.'
                                            });
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
            } else {
                wrap.remove();
            }
        });
        /*-----------End to delete hindsight details ------------*/
    });

    

    /*end endorsement function here*/
    jQuery('body').on('click', ".wisdom-share-button", function (e) {
        $this = $(this);
        var object_id = $this.data("id");
        var object_type = $this.data("type");
        var kk = $('.share-button-data').html();
        jQuery('.wisdom-share-button-image').html('');
        jQuery('.wisdom-share-button-image').html(kk);

        $('.wisdom-share-button-image').find(".FB-icon").attr('onclick', 'share(' + object_id + ',"' + object_type + '","facebook")');
        $('.wisdom-share-button-image').find(".TW-icon").attr('onclick', 'share(' + object_id + ',"' + object_type + '","twitter")');
        $('.wisdom-share-button-image').find(".LIK-icon").attr('onclick', 'share(' + object_id + ',"' + object_type + '","linked")');
    });
    
    jQuery('body').on('click', '#submitBroadcast', function (e) {
            e.preventDefault();
            var message_type = jQuery(this).data('message_type');
            var broadcastid = jQuery(this).data('broadcastid');
           
            $("#new-advice .page-loading-modal").show();


            SaveBroadcast(message_type,broadcastid);
        });

    jQuery('body').on('click', '#save_broadcastdraft', function (e) {
            e.preventDefault();
            var message_type = jQuery(this).data('message_type');
            var broadcastid = jQuery(this).data('broadcastid');          

             jQuery("#save-broadcast-as-draft").modal('show');
             jQuery(".broadcastdraft").data('message_type',message_type);
             jQuery(".broadcastdraft").data('broadcastid',broadcastid)
        });

       jQuery('body').on('click', '#confirmChanges', function (e) {
            e.preventDefault();
             var broadcastid = jQuery(this).data('broadcastid');   
           //  alert('v'+broadcastid)
            if(broadcastid)
            {
                location.reload();
            }
        });

// for admin suggestion
$('body').on('click','.load-more-broadcast-post' , function(){

    var $this = jQuery(this);
  
    var actiontype = $this.data('actiontype');
    var remainingcount = $this.data('remainingcount');
    var offset = $this.data('offset') ;
    var loadcount =  $this.data('loadcount') ;
  //  alert(remainingcount);
  $.ajax({
        url:'<?php echo Router::url(array('controller'=>'BroadcastMessages', 'action'=>'loadMoreBroadcastPost'));?>',
        data:{
          
          'offset':offset,         
          'actiontype':actiontype         
        },
        type:'post',
        success:function(data){ 
          //jQuery('#ask-Question').find('.tab-pane.active .forum-wrap.add-post-data1:last').after(data);
          var div_elm =  jQuery('#suggestionBoxLink').find('.tab-pane.active .add-post-data div.post-container:last').after(data);
          //  jQuery(data).insertAfter(div_elm);
          remaining_cc = remainingcount - loadcount;
          //alert(remaining_cc);
          off_set  = offset + loadcount;
          $this.data("remainingcount",remaining_cc);
          $this.data("offset",off_set);
          if(remaining_cc <=0)
          {
            $this.hide();
          }
        }
        
    });

});

function SaveBroadcast(message_type,broadcastid)
{

    var datas = jQuery('#broadcastForm').serialize();
    $.ajax({
                url: "<?php echo Router::url(array('controller' => 'BroadcastMessages', 'action' => 'add_message')) ?>",
                data: datas+ '&message_type=' + message_type+ '&broadcastid='+broadcastid,
                type: 'POST',
                success: function (data) {
                //    alert(data)
                    $("#new-advice .page-loading-modal").hide();
                    if (data.result == "error") {
                        jQuery("#broadcast-title-val").nextAll().remove();
                        jQuery("#cke_broadcast_message_id").nextAll().remove();
                        
                        if (data.error_msg.title !== undefined && data.error_msg.title[0] != '') {
                            jQuery("#broadcast-title-val").after('<div class="error-message">' + data.error_msg.title[0] + '</div>');
                        }
                        if (data.error_msg.message !== undefined && data.error_msg.message[0] != '') {
                            jQuery("#cke_broadcast_message_id").after('<div class="error-message">' + data.error_msg.message[0] + '</div>');
                        }
                    } 
                    else {
                        $("#new-advice").modal('hide');
                        
                        if(message_type =='publish')
                        {
                            jQuery("#thanks-broadcast-add").modal('show');
                           //alert(broadcastid+'          '+message_type);
                            if(broadcastid)
                            {
                            jQuery("#thanks-broadcast-add #confirmChanges").data('broadcastid',broadcastid);
                            }
                        }
                      
                        else if(message_type =='republish' )
                        {
                            jQuery("#thanks-broadcast-updated").modal('show');
                            jQuery("#thanks-broadcast-updated #confirmChanges").data('broadcastid',broadcastid);
                           // alert(broadcastid);


                        }
                         else if(message_type =='update' )
                        {
                             location.reload();
                        }
                            
                        // if(broadcastid)
                        // {
                        //     location.reload();
                        // }

                    }
                }
            });
}

$('body').on('click','.delete-broadcast-post' , function(){

    var $this = jQuery(this);
    var broadcastid = $this.data('broadcastid');

           getHtml = '<div>Are you sure you want to delete this Broadcast message?</div>';
           bootbox.dialog({
                   title: "Confirm Deletion",
                   message: getHtml,
                   buttons: {
                       success: {
                           label: "Yes",
                           className: "btn-black",
                           callback: function() {
                              $.ajax({
                                 type: 'POST',
                                 url : '<?php echo Router::url(array('controller'=>'BroadcastMessages', 'action'=>'deleteBroadCastPost'));?>',
                                 data:{
                                    'broadcastid':broadcastid,
                                  },
                                
                                success:function(resp) {
                                    if(resp==1){
                                        $this.closest('.post-container').remove();
                                        var countBraod=$(".post-suggestions-container").length;
                                    if(countBraod <= 10){
                                    $(".load-more-broadcast-post").not('hide').addClass("hide");
                                    }
                                    else{
                                        $(".load-more-broadcast-post").not('hide').removeClass("hide");
                                    }
                                    }
                                    //$this.remove();
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
    
</script>
<div aria-hidden="false" aria-labelledby="myModalLabel"  role="dialog" tabindex="-1" id="broadcast-popup" class="modal fade right right_flyout broadcast-popup">
    <div class="modal-dialog advice-slide-wrap">
        <div class="modal-content">
            <div class="modal-header top-section">
                <div class="row">
                    <div class="col-md-12">
                        <form role="form">
                            <div class="form-group search-bar">
                                <button data-dismiss="modal" id="buttonClose" class="close" type="button"><i class="icons close-icon"></i></button>
                                <ul class="dash_profileTab credStreet_viewProfileTab">
                                    <li  class="active advice-data"><a href="#broadcast-advice" data-toggle="tab" class="get-data-broadcast-modal set-data-wisdom" data-id="">BROADCAST MESSAGE</a></li>
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="bs-example advice-tabs">
                    <div class="tab-content">
                        <div id="wisdom-advice" class="tab-pane fade  active  wisdom-advice-data"></div>
                        <div id="wisdom-endorsements" class="tab-pane fade wisdom-endorsement-data"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
